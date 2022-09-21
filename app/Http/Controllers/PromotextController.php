<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use App\Models\Promotext;
use Carbon\Carbon;
use DateTime;
use Session;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Mail;
 
use App\Mail\NotifyMail;
use App\Mail\EmailContent;

class PromotextController extends Controller
{

    protected $url;
    protected $token;

    function __construct() {
            $this->url = config('services.report_svc.url');
            $this->token = config('services.report_svc.token');
    }


    public function index(){
        $selectedCountry = Session::get('selectedCountry');
        if($selectedCountry == 'MYS') {
           $datas = Promotext::where('verticalCode', '=', 'FnB')
                               ->orWhere('verticalCode', '=', 'E-Commerce')
                               ->get();
        }
        if($selectedCountry == 'PAK') {
            $datas = Promotext::where('verticalCode', '=', 'FnB_PK')
                                ->orWhere('verticalCode', '=', 'ECommerce_PK')
                                ->get();
        }
        $eventlist=array('guest-checkout','customer-checkout');
        $promodata=null;

        $sql="SELECT code FROM region_vertical";
        $verticallist = DB::connection('mysql2')->select($sql);

        return view('components.promotext', compact('datas','eventlist','promodata','verticallist'));
    }

    public function filter_promotext(Request $request){
        
        $data = $request->input();

        $selectedCountry = $request->region;
        Session::put('selectedCountry', $selectedCountry);

        $query = Promotext::select('promo_text.*');
        //dd($query);

        if($request->region == "MYS" ){
            $query->where(function ($query) {
               $query->where('verticalCode', '=', 'FnB')
               ->orWhere('verticalCode', '=', 'E-Commerce');

           });              
         }

         if($request->region == "PAK" ){
            $query->where(function ($query) {
               $query->where('verticalCode', '=', 'FnB_PK')
               ->orWhere('verticalCode', '=', 'ECommerce_PK');

           });              
         }

        $datas = $query->get();
        $eventlist=array('guest-checkout','customer-checkout');
        $promodata=null;

        $sql="SELECT code FROM region_vertical";
        $verticallist = DB::connection('mysql2')->select($sql);

        return view('components.promotext', compact('datas','eventlist','promodata','verticallist'));
    }



    public function add_promotext(Request $request){
        $promo = new Promotext();
        $promo->eventId = $request->selectEvent;
        $promo->displayText = $request->displayText;
        $promo->verticalCode = $request->selectVertical;
        $promo->save();

        $datas = Promotext::get();
        $eventlist=array('guest-checkout','customer-checkout');
        $promodata=null;

        $sql="SELECT code FROM region_vertical";
        $verticallist = DB::connection('mysql2')->select($sql);

        return view('components.promotext', compact('datas','eventlist','promodata','verticallist'));
    }

    public function edit_promotext(Request $request){
        $promolist = Promotext::where('id',$request->id)->get();
        $promodata = $promolist[0];
        $datas = Promotext::get();
        $eventlist=array('guest-checkout','customer-checkout');

        $sql="SELECT code FROM region_vertical";
        $verticallist = DB::connection('mysql2')->select($sql);

        return view('components.promotext', compact('datas','eventlist','promodata','verticallist'));
    }

     public function delete_promotext(Request $request){
        DB::connection('mysql2')->delete("DELETE FROM promo_text WHERE id='".$request->id."'");
        $datas = Promotext::get();
        $eventlist=array('guest-checkout','customer-checkout');
        $promodata=null;

        $sql="SELECT code FROM region_vertical";
        $verticallist = DB::connection('mysql2')->select($sql);

        return view('components.promotext', compact('datas','eventlist','promodata','verticallist'));
    }

    public function post_editpromotext(Request $request){
        $promolist = Promotext::where('id',$request->id)->get();
        $promo = $promolist[0];
        $promo->eventId = $request->selectEvent;
        $promo->displayText = $request->displayText;
        $promo->verticalCode = $request->selectVertical;
        $promo->save();
        
        $datas = Promotext::get();
        $eventlist=array('guest-checkout','customer-checkout');
        $promodata=null;

        $sql="SELECT code FROM region_vertical";
        $verticallist = DB::connection('mysql2')->select($sql);

        return view('components.promotext', compact('datas','eventlist','promodata','verticallist'));
    }



}