<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use App\Models\Voucher;
use Carbon\Carbon;
use DateTime;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;
 
use App\Mail\NotifyMail;
use App\Mail\EmailContent;

class VoucherController extends Controller
{

    protected $url;
    protected $token;

    function __construct() {
            $this->url = config('services.report_svc.url');
            $this->token = config('services.report_svc.token');
    }


    public function voucheradd(){
         return view('components.voucheradd');
    }

    public function post_voucheradd(Request $request){
        $dt = $request->date_range;
        $temp = explode(" - ", $dt);
        $start_date = $temp[0];
        $end_date = $temp[1];

        $voucher = new Voucher();
        $voucher->id = DB::raw('uuid()');
        $voucher->voucherType = $request->voucherType;
        $voucher->name = $request->name;
        $voucher->status = "ACTIVE"; 
        $voucher->startDate = $start_date;
        $voucher->endDate = $end_date;
        $voucher->discountType = $request->discountType;
        $voucher->calculationType = $request->calculationType;
        $voucher->discountValue = $request->discountValue;
        $voucher->voucherCode = $request->voucherCode;
        $voucher->totalQuantity = $request->totalQuantity;
        $voucher->maxDiscountAmount = $request->maxDiscountAmount;
        $voucher->totalRedeem=0;
        $voucher->save();
        return view('components.voucheradd');
    }


     public function voucherlist(){
        $to = date("Y-m-d");
        $date = new DateTime('1 days ago');
        $from = $date->format("Y-m-d");
        $datechosen = $date->format('F d, Y')." - ".date('F d, Y');                

        $datas = Voucher::orderBy('created_at', 'DESC')
                        ->get();
        
        $codechosen='';
        return view('components.voucherlist', compact('datas','datechosen','codechosen'));
    }

    
    public function filter_voucherlist(Request $req){

        $data = $req->input();

        $dateRange = explode( '-', $req->date_chosen4 );
        $start_date = $dateRange[0];
        $end_date = $dateRange[1];

        $start_date = date("Y-m-d", strtotime($start_date));
        $end_date = date("Y-m-d", strtotime($end_date));

        $query = Voucher::whereBetween('created_at', [$start_date, $end_date." 23:59:59"])  ;

        if ($req->code_chosen<>"") {
            $query->where('voucherCode', $req->code_chosen);
        }

        $query->orderBy('created_at', 'DESC');
       // dd($query);
        $datas = $query->get();

        //print_r($datas);                    

        // return $datas;
        // die();
        $datechosen = $req->date_chosen4;    
        $codechosen = $req->code_chosen;            
        return view('components.voucherlist', compact('datas', 'datechosen', 'codechosen'));

    }

     public function voucheredit(Request $req){        
        $datas = Voucher::where('id', $req->voucherId)                        
                        ->orderBy('created_at', 'DESC')
                        ->get();
        //dd($datas);
        $voucher = $datas[0];
        return view('components.voucheredit', compact('voucher'));
    }

    public function post_voucheredit(Request $request){        
        $voucher = Voucher::find($request->voucherId);
        $dt = $request->date_range;
        $temp = explode(" - ", $dt);
        $start_date = $temp[0];
        $end_date = $temp[1];

        $voucher->voucherType = $request->voucherType;
        $voucher->name = $request->name;
        $voucher->status = $request->status; 
        $voucher->startDate = $start_date;
        $voucher->endDate = $end_date;
        $voucher->discountType = $request->discountType;
        $voucher->calculationType = $request->calculationType;
        $voucher->discountValue = $request->discountValue;
        $voucher->voucherCode = $request->voucherCode;
        $voucher->totalQuantity = $request->totalQuantity;
        $voucher->maxDiscountAmount = $request->maxDiscountAmount;
        $voucher->save();
        //dd($voucher)
        return view('components.voucheredit', compact('voucher'));
    }


}