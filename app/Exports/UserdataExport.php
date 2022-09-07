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
        $datas = UserActivity::select('sessionId')->distinct()
                        ->select('csession.address AS sessionAddress', 'csession.city AS sessionCity')
                        ->leftjoin('customer_session as csession', 'customer_activities.sessionId', '=', 'csession.sessionId')
                        ->whereBetween('customer_activities.created', [$this->from, $this->to])  
                        ->orderBy('customer_activities.created', 'DESC')
                        ->get();

        $newArray = array();
        $storeList = array();
        $customerList = array();
        $emailList = array();
        $phoneList = array();

        foreach ($datas as $data) {

             //get pageVisited
             $sql="SELECT created, pageVisited, storeId, customerId FROM customer_activities WHERE sessionId='".$data['sessionId']."' GROUP BY customerId";
             $rsstart = DB::connection('mysql3')->select($sql);
             $firstPage = $rsstart[0]->pageVisited;
             $storeId = $rsstart[0]->storeId;
             $customerId = $rsstart[0]->customerId;
             if(count($rsstart)>0){
                 $firstPage = "YES";
             } else {
                 $firstPage="NO";
             }
         
             //check if any item in cart
             $sql="SELECT * FROM cart_item WHERE cartId='".$data['sessionId']."'";
             $rsitem = DB::connection('mysql2')->select($sql);
             if (count($rsitem)>0) {
                 $itemAdded="YES";
             } else {
                 $itemAdded="NO";
             }
         
             //check if any order created 
             $sql="SELECT A.id, A.created, invoiceId, B.name AS customerName, C.name AS storeName  FROM `order` A INNER JOIN customer B 
             ON A.customerId=B.id INNER JOIN store C ON A.storeId=C.id WHERE cartId='".$data['sessionId']."' GROUP BY customerName";
             $rsorder = DB::connection('mysql2')->select($sql);
             if (count($rsorder)>0) {
                 $orderCreated="YES";
                 $orderId = $rsorder[0]->id;
                 $orderDetails  = [
                         'orderId' => $rsorder[0]->id,
                         'invoiceNo' => $rsorder[0]->invoiceId,
                         'created' => $rsorder[0]->created,
                         'storeName' => $rsorder[0]->storeName,
                         'customerName' => $rsorder[0]->customerName,
                     ];
             } else {
                 $orderCreated="NO";
                 $orderId = "";
                 $orderDetails  = null;
         
             }
         
             $storeName = '';
             if (! array_key_exists($storeId, $storeList)) {
                 $store_info = Store::where('id', $storeId)->get();
                 if (count($store_info) > 0) {
                     $storeList[$storeId] = $store_info[0]['name']; 
                     $storeName = $storeList[$storeId];
                 }    
         
             } else {
                 $storeName = $storeList[$storeId];
             }
              
         
             $customerName = '';
             if (! array_key_exists($customerId, $customerList)) {            
                 $customer_info = Customer::where('id', $customerId)->get();
                 if (count($customer_info) > 0) {
                     $customerList[$customerId] = $customer_info[0]['name']; 
                     $customerName = $customerList[$customerId];
                 }  
                 
             } else {
                 $customerName = $customerList[$customerId];
             }  
             
             $email = '';
             if (! array_key_exists($customerId, $emailList)) {            
                 $email_info = Customer::where('id', $customerId)->get();
                 if (count($email_info) > 0) {
                     $emailList[$customerId] = $email_info[0]['email']; 
                     $email = $emailList[$customerId];
                 }  
                 
             } else {
                 $email = $emailList[$customerId];
             }  
         
             $phone = '';
             if (! array_key_exists($customerId, $phoneList)) {            
                 $phone_info = Customer::where('id', $customerId)->get();
                 if (count($phone_info) > 0) {
                     $phoneList[$customerId] = $phone_info[0]['phoneNumber']; 
                     $phone = $phoneList[$customerId];
                 }  
                 
             } else {
                 $phone = $phoneList[$customerId];
             } 
             
             $object = [
                 'storeName' => $storeName,
                 'customerName' => $customerName,
                 'email' => $email,
                 'phone' => $phone,
                 'firstPage' => $firstPage,
                 'itemAdded' => $itemAdded,
                 'orderCreated' => $orderCreated,
             ];
         
             
             array_push( 
                 $newArray,
                 $object
             );
         

            $cur_item = array();

            array_push( 
                $cur_item,
                $data['customerName'], 
                $data['storeName'],
                $data['email'],
                $data['phone'],
                $data['firstPage'],
                $data['itemAdded'],
                $data['orderCreated']
            );

            $newArray[] = $cur_item;

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
            'Visited Page',
            'Incomplete Order',
            'Completed Order',
        ];
    }
}
