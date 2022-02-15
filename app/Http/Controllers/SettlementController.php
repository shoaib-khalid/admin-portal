<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use App\Models\User;
use App\Models\Client;
use App\Models\PaymentDetail as Payment;
use App\Models\Store;
use App\Models\Settlement;
use App\Models\Refund;
use App\Models\StoreDeliveryDetail as StoreDelivery;
use Carbon\Carbon;
use DateTime;

use App\Exports\UsersExport;
use App\Exports\DetailsExport;
use App\Exports\SettlementsExport;
use App\Exports\MerchantExport;
use App\Exports\Settlement2Export;
use App\Exports\RefundHistoryExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;
 
use App\Mail\NotifyMail;
use App\Mail\EmailContent;

class SettlementController extends Controller
{

    protected $url;
    protected $token;

    function __construct() {
            $this->url = config('services.report_svc.url');
            $this->token = config('services.report_svc.token');
    }

    public function settlement2(){

        $to = date("Y-m-d");
        $date = new DateTime('90 days ago');
        $from = $date->format("Y-m-d");

        $datas = Settlement::whereBetween('settlementDate', [$from, $to." 23:59:59"])  
                        ->orderBy('settlementDate', 'DESC')
                        ->get();
        //print_r($datas);                    

        // return $datas;
        // die();        
        $datechosen = $date->format('F d, Y')." - ".date('F d, Y');                
        return view('components.settlement2', compact('datas','datechosen'));
    }

    
    public function filter_settlement2(Request $req){

        $data = $req->input();

        $dateRange = explode( '-', $req->date_chosen4 );
        $start_date = $dateRange[0];
        $end_date = $dateRange[1];

        $start_date = date("Y-m-d", strtotime($start_date));
        $end_date = date("Y-m-d", strtotime($end_date));

         $datas = Refund::select('order_refund.id','order_refund.created','orderId','invoiceId', 'store.name AS storeName', 'customer.name AS customerName', 'refundType','refundAmount','paymentChannel','refundStatus','remarks')
                        ->join('order as order', 'order_refund.orderId', '=', 'order.id')
                        ->join('customer as customer', 'order.customerId', '=', 'customer.id')
                        ->join('store as store', 'order.storeId', '=', 'store.id')
                        ->where('refundStatus', 'PENDING')
                        ->whereBetween('order_refund.created', [$start_date, $end_date." 23:59:59"])                        
                        ->orderBy('order_refund.created', 'ASC')
                        ->get();
        
        //print_r($datas);                    

        // return $datas;
        // die();
        $datechosen = $req->date_chosen4;                
        return view('components.pendingrefund', compact('datas', 'datechosen'));

    }

    public function update_settlement2(Request $request){

        //update refund record
        try{    
            //save file to public folder
            //dd($request);
            $settlement = Settlement::find($request->sid);            
            $settlement->remarks = $request->sremarks;
            $res = $settlement->save();
            //dd($res); 

        }catch(QueryException $ex){ 
            return $ex->getMessage(); 
        }

        $to = date("Y-m-d");
        $date = new DateTime('90 days ago');
        $from = $date->format("Y-m-d");

        $datas = Settlement::whereBetween('settlementDate', [$from, $to." 23:59:59"])  
                        ->orderBy('settlementDate', 'DESC')
                        ->get(); 
        $datechosen = $date->format('F d, Y')." - ".date('F d, Y');         
        return view('components.settlement2', compact('datas', 'datechosen'));
    }

    public function export_settlement2(Request $req) 
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

        return Excel::download(new Settlement2Export($start_date, $end_date." 23:59:59"), 'settlement.xlsx');
    }


     

}