<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use App\Models\User;
use App\Models\Client;
use App\Models\Cart;
use App\Models\PaymentDetail as Payment;
use App\Models\Store;
use App\Models\Customer;
use App\Models\Refund;
use App\Models\UserActivity;
use App\Models\StoreDeliveryDetail as StoreDelivery;
use Carbon\Carbon;
use DateTime;

use App\Exports\UsersExport;
use App\Exports\DetailsExport;
use App\Exports\SettlementsExport;
use App\Exports\MerchantExport;
use App\Exports\PendingRefundExport;
use App\Exports\RefundHistoryExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;
 
use App\Mail\NotifyMail;
use App\Mail\EmailContent;

class ActivityController extends Controller
{

    protected $url;
    protected $token;

    function __construct() {
            $this->url = config('services.report_svc.url');
            $this->token = config('services.report_svc.token');
    }

    public function useractivitylog(){

        $to = date("Y-m-d");
        $date = new DateTime('1 days ago');
        $from = $date->format("Y-m-d");

        // $datas = Client::limit(100)->get();
        $datas = UserActivity::whereBetween('created', [$from, $to." 23:59:59"])  
                        ->orderBy('created', 'DESC')
                        ->get();
       
        $newArray = array();
        $storeList = array();
        $customerList = array();

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
             

            $customerName = '';
            if (! array_key_exists($data['customerId'], $customerList)) {            
                $customer_info = Customer::where('id', $data['customerId'])
                                    ->get();
                if (count($customer_info) > 0) {
                    $customerList[$data['customerId']] = $customer_info[0]['name']; 
                    $customerName = $customerList[$data['customerId']];
                }  
                
            } else {
                $customerName = $customerList[$data['customerId']];
            }
             
            
            $object = [
                'created' => $data['created'],
                'storeName' => $storeName,
                'customerName' => $customerName,
                'sessionId' => $data['sessionId'],
                'pageVisited' => $data['pageVisited'],
                'ip' => $data['ip'],
                'device' => $data['deviceModel'],
                'os' => $data['os'],
                'browser' => $data['browserType'],
                'errorType' => $data['errorType'],
                'errorOccur' => $data['errorOccur'],
            ];

            array_push( 
                $newArray,
                $object
            );

        }
       

        $datas = $newArray;

        $datechosen = $date->format('F d, Y')." - ".date('F d, Y');  
        $storename = '';   
        $customername = '';
        $device = '';  
        $browser = ''; 

        return view('components.useractivity', compact('datas','datechosen','storename','customername','device','browser'));
    }

    
    public function filter_useractivitylog(Request $req){

        $data = $req->input();

        $dateRange = explode( '-', $req->date_chosen4 );
        $start_date = $dateRange[0];
        $end_date = $dateRange[1];

        $start_date = date("Y-m-d", strtotime($start_date));
        $end_date = date("Y-m-d", strtotime($end_date));

        $query = UserActivity::whereBetween('created', [$start_date, $end_date." 23:59:59"]);

        if ($req->storename_chosen<>"") {
            $search_store_info = Store::where('name', '=',  $req->storename_chosen )->get();            
            if (count($search_store_info) > 0) {
               $search_storeId = $search_store_info[0]['id']; 
            }  else {
                $search_storeId = "NOT FOUND";
            }
            $query->where('storeId', $search_storeId);
            //dd($query);
        }
        if ($req->customer_chosen<>"") {
            $search_customer_info = Customer::where('name', $req->customer_chosen)->get();
            if (count($search_customer_info) > 0) {
               $search_customerId = $search_customer_info[0]['id']; 
            } else {
                $search_customerId = "NOT FOUND";
            }
            $query->where('customerId', $search_customerId);
            //dd($query);
        }
        if ($req->device_chosen<>"") {
            $query->where('deviceModel', $req->device_chosen);
        }
        if ($req->browser_chosen<>"") {
            $query->where('browserType', $req->browser_chosen);
        }
          
        $query->orderBy('created', 'DESC');
        $datas = $query->get();

        $newArray = array();
        $storeList = array();
        $customerList = array();

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
             

            $customerName = '';
            if (! array_key_exists($data['customerId'], $customerList)) {            
                $customer_info = Customer::where('id', $data['customerId'])
                                    ->get();
                if (count($customer_info) > 0) {
                    $customerList[$data['customerId']] = $customer_info[0]['name']; 
                    $customerName = $customerList[$data['customerId']];
                }  
                
            } else {
                $customerName = $customerList[$data['customerId']];
            }
             
            
            $object = [
                'created' => $data['created'],
                'storeName' => $storeName,
                'customerName' => $customerName,
                'sessionId' => $data['sessionId'],
                'pageVisited' => $data['pageVisited'],
                'ip' => $data['ip'],
                'device' => $data['deviceModel'],
                'os' => $data['os'],
                'browser' => $data['browserType'],
                'errorType' => $data['errorType'],
                'errorOccur' => $data['errorOccur'],
            ];

            array_push( 
                $newArray,
                $object
            );

        }
       

        $datas = $newArray;        
        $datechosen = $req->date_chosen4;                
        $storename = $req->storename_chosen;
        $customername = $req->customer_chosen;
        $device = $req->device_chosen;
        $browser = $req->browser_chosen;

        return view('components.useractivity', compact('datas', 'datechosen', 'storename', 'customername','device','browser'));

    }

    public function export_useractivitylog(Request $req) 
    {
        $data = $req->input();

        $dateRange = explode( '-', $req->date_chosen4_copy );
        $start_date = $dateRange[0];
        $end_date = $dateRange[1];

        $start_date = date("Y-m-d", strtotime($start_date));
        $end_date = date("Y-m-d", strtotime($end_date));

        // return $start_date."|".$end_date;
        // return $data;
        // die();
        

        // $from = "2021-08-01";
        // $to = "2021-08-30";

        return Excel::download(new PendingRefundExport($start_date, $end_date." 23:59:59"), 'pendingrefund.xlsx');
    }


    public function usersitemap(){

        $to = date("Y-m-d");
        $date = new DateTime('1 days ago');
        $from = $date->format("Y-m-d");

        //query group by sessionId
        $datas = UserActivity::select('sessionId')->distinct()
                        ->whereBetween('created', [$from, $to." 23:59:59"])  
                        ->orderBy('created', 'DESC')
                        ->get();
        //dd($datas);

        $newArray = array();
        $storeList = array();
        $customerList = array();

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
            $sql="SELECT completionStatus FROM `order` WHERE cartId='".$data['sessionId']."'";
            $rsorder = DB::connection('mysql2')->select($sql);
            if (count($rsorder)>0) {
                $orderCreated="YES";
                $orderStatus=$rsorder[0]->completionStatus;
            } else {
                $orderCreated="NO";
                $orderStatus="";
            }

            $storeName = '';
            if (! array_key_exists($storeId, $storeList)) {
                $store_info = Store::where('id', $storeId)
                                    ->get();
                if (count($store_info) > 0) {
                    $storeList[$storeId] = $store_info[0]['name']; 
                    $storeName = $storeList[$storeId];
                }    

            } else {
                $storeName = $storeList[$storeId];
            }
             

            $customerName = '';
            if (! array_key_exists($customerId, $customerList)) {            
                $customer_info = Customer::where('id', $customerId)
                                    ->get();
                if (count($customer_info) > 0) {
                    $customerList[$customerId] = $customer_info[0]['name']; 
                    $customerName = $customerList[$customerId];
                }  
                
            } else {
                $customerName = $customerList[$customerId];
            }

             //get all history
            $activityList = array();
            $sql="SELECT created, pageVisited, os, deviceModel, errorOccur, errorType FROM customer_activities WHERE sessionId='".$data['sessionId']."' ORDER BY created ASC";
            $rsactivity = DB::connection('mysql3')->select($sql);
            if (count($rsactivity) > 0) {
                foreach ($rsactivity as $activity) {

                    $activity_details = [
                        'created' => $activity->created,
                        'pageVisited' => $activity->pageVisited,
                        'os' => $activity->os,
                        'deviceModel' => $activity->deviceModel,
                        'errorOccur' => $activity->errorOccur,
                        'errorType' => $activity->errorType 
                    ];
    
                    array_push( 
                        $activityList,
                        $activity_details
                    );
                   
                }
            }
            //dd($activityList);

            $object = [
                'storeName' => $storeName,
                'customerName' => $customerName,
                'sessionId' => $data['sessionId'],
                'startTimestamp' => $startTimestamp,
                'endTimestamp' => $endTimestamp,
                'timeSpent' => $timeSpent,
                'firstPage' => $firstPage,
                'lastPage' => $lastPage,
                'itemAdded' => $itemAdded,
                'orderCreated' => $orderCreated,
                'orderStatus' => $orderStatus,
                'activity_list' => $activityList
            ];

            
            array_push( 
                $newArray,
                $object
            );

        }
       

        $datas = $newArray;

        $datechosen = $date->format('F d, Y')." - ".date('F d, Y');  
        $storename = '';   
        $customername = '';
        $device = '';  
        $browser = ''; 

        return view('components.usersitemap', compact('datas','datechosen','storename','customername','device','browser'));
    }


    public function filter_usersitemap(Request $req){

        $data = $req->input();

        $dateRange = explode( '-', $req->date_chosen4 );
        $start_date = $dateRange[0];
        $end_date = $dateRange[1];

        $start_date = date("Y-m-d", strtotime($start_date));
        $end_date = date("Y-m-d", strtotime($end_date));

        //query group by sessionId
        $datas = UserActivity::select('sessionId')->distinct()
                        ->whereBetween('created', [$start_date, $end_date." 23:59:59"])  
                        ->orderBy('created', 'DESC')
                        ->get();
        //dd($datas);

        $newArray = array();
        $storeList = array();
        $customerList = array();

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
            $sql="SELECT completionStatus FROM `order` WHERE cartId='".$data['sessionId']."'";
            $rsorder = DB::connection('mysql2')->select($sql);
            if (count($rsorder)>0) {
                $orderCreated="YES";
                $orderStatus=$rsorder[0]->completionStatus;
            } else {
                $orderCreated="NO";
                $orderStatus="";
            }

            $storeName = '';
            if (! array_key_exists($storeId, $storeList)) {
                $store_info = Store::where('id', $storeId)
                                    ->get();
                if (count($store_info) > 0) {
                    $storeList[$storeId] = $store_info[0]['name']; 
                    $storeName = $storeList[$storeId];
                }    

            } else {
                $storeName = $storeList[$storeId];
            }
             

            $customerName = '';
            if (! array_key_exists($customerId, $customerList)) {            
                $customer_info = Customer::where('id', $customerId)
                                    ->get();
                if (count($customer_info) > 0) {
                    $customerList[$customerId] = $customer_info[0]['name']; 
                    $customerName = $customerList[$customerId];
                }  
                
            } else {
                $customerName = $customerList[$customerId];
            }

            //get all history
            $activityList = array();
            $sql="SELECT created, pageVisited, os, deviceModel, errorOccur, errorType FROM customer_activities WHERE sessionId='".$data['sessionId']."' ORDER BY created ASC";
            $rsactivity = DB::connection('mysql3')->select($sql);
            if (count($rsactivity) > 0) {
                foreach ($rsactivity as $activity) {

                    $activity_details = [
                        'created' => $activity->created,
                        'pageVisited' => $activity->pageVisited,
                        'os' => $activity->os,
                        'deviceModel' => $activity->deviceModel,
                        'errorOccur' => $activity->errorOccur,
                        'errorType' => $activity->errorType 
                    ];
    
                    array_push( 
                        $activityList,
                        $activity_details
                    );
                   
                }
            }
            //dd($activityList);

            $object = [
                'storeName' => $storeName,
                'customerName' => $customerName,
                'sessionId' => $data['sessionId'],
                'startTimestamp' => $startTimestamp,
                'endTimestamp' => $endTimestamp,
                'timeSpent' => $timeSpent,
                'firstPage' => $firstPage,
                'lastPage' => $lastPage,
                'itemAdded' => $itemAdded,
                'orderCreated' => $orderCreated,
                'orderStatus' => $orderStatus,
                'activity_list' => $activityList
            ];

            
            array_push( 
                $newArray,
                $object
            );

        }
       

        $datas = $newArray;

        $datechosen = $req->date_chosen4;   
        $storename = '';   
        $customername = '';
        $device = '';  
        $browser = ''; 

        return view('components.usersitemap', compact('datas','datechosen','storename','customername','device','browser'));

    }


    public function useractivitysummary(){

        $datas=array();
        $date = new DateTime('7 days ago');
        $datechosen = $date->format('F d, Y')." - ".date('F d, Y');  
        $storename=null;
        $customername=null;
        $device=null;
        $browser=null;
        $groupbrowser=null;
        $groupdevice=null;
        $groupos=null;
        $grouppage=null;

        return view('components.useractivitysummary', compact('datas','datechosen','storename','customername','device','browser','groupbrowser','groupdevice','groupos','grouppage'));        
    }
   

    public function filter_useractivitysummary(Request $req){

        $date = new DateTime('7 days ago');

        $data = $req->input();

        $dateRange = explode( '-', $req->date_chosen4 );
        $start_date = $dateRange[0];
        $end_date = $dateRange[1];

        $start_date = date("Y-m-d", strtotime($start_date));
        $end_date = date("Y-m-d", strtotime($end_date));

        $groupList="COUNT(*) AS total"; 
        $groupBy="";       
        if ($req->groupbrowser<>"") {
            $groupList .= " , browserType";
            if ($groupBy=="")
                $groupBy .= " browserType";
            else
                $groupBy .= " , browserType";
        }
        if ($req->groupdevice<>"") {
            $groupList .= " , deviceModel";
            if ($groupBy=="")
                $groupBy .= " deviceModel";
            else
                $groupBy .= " , deviceModel";
        }
        if ($req->groupos<>"") {
            $groupList .= " , os";
            if ($groupBy=="")
                $groupBy .= " os";
            else
                $groupBy .= " , os";
        }
        if ($req->grouppage<>"") {
            $groupList .= " , pageVisited";
            if ($groupBy=="")
                $groupBy .= " pageVisited";
            else
                $groupBy .= " , pageVisited";
        }

        //query group by sessionId
        $sql="SELECT ".$groupList." FROM customer_activities WHERE created BETWEEN '".$start_date."' AND '".$end_date."' GROUP BY ".$groupBy;
        $datas = DB::connection('mysql3')->select($sql);
        //dd($datas);

        $datechosen = $req->date_chosen4;  
        $storename=null;
        $customername=null;
        $device=null;
        $browser=null;
        $groupbrowser=$req->groupbrowser;
        $groupdevice=$req->groupdevice;
        $groupos=$req->groupos;
        $grouppage=$req->grouppage;

        return view('components.useractivitysummary', compact('datas','datechosen','storename','customername','device','browser','groupbrowser','groupdevice','groupos','grouppage'));

    }


    public function userabandoncart(){

            $to = date("Y-m-d");
            $date = new DateTime('30 days ago');
            $from = $date->format("Y-m-d");

            //query group by sessionId
            $datas = Cart::select('id','customerId','storeId','created','updated','isOpen')
                            ->whereBetween('created', [$from, $to." 23:59:59"])  
                            ->where('isOpen',1)
                            ->orderBy('created', 'DESC')
                            ->get();
            //dd($datas);

            $newArray = array();
            $storeList = array();
            $customerList = array();

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
                 

                $customerName = '';
                if (! array_key_exists($data['customerId'], $customerList)) {            
                    $customer_info = Customer::where('id', $data['customerId'])
                                        ->get();
                    if (count($customer_info) > 0) {
                        $customerList[$data['customerId']] = $customer_info[0]['name']; 
                        $customerName = $customerList[$data['customerId']];
                    }  
                    
                } else {
                    $customerName = $customerList[$data['customerId']];
                }
                 
                //check if any item in cart
                $sql="SELECT productId, quantity, name FROM cart_item A INNER JOIN product B ON A.productId=B.id WHERE cartId='".$data['id']."'";
                $rsitem = DB::connection('mysql2')->select($sql);
                if (count($rsitem)>0) {
                    $itemAdded="YES";
                } else {
                    $itemAdded="NO";
                }

                $item_array = array();
                if (count($rsitem) > 0) {
                    foreach ($rsitem as $item) {

                        $item_details = [
                            'productId' => $item->productId,
                            'quantity' => $item->quantity,
                            'name' => $item->name                       
                        ];
        
                        array_push( 
                            $item_array,
                            $item_details
                        );
                       
                    }
                }

                $object = [
                    'id' => $data['id'],
                    'created' => $data['created'],
                    'updated' => $data['updated'],
                    'isOpen' => $data['isOpen'],
                    'storeName' => $storeName,
                    'customerName' => $customerName,
                    'itemAdded' => $itemAdded,
                    'item_list' => $item_array
                ];

                array_push( 
                    $newArray,
                    $object
                );

            }
           

            $datas = $newArray;

            $datechosen = $date->format('F d, Y')." - ".date('F d, Y');  
            $storename = '';   
            $customername = '';
            $device = '';  
            $browser = ''; 

            return view('components.userabandoncart', compact('datas','datechosen','storename','customername'));
        }


        public function filter_userabandoncart(Request $req){

            $data = $req->input();

            $dateRange = explode( '-', $req->date_chosen4 );
            $start_date = $dateRange[0];
            $end_date = $dateRange[1];

            $start_date = date("Y-m-d", strtotime($start_date));
            $end_date = date("Y-m-d", strtotime($end_date));

            //query group by sessionId
            $datas = Cart::select('id','customerId','storeId','created','updated','isOpen')
                            ->whereBetween('created', [$start_date, $end_date." 23:59:59"])  
                            ->where('isOpen',1)
                            ->orderBy('created', 'DESC')
                            ->get();
            //dd($datas);

            $newArray = array();
            $storeList = array();
            $customerList = array();

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
                 

                $customerName = '';
                if (! array_key_exists($data['customerId'], $customerList)) {            
                    $customer_info = Customer::where('id', $data['customerId'])
                                        ->get();
                    if (count($customer_info) > 0) {
                        $customerList[$data['customerId']] = $customer_info[0]['name']; 
                        $customerName = $customerList[$data['customerId']];
                    }  
                    
                } else {
                    $customerName = $customerList[$data['customerId']];
                }
                 
                 //check if any item in cart
                $sql="SELECT productId, quantity, name FROM cart_item A INNER JOIN product B ON A.productId=B.id WHERE cartId='".$data['id']."'";
                $rsitem = DB::connection('mysql2')->select($sql);
                if (count($rsitem)>0) {
                    $itemAdded="YES";
                } else {
                    $itemAdded="NO";
                }

                $item_array = array();
                if (count($rsitem) > 0) {
                    foreach ($rsitem as $item) {

                        $item_details = [
                            'productId' => $item->productId,
                            'quantity' => $item->quantity,
                            'name' => $item->name                       
                        ];
        
                        array_push( 
                            $item_array,
                            $item_details
                        );
                       
                    }
                }
                
                $object = [
                    'id' => $data['id'],
                    'created' => $data['created'],
                    'updated' => $data['updated'],
                    'isOpen' => $data['isOpen'],
                    'storeName' => $storeName,
                    'customerName' => $customerName,
                    'itemAdded' => $itemAdded,
                    'item_list' => $item_array
                ];

                array_push( 
                    $newArray,
                    $object
                );

            }
           

            $datas = $newArray;

            $datechosen = $req->date_chosen4;   
            $storename = '';   
            $customername = '';
            $device = '';  
            $browser = ''; 

            return view('components.userabandoncart', compact('datas','datechosen','storename','customername'));

        }

}