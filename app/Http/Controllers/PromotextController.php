<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use App\Models\Promotext;
use Carbon\Carbon;
use DateTime;

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
        
        $datas = Promotext::get();
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
        $promo->save();

        $datas = Promotext::get();
        $eventlist=array('guest-checkout','customer-checkout');
        $promodata=null;
        return view('components.promotext', compact('datas','eventlist','promodata'));
    }

    public function edit_promotext(Request $request){
        $promolist = Promotext::where('eventId',$request->eventId)->get();
        $promodata = $promolist[0];
        $datas = Promotext::get();
        $eventlist=array('guest-checkout','customer-checkout');

         $sql="SELECT code FROM region_vertical";
        $verticallist = DB::connection('mysql2')->select($sql);

        return view('components.promotext', compact('datas','eventlist','promodata','verticallist'));
    }

     public function delete_promotext(Request $request){
        DB::connection('mysql2')->delete("DELETE FROM promo_text WHERE eventId='".$request->eventId."'");
        $datas = Promotext::get();
        $eventlist=array('guest-checkout','customer-checkout');
        $promodata=null;
        return view('components.promotext', compact('datas','eventlist','promodata'));
    }

    public function post_editpromotext(Request $request){
        $promolist = Promotext::where('eventId',$request->selectEvent)->get();
        $promo = $promolist[0];
        $promo->eventId = $request->selectEvent;
        $promo->displayText = $request->displayText;
        $promo->save();
        
        $datas = Promotext::get();
        $eventlist=array('guest-checkout','customer-checkout');
        $promodata=null;
        return view('components.promotext', compact('datas','eventlist','promodata'));
    }



}