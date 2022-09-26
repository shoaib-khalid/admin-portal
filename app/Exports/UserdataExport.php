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
use Session;
use Carbon\Carbon;
use DateTime;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserdataExport implements FromCollection, ShouldAutoSize, WithHeadings
{


    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //query by Customer
        $selectedCountry = Session::get('selectedCountry');
        
        if($selectedCountry == 'MYS') {
            $datas = Customer::where('countryId', '=', 'MYS')->get();
        }
        if($selectedCountry == 'PAK'){
            $datas = Customer::where('countryId', '=', 'PAK')->get();
        }
        //dd($datas);
        foreach ($datas as $data) {

        //check for Abandon cart
                $sql="SELECT*FROM cart WHERE customerId='".$data->id."'";
                $rsitem = DB::connection('mysql2')->select($sql);
                if (count($rsitem)>0) {
                    $itemCart="YES";
                } else {
                    $itemCart="NO";
                }
                $data->abandonCart = $itemCart;

        //check for Order Completed
                $sql="SELECT*FROM `order` WHERE completionStatus<>'RECEIVED_AT_STORE' AND customerId='".$data->id."'";
                $rsordercomplete = DB::connection('mysql2')->select($sql);
                if (count($rsordercomplete)>0) {
                    $orderCompleted="YES";
                } else {
                    $orderCompleted="NO";
                }
                $data->Completed = $orderCompleted;

        //check for Order Incompleted
                $sql="SELECT*FROM `order` WHERE completionStatus = 'RECEIVED_AT_STORE' AND customerId='".$data->id."'";
                $rsorderIncomplete = DB::connection('mysql2')->select($sql);
                if (count($rsorderIncomplete)>0) {
                    $orderIncomplete="YES";
                } else {
                    $orderIncomplete="NO";
                }
                $data->Incomplete = $orderIncomplete;
            }        
            $newArray = array();

            foreach ($datas as $data) {
    
                $cur_item = array();
    
                array_push( 
                    $cur_item,
                     Carbon::parse($data['created'])->format('d/m/Y'),
                             $data['name'], 
                             $data['email'],
                             $data['phoneNumber'], 
                             $data['abandonCart'], 
                             $data['Completed'],
                             $data['Incomplete'], 
                );
    
                $newArray[] = $cur_item;
    
            }
        return new Collection($newArray);
    }

    public function headings(): array
    {
        return [
            'Created',
            'Customer Name',
            'Email Address',
            'Phone Number',
            'Abandon Cart',
            'Completed Order',
            'Incompleted Order',
        ];
    }
}
