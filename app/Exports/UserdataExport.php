<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Client;
use App\Models\Cart;
use App\Models\Store;
use App\Models\Customer;
use App\Models\UserActivity;
use App\Models\StoreDeliveryDetail as StoreDelivery;

use DB;
use Carbon\Carbon;
use DateTime;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserdataExport implements FromCollection, ShouldAutoSize, WithHeadings
{

    protected $from;
    protected $to;

    function __construct($from, $to) {
            $this->from = $from;
            $this->to = $to;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $datas = Customer::select('customer.*')
                            ->whereBetween('customer.created', [$this->from, $this->to." 23:59:59"])  
                            ->orderBy('customer.created', 'DESC')
                            ->get();
        //dd($datas);
        $newArray = array();
        $storeList = array();

        foreach ($datas as $data) {
                
            $storeName = '';
                if (! array_key_exists($data['storeId'], $storeList)) {
                    $store_info = Store::where('id', $data['storeId'])
                                        ->get();
                    if (count($store_info) > 0) {
                        $storeList[$data['storeId']] = $store_info[0]['name']; 
                        $storeName = $storeList[$data['storeId']];
                    }    

                } else {
                    $storeName = $storeList[$data['storeId']];
                }

                //check for Abandon cart
                $sql="SELECT*FROM `cart` WHERE customerId='".$data['id']."'";
                $rsitem = DB::connection('mysql2')->select($sql);
                if (count($rsitem)>0) {
                    $itemCart="YES";
                } else {
                    $itemCart="NO";
                }

                //check for Order Completed
                $sql="SELECT*FROM `order` WHERE completionStatus<>'RECEIVED_AT_STORE' AND customerId='".$data['id']."'";
                $rsordercomplete = DB::connection('mysql2')->select($sql);
                if (count($rsordercomplete)>0) {
                    $orderCompleted="YES";
                } else {
                    $orderCompleted="NO";
                }

                //check for Order Incompleted
                $sql="SELECT*FROM `order` WHERE completionStatus = 'RECEIVED_AT_STORE' AND customerId='".$data['id']."'";
                $rsorderIncomplete = DB::connection('mysql2')->select($sql);
                if (count($rsorderIncomplete)>0) {
                    $orderIncomplete="YES";
                } else {
                    $orderIncomplete="NO";
                }

            
            $object = [
                'storeName' => $storeName,
                'name' => $data['name'],
                'email' => $data['email'],
                'phoneNumber' => $data['phoneNumber'],
                'itemCart' => $itemCart,
                'orderCompleted' => $orderCompleted,
                'orderIncomplete' => $orderIncomplete,
            ];
        
            
            array_push( 
                $newArray,
                $object
            );
        
        }
        return new Collection($newArray);
    }

    public function headings(): array
    {
        return [
            'Customer Name',
            'Store Name',
            'Email Address',
            'Phone Number',
            'Abandon Cart',
            'Completed Order',
            'Incompleted Order',
        ];
    }
}
