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
use Session;
use DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserSiteMapExport implements FromCollection, ShouldAutoSize, WithHeadings
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
        $selectedCountry = Session::get('selectedCountry');
        if($selectedCountry == 'MYS') {

            $datas1  =  UserActivity::select('csession.address AS sessionAddress', 'csession.city AS sessionCity', 'customer_activities.sessionId','customer_activities.storeId','customer_activities.customerId')
                        ->leftjoin('customer_session as csession', 'customer_activities.sessionId', '=', 'csession.sessionId')
                        ->whereBetween('customer_activities.created', [$this->from, $this->to." 23:59:59"])
                        ->where('pageVisited', 'like', '%dev-my%')
                        ->groupBy('customer_activities.sessionId');

            $datas =  UserActivity::select('csession.address AS sessionAddress', 'csession.city AS sessionCity', 'customer_activities.sessionId','customer_activities.storeId','customer_activities.customerId')
                        ->leftjoin('customer_session as csession', 'customer_activities.sessionId', '=', 'csession.sessionId')
                        ->whereBetween('customer_activities.created', [$this->from, $this->to." 23:59:59"])
                        ->where('pageVisited', 'like', '%deliverin.my%')
                        ->groupBy('customer_activities.sessionId') 
                        ->union($datas1)
                        ->get();
        }

        if($selectedCountry == 'PAK'){

            $datas1  =  UserActivity::select('csession.address AS sessionAddress', 'csession.city AS sessionCity', 'customer_activities.sessionId', 'customer_activities.storeId','customer_activities.customerId')
                                    ->leftjoin('customer_session as csession', 'customer_activities.sessionId', '=', 'csession.sessionId')
                                    ->whereBetween('customer_activities.created', [$this->from, $this->to." 23:59:59"])
                                    ->where('pageVisited', 'like', '%dev-pk%')
                                    ->groupBy('customer_activities.sessionId');

            $datas  =  UserActivity::select('csession.address AS sessionAddress', 'csession.city AS sessionCity', 'customer_activities.sessionId', 'customer_activities.storeId','customer_activities.customerId')
                                    ->leftjoin('customer_session as csession', 'customer_activities.sessionId', '=', 'csession.sessionId')
                                    ->whereBetween('customer_activities.created', [$this->from, $this->to." 23:59:59"])
                                    ->where('pageVisited', 'like', '%easydukan.co%')
                                    ->groupBy('customer_activities.sessionId')
                                    ->union($datas1)
                                    ->get();
        }
       
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

                        //get starttimestamp & endtimestamp, startpage & lastpage
            $sql="SELECT created, pageVisited, storeId, customerId FROM customer_activities WHERE sessionId='".$data['sessionId']."' ORDER BY created ASC LIMIT 1";
            $rsstart = DB::connection('mysql3')->select($sql);
            $startTimestamp = $rsstart[0]->created;
            $firstPage = $rsstart[0]->pageVisited;
            $storeId = $rsstart[0]->storeId;
            $customerId = $rsstart[0]->customerId;

            $sql="SELECT created, pageVisited FROM customer_activities WHERE sessionId='".$data['sessionId']."' ORDER BY created DESC LIMIT 1";
            $rsend = DB::connection('mysql3')->select($sql);
            $endTimestamp = $rsend[0]->created;
            $lastPage = $rsend[0]->pageVisited;
            
            $start = strtotime($startTimestamp);
            $end = strtotime($endTimestamp);
            $mins = ($end - $start) / 60;
            $timeSpent=$mins;

            //check if any item in cart
            $sql="SELECT * FROM cart_item WHERE cartId='".$data['sessionId']."'";
            $rsitem = DB::connection('mysql2')->select($sql);
            if (count($rsitem)>0) {
                $itemAdded="YES";
            } else {
                $itemAdded="NO";
            }
            

            //check if any order created & get status
            $sql="SELECT completionStatus, A.id, A.created, invoiceId, B.name AS customerName, C.name AS storeName  FROM `order` A INNER JOIN customer B 
            ON A.customerId=B.id INNER JOIN store C ON A.storeId=C.id WHERE cartId='".$data['sessionId']."'";
            $rsorder = DB::connection('mysql2')->select($sql);
            if (count($rsorder)>0) {
                $orderCreated="YES";
                $orderStatus=$rsorder[0]->completionStatus;
                $orderId = $rsorder[0]->id;
                $orderDetails  = [
                        'orderId' => $rsorder[0]->id,
                        'invoiceNo' => $rsorder[0]->invoiceId,
                        'created' => $rsorder[0]->created,
                        'storeName' => $rsorder[0]->storeName,
                        'customerName' => $rsorder[0]->customerName,
                        'status' => $rsorder[0]->completionStatus 
                    ];
            } else {
                $orderCreated="NO";
                $orderStatus="";
                $orderId = "";
                $orderDetails  = null;

            }

            $storeName = '';
            if (array_key_exists($data['storeId'], $storeList)) {            
                $storeName = $storeList[$data['storeId']];
            }
             
            $customerName = '';
            if (array_key_exists($data['customerId'], $customerList)) {                       
                $customerName = $customerList[$data['customerId']];
            }

            $sessionAddress = $data['sessionAddress'];
            $sessionCity = $data['sessionCity'];   
            
            $object = [
                'sessionId' => $data['sessionId'],
                'location' => $sessionAddress.", ".$sessionCity,
                'customerName' => $customerName,
                'storeName' => $storeName,
                'startTimestamp' => $startTimestamp,
                'endTimestamp' => $endTimestamp,
                'timeSpent' => $timeSpent,
                'firstPage' => $firstPage,
                'lastPage' => $lastPage,
                'itemAdded' => $itemAdded,
                'orderCreated' => $orderCreated,
                'orderStatus' => $orderStatus,
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
            'Session ID',
            'Location',
            'Customer',
            'Store',
            'Start Timestamp',
            'End Timestamp',
            'Time Spent',
            'First Page Visited',
            'Last Page Visited',
            'Item Added',
            'Order Created',
            'Order Status',
        ];
    }

}
 
