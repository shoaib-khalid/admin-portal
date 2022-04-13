<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use App\Models\Voucher;
use App\Models\VoucherTerms;
use App\Models\Store;
use Carbon\Carbon;
use DateTime;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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
        $sql="SELECT code FROM region_vertical";
        $verticalList = DB::connection('mysql2')->select($sql);

        $storelist = Store::orderBy('name', 'ASC')
                        ->get();

        //dd($storelist);
        return view('components.voucheradd',compact('storelist','verticalList'));
    }

    public function post_voucheradd(Request $request){
        $dt = $request->date_range;
        $temp = explode(" - ", $dt);
        $start_date = $temp[0];
        $end_date = $temp[1];

        $voucher = new Voucher();
        $voucherId = Str::uuid();
        $voucher->id = $voucherId;
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
        $voucher->verticalCode = $request->selectVertical;
        $voucher->currencyLabel = $request->currencyLabel;

        if ($voucher->voucherType=="STORE") {
            $voucher->storeId = $request->selectStore;
        }
        $voucher->save();

        $termList = explode(PHP_EOL, $request->terms);
        foreach ($termList as $term) {
            $vterms = new VoucherTerms();
            $vterms->id = Str::uuid();
            $vterms->voucherId = $voucherId;
            $vterms->terms = $term;
            $vterms->save();
        }

        $storelist = Store::orderBy('name', 'ASC')
                        ->get();
        $sql="SELECT code FROM region_vertical";
        $verticalList = DB::connection('mysql2')->select($sql);

        return view('components.voucheradd',compact('storelist','verticalList'));
    }


     public function voucherlist(){
        $to = date("Y-m-d");
        $date = new DateTime('1 months ago');
        $from = $date->format("Y-m-d");
        $datechosen = $date->format('F d, Y')." - ".date('F d, Y');                

        $datas = Voucher::select('voucher.*','store.name AS storeName')
                        ->leftJoin('store as store', 'storeId', '=', 'store.id')
                        ->orderBy('created_at', 'DESC')
                        ->where('status','ACTIVE')
                        ->whereRaw("endDate > '".date("Y-m-d H:i:s")."'")
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

        $query = Voucher::select('voucher.*','store.name AS storeName')
                        ->leftJoin('store as store', 'storeId', '=', 'store.id')
                        ->whereBetween('created_at', [$start_date, $end_date." 23:59:59"]);

        if ($req->code_chosen<>"") {
            $query->where('voucherCode', 'like', '%'.$req->code_chosen.'%');
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

        $storelist = Store::orderBy('name', 'ASC')
                        ->get();

        $sql="SELECT code FROM region_vertical";
        $verticalList = DB::connection('mysql2')->select($sql);

        $tList = VoucherTerms::where('voucherId', $req->voucherId)                        
                        ->get();
        $i=0;
        foreach ($tList as $term) {
            $termsList[$i] = $term->terms;
            $i++;
        }

        return view('components.voucheredit', compact('voucher', 'storelist', 'verticalList','termsList'));
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
        $voucher->verticalCode = $request->selectVertical;
        $voucher->currencyLabel = $request->currencyLabel;

        if ($voucher->voucherType=="STORE") {
            $voucher->storeId = $request->selectStore;
        } else {
            $voucher->storeId = null;
        }

        $voucher->updated_at = date("Y-m-d H:i:s");
        $voucher->updated_by = "DELETED";
        $voucher->save();
        //dd($voucher)

        DB::connection('mysql2')->delete("DELETE FROM voucher_terms WHERE voucherId='".$voucher->id."'");

        $termList = explode(PHP_EOL, $request->terms);
        foreach ($termList as $term) {
            $vterms = new VoucherTerms();
            $vterms->id = Str::uuid();
            $vterms->voucherId = $voucher->id;
            $vterms->terms = $term;
            $vterms->save();
        }

        $storelist = Store::orderBy('name', 'ASC')
                        ->get();
        
        $sql="SELECT code FROM region_vertical";
        $verticalList = DB::connection('mysql2')->select($sql);

        $tList = VoucherTerms::where('voucherId', $request->voucherId)                        
                        ->get();
        $i=0;
        foreach ($tList as $term) {
            $termsList[$i] = $term->terms;
            $i++;
        }

        return view('components.voucheredit', compact('voucher','storelist','verticalList','termsList'));
    }

      public function voucherdelete(Request $req){        
        $datas = Voucher::where('id', $req->voucherId)                        
                        ->orderBy('created_at', 'DESC')
                        ->get();
        //dd($datas);
        $voucher = $datas[0];

         $storelist = Store::orderBy('name', 'ASC')
                        ->get();

        return view('components.voucherdelete', compact('voucher', 'storelist'));
    }

    public function post_voucherdelete(Request $request){   
        $user = auth()->user();
        $voucher = Voucher::find($request->voucherId);
        $voucher->status = "DELETED";
        $voucher->updated_at = date("Y-m-d H:i:s");
        $voucher->updated_by = $user->email;
        $voucher->deleteReason = $request->reason;
        $voucher->save();
        //dd($voucher)

        $to = date("Y-m-d");
        $date = new DateTime('1 months ago');
        $from = $date->format("Y-m-d");
        $datechosen = $date->format('F d, Y')." - ".date('F d, Y');                

        $datas = Voucher::select('voucher.*','store.name AS storeName')
                        ->leftJoin('store as store', 'storeId', '=', 'store.id')
                        ->where('status','ACTIVE')
                        ->orderBy('created_at', 'DESC')
                        ->get();
        
        $codechosen='';
        return view('components.voucherlist', compact('datas','datechosen','codechosen'));        
    }


}