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

use App\Exports\UsersExport;
use App\Exports\DetailsExport;
use App\Exports\SettlementsExport;
use App\Exports\MerchantExport;
use Maatwebsite\Excel\Facades\Excel;
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
}
