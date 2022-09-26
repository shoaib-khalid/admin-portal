<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Client;
use App\Models\Cart;
use App\Models\PaymentDetail as Payment;
use App\Models\Store;
use App\Models\Customer;
use App\Models\Refund;
use App\Models\UserActivity;
use App\Models\StoreDeliveryDetail as StoreDelivery;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use DateTime;
use Illuminate\Support\Facades\Http;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserActivityExport implements FromCollection, ShouldAutoSize, WithHeadings
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
        // return User::all(); 
        
         $datas = UserActivity::select('customer_activities.*','csession.address AS sessionAddress', 'csession.city AS sessionCity')
                         
                        ->leftjoin('customer_session as csession', 'customer_activities.sessionId', '=', 'csession.sessionId')
                        ->orderBy('customer_activities.created', 'DESC')
                        ->get();
       
        $newArray = array();
        $storeList=array();
        $customerList = array();

        $storeListObject = Store::get();
        $customerListObject = Customer::get();

        foreach ($storeListObject as $store) {
            $storeList[$store->id] = $store->name;
        }

         foreach ($customerListObject as $customer) {
            $customerList[$customer->id] = $customer->name;
        }

        //dd($datas);
        foreach ($datas as $data) {

            $storeName = '';
            if (array_key_exists($data['storeId'], $storeList)) {            
                $storeName = $storeList[$data['storeId']];
            }
             
            $customerName = '';
            if (array_key_exists($data['customerId'], $customerList)) {                       
                $customerName = $customerList[$data['customerId']];
            }
         
            
            $object = [
                'created' => $data['created'],
                'storeName' => $storeName,
                'customerName' => $customerName,
                'address' => $data['address'],
                'pageVisited' => $data['pageVisited'],
                'ip' => $data['ip'],
                'device' => $data['deviceModel'],
                'os' => $data['os'],
                'browser' => $data['browserType'],
                'errorType' => $data['errorType'],
                
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
            'Timestamp',
            'Store Name',
            'Customer Name',
            'Address',
            'Page Visited',
            'IP',
            'Device',
            'OS',
            'Browser',
            'Error',
        ];
    }

}
 
