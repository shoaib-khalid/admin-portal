<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use App\Models\User;
use DateTime;

use App\Exports\UsersExport;
use App\Exports\DetailsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class UserController extends Controller
{

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

        $dateRange = explode( '-', $req->date_chosen );
        $start_date = $dateRange[0];
        $end_date = $dateRange[1];

        $start_date = date("Y-m-d", strtotime($start_date));
        $end_date = date("Y-m-d", strtotime($end_date));

        // $from = "2021-08-01";
        // $to = "2021-08-30";

        return Excel::download(new UsersExport($start_date, $end_date), 'dailySalesSummary.xlsx');
    }

    public function export_detail(Request $req) 
    {
        $data = $req->input();

        $dateRange = explode( '-', $req->date_chosen2 );
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

        $request = Http::withToken('accessToken')->get('https://api.symplified.biz/report-service/v1/store/null/daily_sales', [
            'from' => $from,
            'to' => $to,
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
        }

        // return $days;

        // die();

        return view('dashboard', compact('days'));
    }

    public function daily_sales_filter(Request $req){

        $data = $req->input();

        $dateRange = explode( '-', $req->date_chosen );
        $start_date = $dateRange[0];
        $end_date = $dateRange[1];

        $start_date = date("Y-m-d", strtotime($start_date));
        $end_date = date("Y-m-d", strtotime($end_date));

        $request = Http::withToken('accessToken')->get('https://api.symplified.biz/report-service/v1/store/null/daily_sales', [
            'from' => $start_date,
            'to' => $end_date,
        ]);

        if($request->successful()){

            $days = $request['data']['content'];

        }

        // return $days;
        // die();
        return view('dashboard', compact('days'));

    }

    public function daily_details(){

        $to = date("Y-m-d");
        $date = new DateTime('7 days ago');
        $from = $date->format("Y-m-d");
        
        $request = Http::withToken('accessToken')->get('https://api.symplified.biz/report-service/v1/store/null/report/detailedDailySales', [
            'startDate' => $from,
            'endDate' => $to,
        ]); 
        
        // $posts = Http::get('https://api.symplified.biz/report-service/v1/store/null/report/detailedDailySales?startDate=2021-07-1&endDate=2021-08-16')->json();
        if($request->successful()){

            $datas = $request['data'];

        }


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
        return view('components.daily-details', compact('datas'));
    }

    public function daily_details_filter(Request $req){

        $data = $req->input();

        $dateRange = explode( '-', $req->date_chosen2 );
        $start_date = $dateRange[0];
        $end_date = $dateRange[1];

        $start_date = date("Y-m-d", strtotime($start_date));
        $end_date = date("Y-m-d", strtotime($end_date));

        $request = Http::withToken('accessToken')->get('https://api.symplified.biz/report-service/v1/store/null/report/detailedDailySales', [
            'startDate' => $start_date,
            'endDate' => $end_date,
        ]); 
        
        // $posts = Http::get('https://api.symplified.biz/report-service/v1/store/null/report/detailedDailySales?startDate=2021-07-1&endDate=2021-08-16')->json();
        if($request->successful()){

            $datas = $request['data'];

        }

        // return $datas;
        return view('components.daily-details', compact('datas'));
    }
}
