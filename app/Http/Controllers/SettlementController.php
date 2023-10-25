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
use Session;
use Auth;

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
    protected $order_url;

    function __construct() {
            $this->url = config('services.report_svc.url');
            $this->token = config('services.report_svc.token');
            $this->order_url = config('services.report_svc.order_url');
    }

    public function settlement2(){

        $to = date("Y-m-d");
        $date = new DateTime('90 days ago');
        $from = $date->format("Y-m-d");
        $selectedService="DELIVERIN";
        $selectedCountry = Session::get('selectedCountry');

        if (Auth::user()->channel=="ALL" || Auth::user()->channel=="DELIVERIN" ) { 
            $selectedChannel="DELIVERIN";
        } else if (Auth::user()->channel=="ALL" || Auth::user()->channel=="PAYHUB2U" ) { 
            $selectedChannel="PAYHUB2U"; 
        } else if (Auth::user()->channel=="ALL" || Auth::user()->channel=="EKEDAI" ) { 
            $selectedChannel="EKEDAI"; 
        }

        $datas = Settlement::join('store as store', 'store_settlement2.storeId', '=', 'store.id')
                        ->whereBetween('settlementDate', [$from, $to." 23:59:59"])
                        ->where('serviceType',$selectedService)  
                        ->where('channel',$selectedChannel) 
                        ->where('store.regionCountryId',$selectedCountry) 
                        ->orderBy('settlementDate', 'DESC')
                        ->get();

        // return $datas;
        // die();        
        $datechosen = $date->format('F d, Y')." - ".date('F d, Y');
                
        return view('components.settlement2', compact('datas','datechosen','selectedService','selectedChannel'));
    }

    
    public function filter_settlement2(Request $req){

        $data = $req->input();

        $dateRange = explode( '-', $req->date_chosen4 );
        $start_date = $dateRange[0];
        $end_date = $dateRange[1];

        $start_date = date("Y-m-d", strtotime($start_date));
        $end_date = date("Y-m-d", strtotime($end_date));

        $selectedCountry = $req->region;
        Session::put('selectedCountry', $selectedCountry);

        $datas = Settlement::join('store as store', 'store_settlement2.storeId', '=', 'store.id')
                        ->whereBetween('settlementDate', [$start_date, $end_date." 23:59:59"])  
                        ->where('serviceType',$req->selectService)  
                        ->where('store.regionCountryId',$selectedCountry) 
                        ->orderBy('settlementDate', 'DESC')
                        ->get();

        $datechosen = $req->date_chosen4; 
        $region = $req->region;
        $selectedService=$req->selectService;
        $selectedChannel=$req->selectChannel;
                       
        return view('components.settlement2', compact('datas', 'datechosen','selectedService','selectedChannel'));

    }

    public function update_settlement2(Request $request){

        if (Auth::user()->channel=="ALL" || Auth::user()->channel=="DELIVERIN" ) { 
            $selectedChannel="DELIVERIN";
        } else if (Auth::user()->channel=="ALL" || Auth::user()->channel=="PAYHUB2U" ) { 
            $selectedChannel="PAYHUB2U"; 
        } else if (Auth::user()->channel=="ALL" || Auth::user()->channel=="EKEDAI" ) { 
            $selectedChannel="EKEDAI"; 
        }

        //update refund record
        try{    
            //save file to public folder
            //dd($request);
            $settlement = Settlement::find($request->sid);            
            if ($settlement) {
                $settlement->remarks = $request->sremarks;
                $res = $settlement->save();
            } 
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
        $selectedService="DELIVERIN";      

        return view('components.settlement2', compact('datas', 'datechosen','selectedService','selectedChannel'));
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
        $service=$req->service_copy;
        $channel=$req->channel_copy;
        $country = $req->country_copy;

        return Excel::download(new Settlement2Export($start_date, $end_date." 23:59:59", $service, $channel, $country), 'settlement.xlsx');
    }


     

}