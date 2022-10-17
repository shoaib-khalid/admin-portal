<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use App\Models\User;
use App\Models\Client;
use App\Models\Order;
use App\Models\Cart;
use App\Models\PaymentDetail as Payment;
use App\Models\Store;
use App\Models\Customer;
use App\Models\Refund;
use App\Models\UserActivity;
use App\Models\StoreDeliveryDetail as StoreDelivery;
use Carbon\Carbon;
use DateTime;

use App\Exports\UserdataExport;
use App\Exports\DetailsExport;
use App\Exports\SettlementsExport;
use App\Exports\MerchantExport;
use App\Exports\PendingRefundExport;
use App\Exports\RefundHistoryExport;
use App\Exports\UserSiteMapExport;
use App\Exports\UserActivitySummaryExport;
use App\Exports\UserIncompleteOrderExport;
use App\Exports\UserActivityExport;
use App\Exports\AbandonCartExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;
use Session;

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
        $selectedCountry = Session::get('selectedCountry');
        //query group by sessionId
        if($selectedCountry == 'MYS') {
            $datas1 = UserActivity::select('customer_activities.*','csession.address AS sessionAddress', 'csession.city AS sessionCity')                        
                        ->leftjoin('customer_session as csession', 'customer_activities.sessionId', '=', 'csession.sessionId')
                        ->where('pageVisited', 'like', '%dev-my%')
                        ->whereBetween('customer_activities.created', [$from, $to." 23:59:59"]);  

            $datas = UserActivity::select('customer_activities.*','csession.address AS sessionAddress', 'csession.city AS sessionCity')                        
                        ->leftjoin('customer_session as csession', 'customer_activities.sessionId', '=', 'csession.sessionId')
                        ->Where('pageVisited', 'like', '%deliverin.my%')
                        ->whereBetween('customer_activities.created', [$from, $to." 23:59:59"])  
                        ->union($datas1)
                        ->orderBy('created', 'DESC')
                        ->paginate(15);

        }
        if($selectedCountry == 'PAK') {
            $datas1 = UserActivity::select('customer_activities.*','csession.address AS sessionAddress', 'csession.city AS sessionCity')                        
                        ->leftjoin('customer_session as csession', 'customer_activities.sessionId', '=', 'csession.sessionId')
                        ->where('pageVisited', 'like', '%dev-pk%')
                        ->whereBetween('customer_activities.created', [$from, $to." 23:59:59"]);  

            $datas = UserActivity::select('customer_activities.*','csession.address AS sessionAddress', 'csession.city AS sessionCity')                        
                        ->leftjoin('customer_session as csession', 'customer_activities.sessionId', '=', 'csession.sessionId')
                        ->Where('pageVisited', 'like', '%easydukan.co%')
                        ->whereBetween('customer_activities.created', [$from, $to." 23:59:59"])  
                        ->union($datas1)
                        ->orderBy('created', 'DESC')
                        ->paginate(15);
                        
        }
        
        // $newArray = array();

        //dd($datas);
        foreach ($datas as $data) {
            
            $sql="SELECT id, name FROM store WHERE id='".$data->storeId."'";
            $store = DB::connection('mysql2')->select($sql);
            if (count($store) > 0) {
                $storename=$store[0]->name;
            } else{
                $storename= "";
            }
            $data->storeName = $storename;

            $sql="SELECT id, username FROM customer WHERE id='".$data->customerId."'";
            $customer = DB::connection('mysql2')->select($sql);
            if (count($customer) > 0) {
                $customername=$customer[0]->username;
            } else{
                $customername= "";
            }
            $data->customerName = $customername;

            $sessionAddress = $data->sessionAddress;
            $sessionCity = $data->sessionCity;    
        }
            // $storeName = '';
            // if (! array_key_exists($data['storeId'], $storeList)) {
            //     $store_info = Store::where('id', $data['storeId'])
            //                         ->get();
            //     if (count($store_info) > 0) {
            //         $storeList[$data['storeId']] = $store_info[0]['name']; 
            //         $storeName = $storeList[$data['storeId']];
            //     }    

            // } else {
            //     $storeName = $storeList[$data['storeId']];
            // }
             

            // $customerName = '';
            // if (! array_key_exists($data['customerId'], $customerList)) {            
            //     $customer_info = Customer::where('id', $data['customerId'])
            //                         ->get();
            //     if (count($customer_info) > 0) {
            //         $customerList[$data['customerId']] = $customer_info[0]['name']; 
            //         $customerName = $customerList[$data['customerId']];
            //     }  
                
            // } else {
            //     $customerName = $customerList[$data['customerId']];
            // }

            // $sessionAddress = $data['sessionAddress'];
            // $sessionCity = $data['sessionCity'];             
            
            // $object = [
            //     'created' => $data['created'],
            //     'storeName' => $storeName,
            //     'customerName' => $customerName,
            //     'sessionId' => $data['sessionId'],
            //     'pageVisited' => $data['pageVisited'],
            //     'ip' => $data['ip'],
            //     'device' => $data['deviceModel'],
            //     'os' => $data['os'],
            //     'browser' => $data['browserType'],
            //     'errorType' => $data['errorType'],
            //     'errorOccur' => $data['errorOccur'],
            //     'address' => $sessionAddress,
            //     'city' => $sessionCity
            // ];

            // array_push( 
            //     $newArray,
            //     $object
            // );

        //}
    
        $datechosen = $date->format('F d, Y')." - ".date('F d, Y');  
        $storename = '';   
        $customername = '';
        $device = '';  
        $browser = ''; 
        $pageVisited = '';

        return view('components.useractivity',compact('datas','datechosen','storename','customername','device','browser'));
    }
 
    public function filter_useractivitylog(Request $req){

        $data = $req->input();

        $dateRange = explode( '-', $req->date_chosen4 );
        $start_date = $dateRange[0];
        $end_date = $dateRange[1];

        $start_date = date("Y-m-d", strtotime($start_date));
        $end_date = date("Y-m-d", strtotime($end_date));

        Session::put('selectedCountry', $req->region);

        //$query = UserActivity::whereBetween('created', [$start_date, $end_date." 23:59:59"]);
         // $datas = Client::limit(100)->get();
        $query = UserActivity::select('customer_activities.*','csession.address AS sessionAddress', 'csession.city AS sessionCity')
                        ->whereBetween('customer_activities.created', [$start_date, $end_date." 23:59:59"])  
                        ->leftjoin('customer_session as csession', 'customer_activities.sessionId', '=', 'csession.sessionId');
        //dd($query);

        if($req->region == "MYS"){
            $query->where(function ($query) {
                $query->where('pageVisited', 'like', '%dev-my%')
                ->orWhere('pageVisited', 'like', '%deliverin.my%');
            });           
          }

          if($req->region == "PAK"){
             $query->where(function ($query) {
                $query->where('pageVisited', 'like', '%dev-pk%')
                ->orWhere('pageVisited', 'like', '%easydukan.co%');
            });              
          }


            if ($req->storename_chosen<>"") {
            $search_store_info = Store::where('name', 'like',  '%'.$req->storename_chosen.'%' )->get(); 
            $search_storeId_list = array();        
            if (count($search_store_info) > 0) {
               foreach ($search_store_info as $storefound) {
                    array_push($search_storeId_list, $storefound['id']);
               }
            }  
            $query->whereIn('storeId', $search_storeId_list);
            //dd($query);
             }
        if ($req->customer_chosen<>"") {
            $search_customer_info = Customer::where('name', 'like', '%'.$req->customer_chosen.'%')->get();
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

//dd($query);
        $query->orderBy('created', 'DESC');
        //dd($query);
        $datas = $query->paginate(15);

        // $newArray = array();
        // $storeList = array();
        // $customerList = array();

        foreach ($datas as $data) {

            $sql="SELECT id, name FROM store WHERE id='".$data->storeId."'";
            $store = DB::connection('mysql2')->select($sql);
            if (count($store) > 0) {
                $storename=$store[0]->name;
            } else{
                $storename= "";
            }
            $data->storeName = $storename;


            $sql="SELECT id, username FROM customer WHERE id='".$data->customerId."'";
            $customer = DB::connection('mysql2')->select($sql);
            if (count($customer) > 0) {
                $customername=$customer[0]->username;
            } else{
                $customername= "";
            }
            $data->customerName = $customername;


            $sessionAddress = $data->sessionAddress;
            $sessionCity = $data->sessionCity;    
        }

            // $storeName = '';
            // if (! array_key_exists($data['storeId'], $storeList)) {
            //     $store_info = Store::where('id', $data['storeId'])
            //                         ->get();
            //     if (count($store_info) > 0) {
            //         $storeList[$data['storeId']] = $store_info[0]['name']; 
            //         $storeName = $storeList[$data['storeId']];
            //     }    

            // } else {
            //     $storeName = $storeList[$data['storeId']];
            // }
             

            // $customerName = '';
            // if (! array_key_exists($data['customerId'], $customerList)) {            
            //     $customer_info = Customer::where('id', $data['customerId'])
            //                         ->get();
            //     if (count($customer_info) > 0) {
            //         $customerList[$data['customerId']] = $customer_info[0]['name']; 
            //         $customerName = $customerList[$data['customerId']];
            //     }  
                
            // } else {
            //     $customerName = $customerList[$data['customerId']];
            // }

            // $sessionAddress = $data['sessionAddress'];
            // $sessionCity = $data['sessionCity'];
            
            // $object = [
            //     'created' => $data['created'],
            //     'storeName' => $storeName,
            //     'customerName' => $customerName,
            //     'sessionId' => $data['sessionId'],
            //     'pageVisited' => $data['pageVisited'],
            //     'ip' => $data['ip'],
            //     'device' => $data['deviceModel'],
            //     'os' => $data['os'],
            //     'browser' => $data['browserType'],
            //     'errorType' => $data['errorType'],
            //     'errorOccur' => $data['errorOccur'],
            //     'address' => $sessionAddress,
            //     'city' => $sessionCity
            // ];

            // array_push( 
            //     $newArray,
            //     $object
            // );

        //}
       

        // $datas = $newArray;        
        $datechosen = $req->date_chosen4;                
        $storename = $req->storename_chosen;
        $customername = $req->customer_chosen;
        $device = $req->device_chosen;
        $browser = $req->browser_chosen;
        $pageVisited = $req->page_chosen;
        $MYS= $req->MYS;
        $PAK= $req->PAK;

        return view('components.useractivity', compact('datas', 'datechosen', 'storename', 'customername','device','browser','MYS','PAK'));

    }

  
    public function export_useractivitylog(Request $req) 
    {
        $data = $req->input();

        $dateRange = explode( '-', $req->date_chosen4_copy );
        $start_date = $dateRange[0];
        $end_date = $dateRange[1];

        $start_date = date("Y-m-d", strtotime($start_date));
        $end_date = date("Y-m-d", strtotime($end_date));

        return Excel::download(new UserActivityExport($start_date, $end_date." 23:59:59"), 'useractivity.xlsx');
    }


    public function usersitemap(){

        $to = date("Y-m-d");
        $date = new DateTime('1 days ago');
        $from = $date->format("Y-m-d");
        $selectedCountry = Session::get('selectedCountry');
        //query group by sessionId
        if($selectedCountry == 'MYS') {
            // $datas = UserActivity::select('sessionId')->distinct()
            //             ->select('customer_activities.storeId','customer_activities.customerId','csession.address AS sessionAddress', 'csession.city AS sessionCity')
            //             ->leftjoin('customer_session as csession', 'customer_activities.sessionId', '=', 'csession.sessionId')
            //             ->whereBetween('customer_activities.created', [$from, $to." 23:59:59"])  
            //             ->where('pageVisited', 'like', '%dev-my%')
            //             ->orWhere('pageVisited', 'like', '%deliverin.my%')
            //             ->orderBy('customer_activities.created', 'DESC')
            //             ->paginate();

            $datas1  =  UserActivity::select('csession.address AS sessionAddress', 'csession.city AS sessionCity', 'customer_activities.sessionId','customer_activities.storeId','customer_activities.customerId')
                        ->join('customer_session as csession', 'customer_activities.sessionId', '=', 'csession.sessionId')
                        ->whereBetween('customer_activities.created', [$from, $to." 23:59:59"])
                        ->where('pageVisited', 'like', '%dev-my%');
    
            $datas =  UserActivity::select('csession.address AS sessionAddress', 'csession.city AS sessionCity', 'customer_activities.sessionId','customer_activities.storeId','customer_activities.customerId')
                        ->join('customer_session as csession', 'customer_activities.sessionId', '=', 'csession.sessionId')
                        ->whereBetween('customer_activities.created', [$from, $to." 23:59:59"])
                        ->where('pageVisited', 'like', '%deliverin.my%')
                        ->groupBy('customer_activities.sessionId') 
                        ->union($datas1)
                        ->groupBy('customer_activities.sessionId')
                        ->paginate(15);
        }

        if($selectedCountry == 'PAK'){
            // $datas = UserActivity::select('sessionId')->distinct()
            //             ->select('csession.address AS sessionAddress', 'csession.city AS sessionCity')
            //             ->leftjoin('customer_session as csession', 'customer_activities.sessionId', '=', 'csession.sessionId')
            //             ->whereBetween('customer_activities.created', [$from, $to." 23:59:59"])  
            //             ->where('pageVisited', 'like', '%dev-pk%')
            //             ->orWhere('pageVisited', 'like', '%easydukan.co%')
            //             ->orderBy('customer_activities.created', 'DESC')
            //             ->paginate();

            $datas1  =  UserActivity::select('csession.address AS sessionAddress', 'csession.city AS sessionCity', 'customer_activities.sessionId', 'customer_activities.storeId','customer_activities.customerId')
                        ->join('customer_session as csession', 'customer_activities.sessionId', '=', 'csession.sessionId')
                        ->whereBetween('customer_activities.created', [$from, $to." 23:59:59"])
                        ->where('pageVisited', 'like', '%dev-pk%');

            $datas  =  UserActivity::select('csession.address AS sessionAddress', 'csession.city AS sessionCity', 'customer_activities.sessionId', 'customer_activities.storeId','customer_activities.customerId')
                        ->join('customer_session as csession', 'customer_activities.sessionId', '=', 'csession.sessionId')
                        ->whereBetween('customer_activities.created', [$from, $to." 23:59:59"])
                        ->where('pageVisited', 'like', '%easydukan.co%')
                        ->union($datas1)
                        ->groupBy('customer_activities.sessionId')
                        ->paginate(15);
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

            $data->startTime=$startTimestamp;
            $data->firstpage=$firstPage;
            $data->endTime=$endTimestamp;
            $data->lastpage=$lastPage;
            $data->timespent=$timeSpent;

            
            //check if any item in cart
            $sql="SELECT * FROM cart_item WHERE cartId='".$data['sessionId']."'";
            $rsitem = DB::connection('mysql2')->select($sql);
            if (count($rsitem)>0) {
                $itemAdded="YES";
            } else {
                $itemAdded="NO";
            }

            $data->AddedItem=$itemAdded;


            //check if any order created & get status
            $sql="SELECT completionStatus, A.id, A.created as ordercreated, A.invoiceId  FROM `order` A INNER JOIN customer B 
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

            $data->orderStatus = $orderStatus;
            $data->orderid = $orderId;
            $data->order_details = $orderDetails;


             //Get Order Details

             //get order item from order


            // $orderItems = DB::connection('mysql2')->table('order_item')
            // ->select('order_item.id AS orderItemId','productId', 'productPrice', 'price', 'quantity', 'name', 'productVariant')
            // ->join('product as product', 'order_item.productId', '=', 'product.id')
            // ->where('orderId', $orderId)
            // ->get();
            // foreach ($orderItems as $item) {                
            //     $orderSubItems = DB::connection('mysql2')->table('order_subitem')
            //                     ->select('name')
            //                     ->join('product as product', 'order_subitem.productId', '=', 'product.id')
            //                     ->where('orderItemId', $item->orderItemId)
            //                     ->get();
            //     $item->subItems = $orderSubItems;
            // }

            // $rsorderdetails = DB::connection('mysql2')->table('order')
            //                 ->select('order.completionStatus', 'order.id', 'order.created', 'order.invoiceId','customer.name AS customername', 'store.name AS storename')
            //                 ->join('customer as customer', 'order.customer', '=', 'customer.id')
            //                 ->join('store as store', 'order.store', '=', 'store.id')
            //                 ->where('cardId', $sessionId)
            //                 ->get();

            // foreach ($rsorderdetails as $order)

            // $ordersubdetails = DB::connection('mysql2')->table('order')
            // ->select();


            //  $sql="SELECT completionStatus, A.id, A.created, A.invoiceId, B.name AS customername, C.name AS storename FROM `order` A INNER JOIN customer B 
            //  ON A.customerId=B.id INNER JOIN store C ON A.storeId=C.id WHERE cartId='".$data['sessionId']."'";
            //  $rsorderdetails = DB::connection('mysql2')->select($sql);
            //  $completionstatus = $rsorderdetails[0]->completionStatus;
            //  $data->orderid = $orderId;


            $sql="SELECT id, name FROM store WHERE id='".$data->storeId."'";
            $store = DB::connection('mysql2')->select($sql);
            if (count($store) > 0) {
                $storename=$store[0]->name;
            } else{
                $storename= "";
            }
            $data->storeName = $storename;


            $sql="SELECT id, username FROM customer WHERE id='".$data->customerId."'";
            $customer = DB::connection('mysql2')->select($sql);
            if (count($customer) > 0) {
                $customername=$customer[0]->username;
            } else{
                $customername= "";
            }
            $data->customerName = $customername;


            //get all history
            $sql="SELECT created, pageVisited, os, deviceModel, errorOccur, errorType FROM customer_activities WHERE sessionId='".$data['sessionId']."' ORDER BY created ASC";
            $rsactivity = DB::connection('mysql3')->select($sql);
            if (count($rsactivity) > 0) {
                $created = $rsactivity[0]->created;
                $pageVisited = $rsactivity[0]->pageVisited;
                $os = $rsactivity[0]->os;
                $deviceModel = $rsactivity[0]->deviceModel;
                $errorOccur = $rsactivity[0]->errorOccur;
                $errorType = $rsactivity[0]->errorType; 
            }
            $data->created = $created;
            $data->pageVisited = $pageVisited;
            $data->os = $os;
            $data->deviceModel = $deviceModel;
            $data->errorOccur = $errorOccur;
            $data->errorType = $errorType;
            
            //dd($activityList);

            $sessionAddress = $data->sessionAddress;
            $sessionCity = $data->sessionCity;  
            
        }

        //     $object = [
        //         'storeName' => $storeName,
        //         'customerName' => $customerName,
        //         'sessionId' => $data['sessionId'],
        //         'startTimestamp' => $startTimestamp,
        //         'endTimestamp' => $endTimestamp,
        //         'timeSpent' => $timeSpent,
        //         'firstPage' => $firstPage,
        //         'lastPage' => $lastPage,
        //         'itemAdded' => $itemAdded,
        //         'orderCreated' => $orderCreated,
        //         'orderStatus' => $orderStatus,
        //         'activity_list' => $activityList,
        //         'order_details' => $orderDetails,
        //         'location' => $sessionAddress.", ".$sessionCity
        //     ];

            
        //     array_push( 
        //         $newArray,
        //         $object
        //     );

        // }

        // $datas = $newArray;

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

        $selectedCountry = $req->region;
        Session::put('selectedCountry', $selectedCountry);

        //query group by sessionId
        $query = UserActivity::select('csession.address AS sessionAddress', 'csession.city AS sessionCity', 'customer_activities.sessionId','customer_activities.storeId','customer_activities.customerId')
                ->leftjoin('customer_session as csession', 'customer_activities.sessionId', '=', 'csession.sessionId')
                ->whereBetween('customer_activities.created', [$start_date, $end_date." 23:59:59"]);

         if($req->region == "MYS"){
            $query->where(function ($query) {
                $query->where('pageVisited', 'like', '%dev-my%')
                ->orWhere('pageVisited', 'like', '%deliverin.my%');
            });           
          }

          if($req->region == "PAK"){
             $query->where(function ($query) {
                $query->where('pageVisited', 'like', '%dev-pk%')
                ->orWhere('pageVisited', 'like', '%easydukan.co%');
            });              
          }



        if ($req->storename_chosen<>"") {
            $search_store_info = Store::where('name', 'like',  '%'.$req->storename_chosen.'%' )->get(); 
            $search_storeId_list = array();        
            if (count($search_store_info) > 0) {
               foreach ($search_store_info as $storefound) {
                    array_push($search_storeId_list, $storefound['id']);
               }
            }  
            $query->whereIn('storeId', $search_storeId_list);
            //dd($query);
        }


        if ($req->customer_chosen<>"") {
            $search_customer_info = Customer::where('name', 'like', '%'.$req->customer_chosen.'%')->get();
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

        $query->groupBy('customer_activities.sessionId')->orderBy('customer_activities.created', 'DESC');
        $datas = $query->paginate(15);

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

            $data->startTime=$startTimestamp;
            $data->firstpage=$firstPage;
            $data->endTime=$endTimestamp;
            $data->lastpage=$lastPage;
            $data->timespent=$timeSpent;

                        
            //check if any item in cart
            $sql="SELECT * FROM cart_item WHERE cartId='".$data['sessionId']."'";
            $rsitem = DB::connection('mysql2')->select($sql);
            if (count($rsitem)>0) {
                $itemAdded="YES";
            } else {
                $itemAdded="NO";
            }

            $data->AddedItem=$itemAdded;

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

            $data->orderCreated=$orderCreated;
            $data->orderStatus=$orderStatus;

            // $storeName = '';
            // if (! array_key_exists($storeId, $storeList)) {
            //     $store_info = Store::where('id', $storeId)
            //                         ->get();
            //     if (count($store_info) > 0) {
            //         $storeList[$storeId] = $store_info[0]['name']; 
            //         $storeName = $storeList[$storeId];
            //     }    

            // } else {
            //     $storeName = $storeList[$storeId];
            // }
             

            // $customerName = '';
            // if (! array_key_exists($customerId, $customerList)) {            
            //     $customer_info = Customer::where('id', $customerId)
            //                         ->get();
            //     if (count($customer_info) > 0) {
            //         $customerList[$customerId] = $customer_info[0]['name']; 
            //         $customerName = $customerList[$customerId];
            //     }  
                
            // } else {
            //     $customerName = $customerList[$customerId];
            // }

            $sql="SELECT id, name FROM store WHERE id='".$data->storeId."'";
            $store = DB::connection('mysql2')->select($sql);
            if (count($store) > 0) {
                $storename=$store[0]->name;
            } else{
                $storename= "";
            }
            $data->storeName = $storename;


            $sql="SELECT id, username FROM customer WHERE id='".$data->customerId."'";
            $customer = DB::connection('mysql2')->select($sql);
            if (count($customer) > 0) {
                $customername=$customer[0]->username;
            } else{
                $customername= "";
            }
            $data->customerName = $customername;


             //get all history
            $sql="SELECT created, pageVisited, os, deviceModel, errorOccur, errorType FROM customer_activities WHERE sessionId='".$data['sessionId']."' ORDER BY created ASC";
            $rsactivity = DB::connection('mysql3')->select($sql);
             if (count($rsactivity) > 0) {
                 $created = $rsactivity[0]->created;
                 $pageVisited = $rsactivity[0]->pageVisited;
                 $os = $rsactivity[0]->os;
                 $deviceModel = $rsactivity[0]->deviceModel;
                 $errorOccur = $rsactivity[0]->errorOccur;
                 $errorType = $rsactivity[0]->errorType; 
             }
             $data->created = $created;
             $data->pageVisited = $pageVisited;
             $data->os = $os;
             $data->deviceModel = $deviceModel;
             $data->errorOccur = $errorOccur;
             $data->errorType = $errorType;
             
            //dd($activityList);

            $sessionAddress = $data->sessionAddress;
            $sessionCity = $data->sessionCity; 
            
        }

        //     $object = [
        //         'storeName' => $storeName,
        //         'customerName' => $customerName,
        //         'sessionId' => $data['sessionId'],
        //         'startTimestamp' => $startTimestamp,
        //         'endTimestamp' => $endTimestamp,
        //         'timeSpent' => $timeSpent,
        //         'firstPage' => $firstPage,
        //         'lastPage' => $lastPage,
        //         'itemAdded' => $itemAdded,
        //         'orderCreated' => $orderCreated,
        //         'orderStatus' => $orderStatus,
        //         'orderId' => $orderId,
        //         'activity_list' => $activityList,
        //         'order_details' => $orderDetails,
        //         'location' => $sessionAddress.", ".$sessionCity
        //     ];

            
        //     array_push( 
        //         $newArray,
        //         $object
        //     );

        // }
       
        // $datas = $newArray;

        $datechosen = $req->date_chosen4;   
        $storename = $req->storename_chosen;
        $customername = $req->customer_chosen;
        $device = $req->device_chosen;
        $browser = $req->browser_chosen;

        return view('components.usersitemap', compact('datas','datechosen','storename','customername','device','browser'));
    }


    public function export_usersitemap(Request $req) 
    {
        $data = $req->input();

        $dateRange = explode( '-', $req->date_chosen4_copy );
        $start_date = $dateRange[0];
        $end_date = $dateRange[1];

        $start_date = date("Y-m-d", strtotime($start_date));
        $end_date = date("Y-m-d", strtotime($end_date));

        return Excel::download(new UserSiteMapExport($start_date, $end_date." 23:59:59"), 'usersitemap.xlsx');
    }

    public function getactivity_details($sessionId){
        $query = UserActivity::select('customer_activities.*','csession.address AS sessionAddress', 'csession.city AS sessionCity')
                        ->where('customer_activities.sessionId', $sessionId)  
                        ->leftjoin('customer_session as csession', 'customer_activities.sessionId', '=', 'csession.sessionId');
        $datas = $query->paginate(100);
        //dd($datas);
        $html="";
        foreach ($datas as $data) {
         //dd($data);  
            $sql="SELECT id, name FROM store WHERE id='".$data->storeId."'";
            $store = DB::connection('mysql2')->select($sql);
            if (count($store) > 0) {
                $storename=$store[0]->name;
            } else{
                $storename= "";
            }
            $data->storeName = $storename;

            $html .= "<tr>
                 <td width='30%'> ".$data->pageVisited."</td>                
                 <td width='20%'> ".$data->storeName."</td>   
                 <td width='20%'> ".$data->channel."</td>   
                 <td width='10%'> ".$data->created."</td>
              </tr>";
         }
         $response['html'] = $html;
   
         return response()->json($response);
    }


    public function getcart_details($sessionId){
        $sql="SELECT cartId FROM customer_session_carts WHERE sessionId='".$sessionId."'";
        $datas = DB::connection('mysql3')->select($sql);
        
        $html="";
        foreach ($datas as $data) {
         //dd($data);
            $sql="SELECT cart.*, store.name FROM cart INNER JOIN store ON cart.storeId=store.id WHERE cart.id='".$data->cartId."'";  
            $cart = DB::connection('mysql2')->select($sql);
            if (count($cart) > 0) {
                $store=$cart[0]->name;
            } else{
                $store= "";
            }

            $sql="SELECT * FROM cart_item WHERE cartId='".$data->cartId."'";
            $item = DB::connection('mysql2')->select($sql);
            if (count($item) > 0) {
                $itemAdded="YES";
            } else{
                $itemAdded= "NO";
            }
            $data->itemAdded = $itemAdded;
            $data->store = $store;

            $html .= "<tr>
                 <td width='45%'> ".$data->cartId."</td>                
                 <td width='45%'> ".$data->store."</td>                   
                 <td width='10%'> ".$data->itemAdded."</td>
              </tr>";
         }
         $response['html'] = $html;
   
         return response()->json($response);
    }


    public function getorder_details($sessionId){
        $sql="SELECT cartId FROM customer_session_carts WHERE sessionId='".$sessionId."'";
        $datas = DB::connection('mysql3')->select($sql);
        
        $html="";
        foreach ($datas as $data) {
         //dd($data);
            $sql="SELECT A.*, B.name FROM `order` A INNER JOIN store B ON A.storeId=B.id WHERE A.cartId='".$data->cartId."'";  
            $order = DB::connection('mysql2')->select($sql);   
            //dd($order);
            //echo $sql."<br>\n";
            if (count($order) > 0) {
                $html .= "<tr>
                     <td width='45%'> ".$order[0]->id."&nbsp;</td> 
                     <td width='45%'> ".$order[0]->name."&nbsp;</td> 
                     <td width='45%'> ".$order[0]->completionStatus."&nbsp;</td>                   
                     <td width='45%'> ".$order[0]->invoiceId."&nbsp;</td>                   
                     <td width='10%'> ".$order[0]->paymentStatus."&nbsp;</td>
                     <td width='10%'> ".$order[0]->created."</td>
                  </tr>";
            }
         }
         $response['html'] = $html;
   
         return response()->json($response);
    }


    public function userdata(){
        //query by Customer
        $selectedCountry = Session::get('selectedCountry');
        
        if($selectedCountry == 'MYS') {
            $datas = Customer::where('countryId', '=', 'MYS')->paginate(10);
        }
        if($selectedCountry == 'PAK'){
            $datas = Customer::where('countryId', '=', 'PAK')->paginate(10);
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
        $custnamechosen='';
        return view('components.userdata', compact('datas','custnamechosen'));
        }


        //Product Details Popup for Incomplete order
        public function getuserdatadetails_incompleteorder($orderId = 0){
            //dd($orderId);                      
             $sql="SELECT * FROM order_item A INNER JOIN `order` B ON A.orderId=B.id WHERE completionStatus = 'RECEIVED_AT_STORE' AND customerId='".$orderId."'";
             //dd($sql);
             $datas = DB::connection('mysql2')->select($sql);
 
             $html = "";
             //dd($datas);
            foreach ($datas as $data) {
             //dd($data);              
                $html .= "<tr>
                     <td width='30%'> ".$data->productId."</td>                
                     <td width='20%'> ".$data->productName."</td>              
                     <td width='10%'> ".$data->quantity."</td>
                  </tr>";
             }
             $response['html'] = $html;
       
             return response()->json($response);
         }


        //Product Details Popup for Complete order
        public function getuserdatadetails_completeorder($orderId = 0){
             //dd($orderId);                      
             $sql="SELECT * FROM order_item A INNER JOIN `order` B ON A.orderId=B.id WHERE completionStatus<>'RECEIVED_AT_STORE' AND customerId='".$orderId."'";
             //dd($sql);
             $datas = DB::connection('mysql2')->select($sql);
 
             $html = "";
             //dd($datas);
            foreach ($datas as $data) {
             //dd($data);              
                $html .= "<tr>
                     <td width='30%'> ".$data->productId."</td>                
                     <td width='20%'> ".$data->productName."</td>              
                     <td width='10%'> ".$data->quantity."</td>
                  </tr>";
             }
             $response['html'] = $html;
       
             return response()->json($response);
         }


        //Product Details Popup for Abandon Cart
        public function getuserdatadetails_abandoncart($cartId = 0){
            //dd($orderId);                      
             $sql="SELECT * FROM cart_item A INNER JOIN `cart` B ON A.cartId=B.id WHERE customerId='".$cartId."'";
             //dd($sql);
             $datas = DB::connection('mysql2')->select($sql);
 
             $html = "";
             //dd($datas);
            foreach ($datas as $data) {
             //dd($data);              
                $html .= "<tr>
                     <td width='30%'> ".$data->productId."</td>                
                     <td width='20%'> ".$data->productName."</td>              
                     <td width='10%'> ".$data->quantity."</td>
                  </tr>";
             }
             $response['html'] = $html;
       
             return response()->json($response);
         }
        
 

        public function filter_userdata(Request $req){

        //queryby id
        $data = $req->input();
        $query = Customer::select('customer.*');

        $selectedCountry = $req->region;
        Session::put('selectedCountry', $selectedCountry);
        
        if($req->region == "MYS"){
            $query->where('countryId', '=', 'MYS');       
        }

        if($req->region == "PAK"){
                $query->where('countryId', '=', 'PAK');            
        }

        if ($req->custname_chosen<>"") {
            $query->where('name', 'like', '%'.$req->custname_chosen.'%');
        }

        $datas = $query->paginate(10);

        foreach ($datas as $data) {
        
        if ($req->customer_chosen<>"") {
                $search_customer_info = Customer::where('name', 'like', '%'.$req->customer_chosen.'%')->get();
                if (count($search_customer_info) > 0) {
                   $search_customerId = $search_customer_info[0]['id']; 
                } else {
                    $search_customerId = "NOT FOUND";
                }
                $sql .= " AND customerId = '".$search_customerId."'";
                //dd($query);
            }


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
        $sql="SELECT*FROM `order` WHERE completionStatus<>'RECEIVED_AT_STORE' AND customerId='".$data['id']."'";
        $rsordercomplete = DB::connection('mysql2')->select($sql);
            if (count($rsordercomplete)>0) {
                $orderCompleted="YES";
            } else {
                $orderCompleted="NO";
            }
            $data->Completed = $orderCompleted;

        //check for Order Incompleted
        $sql="SELECT*FROM `order` WHERE completionStatus = 'RECEIVED_AT_STORE' AND customerId='".$data['id']."'";
        $rsorderIncomplete = DB::connection('mysql2')->select($sql);
            if (count($rsorderIncomplete)>0) {
                $orderIncomplete="YES";
            } else {
                $orderIncomplete="NO";
            }
            $data->Incomplete = $orderIncomplete;
    }        
    $custnamechosen = $req->custname_chosen;
    return view('components.userdata', compact('datas','custnamechosen'));
    }


    public function export_userdata(Request $req) 
    {
        $data = $req->input();
        return Excel::download(new UserdataExport, 'userdata.xlsx');
    }


    public function useractivitysummary(){

        $datas=array();
        $date = new DateTime('7 days ago');
        $datechosen = $date->format('F d, Y')." - ".date('F d, Y'); 
        $selectedCountry = Session::get('selectedCountry'); 
        $storename=null;
        $customername=null;
        $device=null;
        $browser=null;
        $groupbrowser=null;
        $groupdevice=null;
        $groupos=null;
        $grouppage=null;
        $groupstore=null;
        $MYS=null;
        $PAK=null;

        return view('components.useractivitysummary', compact('datas','datechosen','storename','customername','device','browser', 'groupstore','groupbrowser','groupdevice','groupos','grouppage','MYS','PAK'));        
    }
   

    public function filter_useractivitysummary(Request $req){

       // echo "excel:".$req->exportExcel;

        $date = new DateTime('7 days ago');

        $data = $req->input();

        $dateRange = explode( '-', $req->date_chosen4 );
        $start_date = $dateRange[0];
        $end_date = $dateRange[1];

        $start_date = date("Y-m-d", strtotime($start_date));
        $end_date = date("Y-m-d", strtotime($end_date));

        $selectedCountry = $req->region;
        Session::put('selectedCountry', $selectedCountry);

        $groupList="COUNT(*) AS total, COUNT(DISTINCT(sessionId)) AS totalUnique"; 

        $where="";

        if($req->region == "all"){
            $where= "AND pageVisited IS NOT NULL";
          }

        if($req->region == "MYS"){
            $where= "AND (pageVisited like '%deliverin.my%' OR pageVisited like '%dev-my%')";
          }

          if($req->region == "PAK"){
            $where = "AND (pageVisited like '%easydukan.co%' OR pageVisited like '%dev-pk%')";
            // $where = UserActivity::where('pageVisited', 'like', '%dev-my%')->get();
          }  
  

        $groupBy=""; 
        if ($req->groupstore<>"") {
            $groupList .= " , storeId";
            if ($groupBy=="")
                $groupBy .= " storeId";
            else
                $groupBy .= " , storeId";
        }      
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
        $sql="SELECT ".$groupList." FROM customer_activities WHERE created BETWEEN '".$start_date."' AND '".$end_date." 23:59:59'";
        //dd($sql);
        
        if ($req->storename_chosen<>"") {
            $search_store_info = Store::where('name', 'like',  '%'.$req->storename_chosen.'%' )->get(); 
            $search_storeId_list = array();  
            $commaList="";      
            if (count($search_store_info) > 0) {
               foreach ($search_store_info as $storefound) {
                    if ($commaList=="") 
                        $commaList = "'".$storefound['id']."'";
                    else
                        $commaList .= ",'".$storefound['id']."'";                    
               }
            }  
            $sql .= " AND storeId IN (".$commaList.")";
        }

        //DB::enableQueryLog();
        // dd($sql);
        // $queries = DB::getQueryLog();
        // dd($queries);

        if ($req->customer_chosen<>"") {
            $search_customer_info = Customer::where('name', 'like', '%'.$req->customer_chosen.'%')->get();
            if (count($search_customer_info) > 0) {
               $search_customerId = $search_customer_info[0]['id']; 
            } else {
                $search_customerId = "NOT FOUND";
            }
            $sql .= " AND customerId = '".$search_customerId."'";
            //dd($query);
        }
        if ($req->device_chosen<>"") {
            $sql .= " AND deviceModel = '".$req->device_chosen."'";            
        }
        if ($req->browser_chosen<>"") {
            $sql .= " AND browserType = '".$req->browser_chosen."'";            
        }

        $sql .= $where;
        $sql .= " GROUP BY ".$groupBy;

        $datas = DB::connection('mysql3')->select($sql);

        if ($req->groupstore<>"") {
            $storeList=array();
            $newArray = array();        
            foreach ($datas as $data) {    
                $storeName = '';
                if (! array_key_exists($data->storeId, $storeList)) {
                    $store_info = Store::where('id', $data->storeId)
                                        ->get();
                    if (count($store_info) > 0) {
                        $storeList[$data->storeId] = $store_info[0]['name']; 
                        $storeName = $storeList[$data->storeId];
                    }    

                } else {
                    $storeName = $storeList[$data->storeId];
                }
                
                $data->storeName =  $storeName;
                $object = $data;

                array_push( 
                    $newArray,
                    $object
                );

            }           

            $datas = $newArray;
        }
//defect

        $groupstore=$req->groupstore;
        $groupbrowser=$req->groupbrowser;
        $groupdevice=$req->groupdevice;
        $groupos=$req->groupos;
        $grouppage=$req->grouppage;

        $datechosen = $req->date_chosen4;                
        $storename = $req->storename_chosen;
        $customername = $req->customer_chosen;
        $device = $req->device_chosen;
        $browser = $req->browser_chosen;
        $MYS = $req->MYS;
        $PAK = $req->PAK;

        if ($req->exportExcel==1) {
             return Excel::download(new UserActivitySummaryExport($datas, $req), 'CustomerSummary.xlsx');
         } else {
            return view('components.useractivitysummary', compact('datas','datechosen','storename','customername','device','browser','groupstore','groupbrowser','groupdevice','groupos','grouppage','MYS','PAK'));    
         }
        
    }    

    public function visitchannel(){
        $to = date("Y-m-d");
        $date = new DateTime('3 days ago');
        $from = $date->format("Y-m-d");
        $selectedCountry = Session::get('selectedCountry'); 
        // $datas = array();
        // $datas = Client::limit(100)->get();
        $datas = array();
        // $datas = DB::select('SELECT COUNT(*), channel, DATE(created)  FROM symplified_analytic.customer_activities 
        // WHERE  DATE(created) BETWEEN ? 
        // AND ? GROUP BY CHANNEL, DATE(created)',[$from,$to]);
        if($selectedCountry == 'MYS'){
        $sql = 
        " SELECT DATE(created) as created,
         count(case WHEN LOWER(channel) = 'Google' then 1 end) as countG,
         count(case WHEN LOWER(channel) = 'Facebook'  then 1 end) as countF,
         count(case WHEN LOWER(channel) IS NULL then 1 end) as countO
         from customer_activities
         WHERE  DATE(created) BETWEEN '".$from."' AND '".$to."' AND (pageVisited like '%deliverin.my%' OR pageVisited like '%dev-my%') 
         GROUP BY DATE(created)";
        }
        if($selectedCountry == 'PAK'){
            $sql = 
            " SELECT DATE(created) as created,
             count(case WHEN LOWER(channel) = 'Google' then 1 end) as countG,
             count(case WHEN LOWER(channel) = 'Facebook'  then 1 end) as countF,
             count(case WHEN LOWER(channel) IS NULL then 1 end) as countO
             from customer_activities
             WHERE  DATE(created) BETWEEN '".$from."' AND '".$to."' AND (pageVisited like '%easydukan.co%' OR  pageVisited like '%dev-pk%') 
             GROUP BY DATE(created)";
        }

        $datas = DB::connection('mysql3')->select($sql);
        // $datas = array();
        // var_dump(datas);
        // foreach ($datas as $data) {
        // }
        $datechosen = $date->format('F d, Y')." - ".date('F d, Y');  
        // var_dump(datas);
        return view('components.visitchannel', compact('datas','datechosen'));
        
    }


    public function filter_visitchannel(Request $req){
        
        $data = $req->input();

        $dateRange = explode( '-', $req->date_chosen4 );
        $start_date = $dateRange[0];
        $end_date = $dateRange[1];

        $start_date = date("Y-m-d", strtotime($start_date));
        $end_date = date("Y-m-d", strtotime($end_date))." 23:59:59";

        $selectedCountry = $req->region;
        Session::put('selectedCountry', $selectedCountry);

        $datas = array();
        // $datas = DB::select('SELECT COUNT(*), channel, DATE(created)  FROM symplified_analytic.customer_activities 
        // WHERE  DATE(created) BETWEEN ? 
        // AND ? GROUP BY CHANNEL, DATE(created)',[$from,$to]);
        
         $sql = 
        "SELECT DATE(created) as created,
         count(case WHEN LOWER(channel) = 'Google' then 1 end) as countG,
         count(case WHEN LOWER(channel) = 'Facebook'  then 1 end) as countF,
         count(case WHEN LOWER(channel) IS NULL then 1 end) as countO
         from customer_activities
         WHERE  DATE(created) BETWEEN '".$start_date."' AND '".$end_date."' ";

         $where="";

        if($req->region == "MYS"){
            $where= "AND (pageVisited like '%deliverin.my%' OR pageVisited like '%dev-my%') GROUP BY DATE(created) ";
          }
          if($req->region == "PAK"){
            $where = "AND (pageVisited like '%easydukan.co%' OR  pageVisited like '%dev-pk%') GROUP BY DATE(created) ";
            // $where = UserActivity::where('pageVisited', 'like', '%dev-my%')->get();
          }  
         
        $sql .= $where;
        $datas = DB::connection('mysql3')->select($sql);
        // $datas = array();
        // var_dump(datas);
        $datechosen = $req->date_chosen4;
                
        return view('components.visitchannel', compact('datas','datechosen'));

    }

    public function export_visitchannel(Request $req){

        $data = $req->input();

        $dateRange = explode( '-', $req->date_chosen4_copy );
        $start_date = $dateRange[0];
        $end_date = $dateRange[1];

        $start_date = date("Y-m-d", strtotime($start_date));
        $end_date = date("Y-m-d", strtotime($end_date));
        return Excel::download(new AbandonCartExport($start_date, $end_date." 23:59:59"), 'visitchannel.xlsx');
    }
        
    public function userabandoncartsummary(){

            $to = date("Y-m-d")." 23:59:59";
            $date = new DateTime('30 days ago');
            $from = $date->format("Y-m-d");
            $datas = array();
            $datechosen = $date->format('F d, Y')." - ".date('F d, Y');  
            $storename = ''; 

            $sql="SELECT COUNT(DISTINCT(cartId)) AS total, storeId, name
                    FROM cart_item A INNER JOIN cart B ON A.cartId=B.id
                    INNER JOIN store C ON B.storeId=C.id
                WHERE B.created BETWEEN '".$from."' AND '".$to."'
                    GROUP BY storeId";
            //dd($sql);
            $datas = DB::connection('mysql2')->select($sql); 
            return view('components.userabandoncartsummary', compact('datas','datechosen','storename'));
    }

    public function filter_userabandoncartsummary(Request $req){

            $date = new DateTime('7 days ago');

            $data = $req->input();

            $dateRange = explode( '-', $req->date_chosen4 );
            $start_date = $dateRange[0];
            $end_date = $dateRange[1];

            $start_date = date("Y-m-d", strtotime($start_date));
            $end_date = date("Y-m-d", strtotime($end_date))." 23:59:59";

            $sql="SELECT COUNT(DISTINCT(cartId)) AS total, storeId, name 
                    FROM cart_item A INNER JOIN cart B ON A.cartId=B.id
                    INNER JOIN store C ON B.storeId=C.id
                WHERE B.created BETWEEN '".$start_date."' AND '".$end_date."'
                    GROUP BY storeId";
            //dd($sql);
            $datas = DB::connection('mysql2')->select($sql);

            $datechosen = $req->date_chosen4;    
            $storename = '';   
            
            return view('components.userabandoncartsummary', compact('datas','datechosen','storename'));
    }
    

    public function filter_userabandoncart(Request $req){

            $data = $req->input();

            $dateRange = explode( '-', $req->date_chosen4 );
            $start_date = $dateRange[0];
            $end_date = $dateRange[1];

            $start_date = date("Y-m-d", strtotime($start_date));
            $end_date = date("Y-m-d", strtotime($end_date));

            //query group by sessionId
            $datas = Cart::select('id','customerId','storeId','created','updated','isOpen', 'stage','serviceType')
                            ->whereBetween('created', [$start_date, $end_date." 23:59:59"])  
                            ->where('isOpen',1)
                            ->where('storeId', $req->storeId)
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

                 //find delivery details
                $deliveryAddress = "";
                $deliveryFee = "";
                $sql="SELECT deliveryAddress, amount FROM delivery_quotation WHERE cartId='".$data['id']."' ORDER BY createdDate DESC LIMIT 1";
                $rsdelivery = DB::connection('mysql2')->select($sql);
                if (count($rsdelivery)>0) {
                    $deliveryAddress = $rsdelivery[0]->deliveryAddress;
                    $deliveryFee = $rsdelivery[0]->amount;
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
                    'stage' => $data['stage'],
                    'serviceType' => $data['serviceType'],
                    'storeName' => $storeName,
                    'customerName' => $customerName,
                    'itemAdded' => $itemAdded,
                    'deliveryAddress' => $deliveryAddress,
                    'deliveryFee' => $deliveryFee,
                    'item_list' => $item_array
                ];

                if ($itemAdded=="YES") {

                    array_push( 
                        $newArray,
                        $object
                    );

                }

        }
           
            $datas = $newArray;
            //dd($datas);
            $datechosen = $req->date_chosen4;   
            $storename = $req->storename;;   
            $customername = '';
            $device = '';  
            $browser = ''; 

            return view('components.userabandoncart', compact('datas','datechosen','storename','customername'));

        }

        public function export_userabandoncart(Request $req){

            $data = $req->input();
    
            $dateRange = explode( '-', $req->date_chosen4_copy );
            $start_date = $dateRange[0];
            $end_date = $dateRange[1];
    
            $start_date = date("Y-m-d", strtotime($start_date));
            $end_date = date("Y-m-d", strtotime($end_date));
            return Excel::download(new AbandonCartExport($start_date, $end_date." 23:59:59"), 'abandoncart.xlsx');
        }
    


    public function userincompleteorder(){
            $to = date("Y-m-d");
            $date = new DateTime('30 days ago');
            $from = $date->format("Y-m-d");
            
            $datas1 = Order::select('order.*', 'store.name AS storeName', 'customer.name AS customerName')
                            ->join('store AS store', 'order.storeId', 'store.id')
                            ->join('customer AS customer', 'order.customerId', 'customer.id')
                            ->where([
                                ['completionStatus','=','RECEIVED_AT_STORE'],
                                ['paymentStatus','<>','PAID'],
                                ['order.paymentType','=','ONLINEPAYMENT']
                            ])
                            ->whereBetween('order.created', [$from, $to." 23:59:59"]);

            $datas = Order::select('order.*', 'store.name AS storeName', 'customer.name AS customerName')
                            ->join('store AS store', 'order.storeId', 'store.id')
                            ->join('customer AS customer', 'order.customerId', 'customer.id')
                            ->where([
                                ['completionStatus','=','PAYMENT_FAILED'],
                            ])
                            ->whereBetween('order.created', [$from, $to." 23:59:59"])
                            ->union($datas1)
                            ->orderBy('created','DESC')
                            ->paginate(10);
            // dd($datas);
            foreach ($datas as $data) {
                $sql="SELECT B.customerId, address, email, phoneNumber FROM `order_shipment_detail` A
                INNER JOIN `order` B ON A.orderId=B.id WHERE orderId='".$data->id."'";
                //dd($sql);
                $customerdetail = DB::connection('mysql2')->select($sql);
                if (count($customerdetail) > 0) {
                    $customernumber=$customerdetail[0]->phoneNumber;
                    $customeraddress=$customerdetail[0]->address;
                    $customeremail=$customerdetail[0]->email;
                }
                $data->phoneNumber= $customernumber;
                $data->address = $customeraddress;
                $data->email = $customeremail;

                //check if any item in cart
                $sql="SELECT GROUP_CONCAT(B.productName) AS productName, GROUP_CONCAT(B.quantity) AS quantity,  GROUP_CONCAT(productId) AS productId, C.customerId, D.name
                FROM `order` A
                INNER JOIN order_item B ON A.id=B.orderId 
                INNER JOIN order_group C ON A.orderGroupId=C.id
                INNER JOIN customer D ON A.customerId=D.id WHERE orderId='".$data->id."' GROUP BY C.customerId ";
                //dd($sql);
                $productdetail = DB::connection('mysql2')->select($sql);
                if (count($productdetail) > 0) {
                    foreach ($productdetail as $detail) {
                    $productname=$productdetail[0]->productName;
                    $productquantity=$productdetail[0]->quantity;
                    $productid=$productdetail[0]->productId;
                    }
                }
                $data->productName = $productname;
                $data->quantity = $productquantity;
                $data->productId = $productid;
            }
        //     $sql="SELECT B.productName AS productName, B.quantity AS Quantity, productId AS productId, C.customerId 
        //     FROM `order` A INNER JOIN order_item B ON A.id=B.orderId INNER JOIN order_group C ON A.orderGroupId=C.id
        //     INNER JOIN customer D ON A.customerId=D.id WHERE cartId='".$data['id']."' GROUP BY C.customerId";
        //     $rsitem = DB::connection('mysql2')->select($sql);

        //     $item_array = array();
        //     if (count($rsitem) > 0) {
        //         foreach ($rsitem as $item) {

        //             $item_details = [
        //                 'productId' => $item->productId,
        //                 'quantity' => $item->quantity,
        //                 'name' => $item->name                       
        //             ];
    
        //             array_push( 
        //                 $item_array,
        //                 $item_details
        //             );
                   
        //         }
        //     }
        //     $data->item_list = $item_array;
        // }
            $datechosen = $date->format('F d, Y')." - ".date('F d, Y'); 
            return view('components.userincompleteorder', compact('datas','datechosen'));
            
    
        }
    
        public function filter_userincompleteorder(Request $req){
    
            $date = new DateTime('7 days ago');
    
            $data = $req->input();
    
            $dateRange = explode( '-', $req->date_chosen4 );
            $start_date = $dateRange[0];
            $end_date = $dateRange[1];
    
            $start_date = date("Y-m-d", strtotime($start_date));
            $end_date = date("Y-m-d", strtotime($end_date))." 23:59:59";
    
            $query1 = Order::select('order.*', 'store.name AS storeName', 'customer.name AS customerName')
                ->join('store AS store', 'order.storeId', 'store.id')
                ->join('customer AS customer', 'order.customerId', 'customer.id')
                ->where([
                    ['completionStatus','=','RECEIVED_AT_STORE'],
                    ['paymentStatus','<>','PAID'],
                    ['order.paymentType','=','ONLINEPAYMENT']
                ])
                ->whereBetween('order.created', [$start_date, $end_date." 23:59:59"]);

            $query = Order::select('order.*', 'store.name AS storeName', 'customer.name AS customerName')
                ->join('store AS store', 'order.storeId', 'store.id')
                ->join('customer AS customer', 'order.customerId', 'customer.id')
                ->where([
                    ['completionStatus','=','PAYMENT_FAILED'],
                ])
                ->whereBetween('order.created', [$start_date, $end_date." 23:59:59"])
                ->union($query1);
                
            $datas = $query->orderBy('created','DESC')->paginate(10);

            foreach ($datas as $data) {
                
                $sql="SELECT B.customerId, address, email, phoneNumber FROM `order_shipment_detail` A
                INNER JOIN `order` B ON A.orderId=B.id WHERE orderId='".$data->id."'";
                //dd($sql);
                $customerdetail = DB::connection('mysql2')->select($sql);
                if (count($customerdetail) > 0) {
                    $customernumber=$customerdetail[0]->phoneNumber;
                    $customeraddress=$customerdetail[0]->address;
                    $customeremail=$customerdetail[0]->email;
                }
                $data->phoneNumber= $customernumber;
                $data->address = $customeraddress;
                $data->email = $customeremail;

                 //check if any item in cart
                 $sql="SELECT GROUP_CONCAT(B.productName) AS productName, GROUP_CONCAT(B.quantity) AS quantity,  GROUP_CONCAT(productId) AS productId, C.customerId, D.name
                 FROM `order` A
                 INNER JOIN order_item B ON A.id=B.orderId 
                 INNER JOIN order_group C ON A.orderGroupId=C.id
                 INNER JOIN customer D ON A.customerId=D.id WHERE orderId='".$data->id."' GROUP BY C.customerId ";
                 //dd($sql);
                 $productdetail = DB::connection('mysql2')->select($sql);
                 if (count($productdetail) > 0) {
                     foreach ($productdetail as $detail) {
                     $productname=$productdetail[0]->productName;
                     $productquantity=$productdetail[0]->quantity;
                     $productid=$productdetail[0]->productId;
                     }
                 }
                 $data->productName = $productname;
                 $data->quantity = $productquantity;
                 $data->productId = $productid;
            }
    
            $datechosen = $req->date_chosen4;          
            return view('components.userincompleteorder', compact('datas','datechosen'));
        }

        public function getdetails_incompleteorder($orderId = 0){
           // dd($orderId);                      
            $sql="SELECT * FROM order_item WHERE orderId='".$orderId."'";
            //dd($sql);
            $datas = DB::connection('mysql2')->select($sql);

            $html = "<tr><td width='30%'><b>Product ID</b></td>
                        <td width='20%'><b>Product Name</b></td>
                        <td width='10%'><b>Quantity</b></td></tr>";
            //dd($datas);
           foreach ($datas as $data) {
            //dd($data);              
               $html .= "<tr>
                    <td width='30%'> ".$data->productId."</td>                
                    <td width='20%'> ".$data->productName."</td>              
                    <td width='10%'> ".$data->quantity."</td>
                 </tr>";
            }
            $response['html'] = $html;
      
            return response()->json($response);
        }

        public function export_userincompleteorder(Request $req){

            $data = $req->input();
    
            $dateRange = explode( '-', $req->date_chosen4_copy );
            $start_date = $dateRange[0];
            $end_date = $dateRange[1];
    
            $start_date = date("Y-m-d", strtotime($start_date));
            $end_date = date("Y-m-d", strtotime($end_date));
            return Excel::download(new UserIncompleteOrderExport($start_date, $end_date." 23:59:59"), 'UserIncompleteOrder.xlsx');
        }
}