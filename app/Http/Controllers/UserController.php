<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use App\Models\User;
use App\Models\Client;
use App\Models\PaymentDetail as Payment;
use App\Models\Store;
use App\Models\StoreDeliveryDetail as StoreDelivery;
use Carbon\Carbon;
use DateTime;
use Session;

use App\Exports\UsersExport;
use App\Exports\DetailsExport;
use App\Exports\VoucherRedemptionExport;
use App\Exports\SettlementsExport;
use App\Exports\MerchantExport;
use App\Exports\MerchantAppActivityExport;
use App\Exports\GroupSalesExport;
use App\Exports\VoucherListExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UserController extends Controller
{

    protected $url;
    protected $token;

    function __construct() {
            $this->url = config('services.report_svc.url');
            $this->token = config('services.report_svc.token');
    }

    public function export() 
    {
        // $data = new UsersExport;

        // return $data;

        $from = "2021-08-01";
        $to = "2021-08-30";

        return Excel::download(new UsersExport($from, $to), 'users.xlsx');

        // return Excel::download(new MttRegistrationsExport($request->id), 'MttRegistrations.xlsx');
    }

    public function export_dashboard(Request $req) 
    {
        $data = $req->input();

        $dateRange = explode( '-', $req->date_chosen_copy );
        $start_date = $dateRange[0];
        $end_date = $dateRange[1];

        $start_date = date("Y-m-d", strtotime($start_date));
        $end_date = date("Y-m-d", strtotime($end_date));

        //dd($dateRange);

        // $from = "2021-08-01";
        // $to = "2021-08-30";

        return Excel::download(new UsersExport($start_date, $end_date), 'dailySalesSummary.xlsx');
    }

    public function export_detail(Request $req) 
    {
        $data = $req->input();

        $dateRange = explode( '-', $req->date_chosen2_copy );
        $start_date = $dateRange[0];
        $end_date = $dateRange[1];

        // return $start_date."|".$end_date;
        // return $data;
        // die();

        $start_date = date("Y-m-d", strtotime($start_date));
        $end_date = date("Y-m-d", strtotime($end_date));

        // $from = "2021-08-01";
        // $to = "2021-08-30";

        return Excel::download(new DetailsExport($start_date, $end_date), 'dailyDetailsSales.xlsx');
    }


    public function export_settlement(Request $req) 
    {
        $data = $req->input();

        $dateRange = explode( '-', $req->date_chosen3_copy );
        $start_date = $dateRange[0];
        $end_date = $dateRange[1];

        //dd($dateRange);
        // return $start_date."|".$end_date;
        // return $data;
        // die();

        $start_date = date("Y-m-d", strtotime($start_date));
        $end_date = date("Y-m-d", strtotime($end_date));

        // $from = "2021-08-01";
        // $to = "2021-08-30";

        return Excel::download(new SettlementsExport($start_date, $end_date), 'settlement.xlsx');
    }

    public function export_merchant(Request $req) 
    {
        $data = $req->input();

        $dateRange = explode( '-', $req->date_chosen4_copy );
        $start_date = $dateRange[0];
        $end_date = $dateRange[1];

        $start_date = date("Y-m-d", strtotime($start_date));
        $end_date = date("Y-m-d", strtotime($end_date));
        //dd($dateRange);
        // return $start_date."|".$end_date;
        // return $data;
        // die();
        

        // $from = "2021-08-01";
        // $to = "2021-08-30";

        return Excel::download(new MerchantExport($start_date, $end_date), 'merchant.xlsx');
    }

    public function export_voucherredemption(Request $req) 
    {
        $data = $req->input();

        $dateRange = explode( '-', $req->date_chosen2_copy );
        $start_date = $dateRange[0];
        $end_date = $dateRange[1];

        $start_date = date("Y-m-d", strtotime($start_date));
        $end_date = date("Y-m-d", strtotime($end_date));
        return Excel::download(new VoucherRedemptionExport($start_date, $end_date), 'voucherredemption.xlsx');
    }

    public function index_view ()
    {
        return view('pages.user.user-data', [
            'user' => User::class
        ]);
    }

    public function daily_sales (){

        // return view('dashboard', [
        //     'user' => User::class
        // ]);

       

        // $posts = Http::get('https://api.symplified.biz/report-service/v1/store/null/daily_sales?from=2021-06-01&to=2021-08-16')->object();
        $to = date("Y-m-d");
        $date = new DateTime('7 days ago');             
        $from = $date->format('Y-m-d');

        // return $from."|".$to;

        // die();

        $request = Http::withToken($this->token)->get($this->url.'/store/null/daily_sales', [
            'from' => $from,
            'to' => $to,
            'sortingOrder' => "DESC",
            'pageSize' => 1000
        ]);

        if($request->successful()){

            $days = $request['data']['content'];

            // $sales_arr = array();

            // foreach ($days as $index => $item) {
            //     // if index is greater than zero, you could access to previous element:
            //     // if ($item['qty'] == 0 && $index > 0 && $days[$index-1]['qty'] > 5) {
            //     //   $current_name = $item['name'];
            //     //   $previous_name = $myArray[$index-1]['name'];
            //     //   echo "'$current_name' is empty, check '$previous_name' for replenishment!";
            //     // } else {
            //     //   continue;
            //     // }

            //     if($index > 0){

            //     }else{
            //         $sales_arr[] = $item;
            //         $old_date = $item['date'];
            //     }
            // }

            // return $sales_arr;
        } else {
            $days = null;
        }

        // return $days;

        // die();
        //dd($days);
        $datechosen = $date->format('F d, Y')." - ".date('F d, Y');        
        //dd($testdata);
        return view('dashboard', compact('datechosen','days'));
    }

    public function daily_sales_filter(Request $req){

        // dd($user);
        // dd(Session::get('selectedCountry'));

        $data = $req->input();
        $dateRange = explode( '-', $req->date_chosen );
        $start_date = $dateRange[0];
        $end_date = $dateRange[1];

        $start_date = date("Y-m-d", strtotime($start_date));
        $end_date = date("Y-m-d", strtotime($end_date));

        $request = Http::withToken($this->token)->get($this->url.'/store/null/daily_sales', [
            'from' => $start_date,
            'to' => $end_date,
            'sortingOrder' => "DESC",
            'pageSize' => 1000
        ]);

        if($request->successful()){

            $days = $request['data']['content'];

        }

        //dd($req->date_chosen);
        $datechosen = $req->date_chosen;
        // return $days;
        // die();
        return view('dashboard', compact('days','datechosen'));

    }

    public function daily_details(){

        $to = date("Y-m-d");
        $date = new DateTime('7 days ago');
        $from = $date->format("Y-m-d");
        
        $request = Http::withToken($this->token)->get($this->url.'/store/null/report/detailedDailySales', [
            'startDate' => $from,
            'endDate' => $to,
            'sortingOrder' => "DESC",
            'pageSize' => 1000
        ]); 
        
        // $posts = Http::get('https://api.symplified.biz/report-service/v1/store/null/report/detailedDailySales?startDate=2021-07-1&endDate=2021-08-16')->json();
        if($request->successful()){

            $datas = $request['data'];

        }
        //dd($datas);

        // $newArray = array();
        
        // foreach($datas as $data){
        //     $date = $data['date'];

        //     foreach($data['sales'] as $item){

        //         $cur_item = array();

        //         array_push( 
        //             $cur_item,
        //             $data['date'],
        //             $item['storeId'], 
        //             $item['merchantName'],
        //             $item['storeName'],
        //             $item['subTotal'],
        //             $item['total'],
        //             $item['serviceCharge'],
        //             $item['deliveryCharge'],
        //             $item['customerName'],
        //             $item['orderStatus'],
        //             $item['deliveryStatus'],
        //             $item['commission']
        //         );

        //         $newArray[] = $cur_item;
        //     }
        // }
        
        // return $newArray;

        // die();

        // return $datas;
        // return json_decode($datas);
        $datechosen = $date->format('F d, Y')." - ".date('F d, Y');
        return view('components.daily-details', compact('datas','datechosen'));
    }

    public function daily_details_filter(Request $req){

        $data = $req->input();

        $dateRange = explode( '-', $req->date_chosen2 );
        $start_date = $dateRange[0];
        $end_date = $dateRange[1];

        $start_date = date("Y-m-d", strtotime($start_date));
        $end_date = date("Y-m-d", strtotime($end_date));

        $request = Http::withToken($this->token)->get($this->url.'/store/null/report/detailedDailySales', [
            'startDate' => $start_date,
            'endDate' => $end_date,
            'sortingOrder' => "DESC",
            'pageSize' => 1000
        ]); 
        
        // $posts = Http::get('https://api.symplified.biz/report-service/v1/store/null/report/detailedDailySales?startDate=2021-07-1&endDate=2021-08-16')->json();
        if($request->successful()){

            $datas = $request['data'];

        }

        // return $datas;
        $datechosen = $req->date_chosen2;
        return view('components.daily-details', compact('datas','datechosen'));
    }


    public function daily_group_details(){

        $to = date("Y-m-d");
        $date = new DateTime('7 days ago');
        $from = $date->format("Y-m-d");
        $selectedCountry = Session::get('selectedCountry');
        if($selectedCountry == 'MYS' || $selectedCountry == 'PAK') 
        {
            $request = Http::withToken($this->token)->get($this->url.'/store/null/orderGroupList', [
                'countryCode' => $selectedCountry,
                'from' => $from,
                'to' => $to,
                'sortBy' => 'created',            
                'sortingOrder' => "DESC",
                'pageSize' => 1000
            ]); 
        }
        else 
        {
            $request = Http::withToken($this->token)->get($this->url.'/store/null/orderGroupList', [
                'from' => $from,
                'to' => $to,
                'sortBy' => 'created',            
                'sortingOrder' => "DESC",
                'pageSize' => 1000
            ]); 
        }
        
        
        if($request->successful()){

            $result = $request['data'];

        }
        //dd($result['content']);
        $datas = $result['content'];
        
        // return json_decode($datas);
        $datechosen = $date->format('F d, Y')." - ".date('F d, Y');
        $region = '';
        return view('components.daily-group-details', compact('datas','datechosen'));
    }

    public function filter_daily_group_details(Request $req){

        $data = $req->input();

        $dateRange = explode( '-', $req->date_chosen2 );
        $start_date = $dateRange[0];
        $end_date = $dateRange[1];

        $start_date = date("Y-m-d", strtotime($start_date));
        $end_date = date("Y-m-d", strtotime($end_date));

        $selectedCountry = $req->region;
        if($selectedCountry == 'MYS' || $selectedCountry == 'PAK') 
        {
            $request = Http::withToken($this->token)->get($this->url.'/store/null/orderGroupList', [
                'countryCode' => $selectedCountry,
                'from' => $start_date,
                'to' => $end_date,
                'sortBy' => 'created',            
                'sortingOrder' => "DESC",
                'pageSize' => 1000
            ]); 
        }
        else 
        {
            $request = Http::withToken($this->token)->get($this->url.'/store/null/orderGroupList', [
                'from' => $start_date,
                'to' => $end_date,
                'sortBy' => 'created',            
                'sortingOrder' => "DESC",
                'pageSize' => 1000
            ]); 
        }

        if($request->successful()){

            $result = $request['data'];
        }

        $datas = $result['content'];
        $datechosen = $req->date_chosen2;
        $region = $req->region;
        return view('components.daily-group-details', compact('datas','datechosen'));
    }


    public function export_daily_group_details(Request $req) 
    {
        $data = $req->input();

        $dateRange = explode( '-', $req->date_chosen2_copy );
        $start_date = $dateRange[0];
        $end_date = $dateRange[1];

        // return $start_date."|".$end_date;
        // return $data;
        // die();

        $start_date = date("Y-m-d", strtotime($start_date));
        $end_date = date("Y-m-d", strtotime($end_date));

        // $from = "2021-08-01";
        // $to = "2021-08-30";

        return Excel::download(new GroupSalesExport($start_date, $end_date), 'dailyDetailsSales.xlsx');
    }


    public function voucherredemption(){

        $to = date("Y-m-d");
        $date = new DateTime('7 days ago');
        $from = $date->format("Y-m-d");
        
        $request = Http::withToken($this->token)->get($this->url.'/store/null/voucherOrderGroupList', [
            'from' => $from,
            'to' => $to,
            'sortingOrder' => "DESC",
            'pageSize' => 1000
        ]); 
        
        
        if($request->successful()){

            $result = $request['data'];

        }
        //dd($result['content']);
        $datas = $result['content'];
       
        //dd($datas);
        // return json_decode($datas);
        $datechosen = $date->format('F d, Y')." - ".date('F d, Y');
        return view('components.voucher-redemption', compact('datas','datechosen'));
    }

    public function filter_voucherredemption(Request $req){

        $data = $req->input();

        $dateRange = explode( '-', $req->date_chosen2 );
        $start_date = $dateRange[0];
        $end_date = $dateRange[1];

        $start_date = date("Y-m-d", strtotime($start_date));
        $end_date = date("Y-m-d", strtotime($end_date));
        //echo "startDate:".$start_date." endDate:".$end_date;
        $request = Http::withToken($this->token)->get($this->url.'/store/null/voucherOrderGroupList', [
            'from' => $start_date,
            'to' => $end_date,
            'sortingOrder' => "DESC",
            'pageSize' => 1000
        ]); 
        
        if($request->successful()){

            $result = $request['data'];

        }

        $datas = $result['content'];
        //dd($datas);

        // return $datas;
        $datechosen = $req->date_chosen2;
        return view('components.voucher-redemption', compact('datas','datechosen'));
    }


    public function settlement(){

        $to = date("Y-m-d");
        $date = new DateTime('30 days ago');
        $from = $date->format("Y-m-d");
        
        // https://api.symplified.biz/report-service/v1/store/null/settlement?from=2021-7-28&page=0&pageSize=20&sortBy=startDate&sortingOrder=ASC&to=2021-8-25
        $request = Http::withToken($this->token)->get($this->url.'/store/null/settlement', [
            'from' => $from,
            'to' => $to,
            'sortingOrder' => "DESC",
            'pageSize' => 1000
        ]); 

        // https://api.symplified.biz/report-service/v1/store/8913d06f-a63f-4a16-8059-2a30a517663a/settlement?from=2021-7-29&page=0&pageSize=20&sortBy=startDate&sortingOrder=DESC&to=2021-8-26
        
        // $posts = Http::get('https://api.symplified.biz/report-service/v1/store/null/report/detailedDailySales?startDate=2021-07-1&endDate=2021-08-16')->json();
        if($request->successful()){
            $datas = $request['data']['content'];
        }


        // return $datas;
        // die();
        // return json_decode($datas);
        $datechosen = $date->format('F d, Y')." - ".date('F d, Y');
        return view('components.settlement', compact('datas','datechosen'));
    }

    public function filter_settlement(Request $req){

        $data = $req->input();

        $dateRange = explode( '-', $req->date_chosen3 );
        $start_date = $dateRange[0];
        $end_date = $dateRange[1];

        $start_date = date("Y-m-d", strtotime($start_date));
        $end_date = date("Y-m-d", strtotime($end_date));

        $request = Http::withToken($this->token)->get($this->url.'/store/null/settlement', [
            'from' => $start_date,
            'to' => $end_date,
            'sortingOrder' => "DESC",
            'pageSize' => 1000
        ]); 
        
        // $posts = Http::get('https://api.symplified.biz/report-service/v1/store/null/report/detailedDailySales?startDate=2021-07-1&endDate=2021-08-16')->json();
        if($request->successful()){

            $datas = $request['data']['content'];

        }

        // return $datas;
        // die();
        $datechosen = $req->date_chosen3;
        return view('components.settlement', compact('datas','datechosen'));
    }

    public function merchant(){

        $to = date("Y-m-d")." 23:59:59";
        $date = new DateTime('30 days ago');
        $from = $date->format("Y-m-d");

        // $datas = Client::limit(100)->get();
        $datas = Client::whereBetween('created', [$from, $to])
                        ->where('roleId', 'STORE_OWNER')
                        ->orderBy('created', 'DESC')
                        ->get();                   
       
        $newArray = array();

        foreach ($datas as $data) {

            $payment_info = Payment::where('clientId', $data['id'])
                                    ->limit(1)
                                    ->get();

            $stores = Store::where('clientId', $data['id'])
                            ->join('store_delivery_detail as delivery', 'store.id', '=', 'delivery.storeId')
                            ->get();

            $pay_array = array();
            $store_array = array();

            if (count($payment_info) > 0) {
                foreach ($payment_info as $payment) {

                    $payment_data = [
                        'bankName' => $payment['bankName'],
                        'bankAccountNumber' => $payment['bankAccountNumber'],
                        'bankAccountTitle' => $payment['bankAccountTitle'],
                        'clientId' => $payment['clientId'],
                    ];
    
                    array_push( 
                        $pay_array,
                        $payment_data
                    );
    
                }
            }

            if (count($stores) > 0) {
                foreach ($stores as $store) {

                    $store_details = [
                        'storeId' => $store['id'],
                        'clientId' => $store['clientId'],
                        'name' => $store['name'],
                        'storeDescription' => $store['storeDescription'],
                        'address' => $store['address'],
                        'city' => $store['city'],
                        'postcode' => $store['postcode'],
                        'state' => $store['state'],
                        'email' => $store['email'],
                        'phone' => $store['phone'],
                        'verticalCode' => $store['verticalCode'],
                        'type' => $store['type'],
                    ];
    
                    array_push( 
                        $store_array,
                        $store_details
                    );
                   
                }
            }

            $object = [
                'id' => $data['id'],
                'username' => $data['username'],
                'name' => $data['name'],
                'email' => $data['email'],
                'storeId' => $data['storeId'],
                'created' => $data['created'],
                'bank_details' => $pay_array,
                'store_details' => $store_array
            ];

            array_push( 
                $newArray,
                $object
            );

        }
       

        $datas = $newArray;

        // return $datas;
        // die();
        
        $datechosen = $date->format('F d, Y')." - ".date('F d, Y');
        return view('components.merchants', compact('datas','datechosen'));
    }

    public function filter_merchant(Request $req){

        $data = $req->input();

        $dateRange = explode( '-', $req->date_chosen4 );
        $start_date = $dateRange[0];
        $end_date = $dateRange[1];

        $start_date = date("Y-m-d", strtotime($start_date));
        $end_date = date("Y-m-d", strtotime($end_date))." 23:59:59";

        // Reservation::whereBetween('reservation_from', [$from, $to])->get();
        $datas = Client::whereBetween('created', [$start_date, $end_date])
                        ->where('roleId', 'STORE_OWNER')
                        ->orderBy('created', 'DESC')
                        ->get();

        // return $datas;
        // die();

        $newArray = array();

        foreach ($datas as $data) {

            $payment_info = Payment::where('clientId', $data['id'])
                                    ->limit(1)
                                    ->get();

            $stores = Store::where('clientId', $data['id'])
                                    ->join('store_delivery_detail as delivery', 'store.id', '=', 'delivery.storeId')
                                    ->get();

            $pay_array = array();
            $store_array = array();

            if (count($payment_info) > 0) {
                foreach ($payment_info as $payment) {

                    $payment_data = [
                        'bankName' => $payment['bankName'],
                        'bankAccountNumber' => $payment['bankAccountNumber'],
                        'bankAccountTitle' => $payment['bankAccountTitle'],
                        'clientId' => $payment['clientId'],
                    ];
    
                    array_push( 
                        $pay_array,
                        $payment_data
                    );
    
                }
            }

            if (count($stores) > 0) {
                foreach ($stores as $store) {

                    $store_details = [
                        'storeId' => $store['id'],
                        'name' => $store['name'],
                        'storeDescription' => $store['storeDescription'],
                        'address' => $store['address'],
                        'city' => $store['city'],
                        'postcode' => $store['postcode'],
                        'state' => $store['state'],
                        'email' => $store['email'],
                        'phone' => $store['phone'],
                        'verticalCode' => $store['verticalCode'],
                        'type' => $store['type'],
                    ];
    
                    array_push( 
                        $store_array,
                        $store_details
                    );
                   
                }
            }

            $object = [
                'id' => $data['id'],
                'username' => $data['username'],
                'name' => $data['name'],
                'email' => $data['email'],
                'storeId' => $data['storeId'],
                'created' => $data['created'],
                'bank_details' => $pay_array,
                'store_details' => $store_array
            ];

            array_push( 
                $newArray,
                $object
            );

        }
       

        $datas = $newArray;

        // return $datas;
        // die();
        $datechosen = $req->date_chosen4;
        return view('components.merchants', compact('datas','datechosen'));
    }

    public function merchantappactivity(){

        // $datas = Client::limit(100)->get();
        $datas = Client::select('client.*')
                        ->where('roleId', 'STORE_OWNER')
                        ->whereNotNull('mobilePingLastResponse')
                        ->paginate(10);  
        //dd($datas);                 

        foreach ($datas as $data) {

            //Get merchant app's status
            $sql="SELECT id, mobilePingLastResponse, mobilePingTxnId FROM client WHERE id='".$data->id."'ORDER BY created DESC LIMIT 1";
            $appstatus = DB::connection('mysql2')->select($sql);
            $lastseen = $appstatus[0]->mobilePingLastResponse;
            $pingtxn = $appstatus[0]->mobilePingTxnId;
            // If mobile ping last is more than 60 mins
            $pingtime = strtotime($lastseen);
            if($pingtime<60){
                $merchantstatus="Online";
            }else {
                $merchantstatus="Offline";
            }
            $data->AppStatus = $merchantstatus;
            $data->LastSeen = $lastseen;


            //Get store closing time
            $sql="SELECT A.id, GROUP_CONCAT(day) AS day, clientId FROM store A INNER JOIN store_timing B ON A.id=B.storeId WHERE isOff='1' AND clientId = '".$data->id."' GROUP BY storeId";
            $closingtime = DB::connection('mysql2')->select($sql);
            //dd($sql);
            if (count($closingtime) > 0) {
                $closing=$closingtime[0]->day;
            } else{
                $closing= "";
            }
            $data->CloseTime = $closing;


            //Get store opening hours
            // $sql="SELECT A.clientId,B.storeId,B.day, B.openTime, B.breakStartTime, B.breakEndTime,
            //  B.closeTime,A.id FROM store A INNER JOIN store_timing B ON A.id=B.storeId WHERE clientId = '".$data->id."'";
            // $openinghours = DB::connection('mysql2')->select($sql);
            // //dd($sql);
            // if (count($openinghours) > 0) {
            //      $opentime=$openinghours[0]->openTime;
            //      $closetime=$openinghours[0]->closeTime;
            //      $breakstarttime=$openinghours[0]->breakStartTime;
            //      $breakendtime=$openinghours[0]->breakEndTime;
            // } else{
            //      $opentime= "";
            //      $closetime="";
            //      $breakstarttime="";
            //      $breakendtime="";
            // }
            // $data->OpenHour = $opentime;
            // $data->CloseHour = $closetime;

        }
        $namechosen='';
        return view('components.merchantappactivity', compact('datas','namechosen'));
    }

    public function filter_merchantappactivity(Request $req){

        $data = $req->input();

        $query = Client::select('client.*')
                        ->where('roleId', 'STORE_OWNER')
                        ->whereNotNull('mobilePingLastResponse'); 
        //dd($query);
          if($req->region == "MYS"){
                $query->where('countryId', '=', 'MYS');       
          }

          if($req->region == "PAK"){
                $query->where('countryId', '=', 'PAK');            
          }

          if ($req->name_chosen<>"") {
            $query->where('name', 'like', '%'.$req->name_chosen.'%');
        }

        $datas = $query->paginate(10);

        foreach ($datas as $data) {

            //Get merchant app's status
            $sql="SELECT id, mobilePingLastResponse, mobilePingTxnId FROM client WHERE id='".$data->id."'ORDER BY created DESC LIMIT 1";
            $appstatus = DB::connection('mysql2')->select($sql);
            $lastseen = $appstatus[0]->mobilePingLastResponse;
            $pingtxn = $appstatus[0]->mobilePingTxnId;
            // If mobile ping last is more than 60 mins
            $pingtime = strtotime($lastseen);
            if($pingtime<60){
                $merchantstatus="Online";
            }else {
                $merchantstatus="Offline";
            }
            $data->AppStatus = $merchantstatus;
            $data->LastSeen = $lastseen;


            //Get store closing time
            $sql="SELECT A.id, GROUP_CONCAT(day) AS day, clientId FROM store A INNER JOIN store_timing B ON A.id=B.storeId WHERE isOff='1' AND clientId = '".$data->id."' GROUP BY storeId";
            $closingtime = DB::connection('mysql2')->select($sql);
            //dd($sql);
            if (count($closingtime) > 0) {
                $closing=$closingtime[0]->day;
            } else{
                $closing= "";
            }
            $data->CloseTime = $closing;

        }
        $namechosen = $req->name_chosen;
        return view('components.merchantappactivity', compact('datas','namechosen'));
    }

    public function export_merchantappactivity(Request $req){

        $data = $req->input();
        return Excel::download(new MerchantAppActivityExport, 'MerchantAppActivity.xlsx');
    }


    public function convert_to_user_date($date, $format = 'Y-m-d H:i:s', $userTimeZone = 'Asia/Kuala_Lumpur', $serverTimeZone = 'UTC')
    {
        try {
            $dateTime = new DateTime ($date, new \DateTimeZone($serverTimeZone));
            $dateTime->setTimezone(new \DateTimeZone($userTimeZone));
            return $dateTime->format($format);
        } catch (Exception $e) {
            return '';
        }
    }

    
}
