<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use App\Models\MobileLog;
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

class MobileLogController extends Controller
{

    protected $url;
    protected $token;

    function __construct() {
            $this->url = config('services.report_svc.url');
            $this->token = config('services.report_svc.token');
    }


    public function index(){
        $date = new DateTime('7 days ago');
        $from = $date->format("Y-m-d");
        $to = date("Y-m-d");
        $selectedCountry = Session::get('selectedCountry');

        $query = MobileLog::select('application_error.*', 'client.name')
                                ->join('client', 'application_error.clientId' ,'=', 'client.id')
                                ->whereBetween('application_error.created', [$from, $to." 23:59:59"]);                                
        if($selectedCountry == 'MYS') {
            $query->where('countryId','MYS');
        } else {
            $query->where('countryId','PAK');
        }
        $datas = $query->paginate(20);

        $datechosen = $date->format('F d, Y')." - ".date('F d, Y');  
        $customername = '';        
        return view('components.mobilelog',compact('datas','datechosen','customername'));
    }

    public function mobilelog_filter(Request $request){

        $dateRange = explode( '-', $request->date_chosen4 );
        $start_date = $dateRange[0];
        $end_date = $dateRange[1];

        $from = date("Y-m-d", strtotime($start_date));
        $to = date("Y-m-d", strtotime($end_date));
        echo "from :".$from;
        echo " to :".$to;
        Session::put('selectedCountry', $request->region);

        $query = MobileLog::select('application_error.*', 'client.name')
                                ->join('client', 'application_error.clientId' ,'=', 'client.id')
                                ->whereBetween('application_error.created', [$from, $to." 23:59:59"]);                                
        if($request->region == 'MYS') {
            $query->where('countryId','MYS');
        } else {
            $query->where('countryId','PAK');
        }
        if ($request->customer_chosen <> "") {
            $query->where('name', 'LIKE', '%'.$request->customer_chosen.'%');    
        }
        $datas = $query->paginate(20);

        $datechosen = $request->date_chosen4;
        $customername = $request->customer_chosen;        
        return view('components.mobilelog',compact('datas','datechosen','customername'));
    }

    public function add_ogtag(Request $request){
        $platform = new PlatformOgTag();
        $platform->content = $request->content;
        $platform->name = $request->name;
        $platform->platformId = $request->selectPlatform;
        $platform->property = $request->property;
        $platform->save();

        
        $datas = PlatformOgTag::select('platform_config.*', 'platform_og_tag.*')
                                ->join('platform_config', 'platform_og_tag.platformId' ,'=', 'platform_config.platformId')
                                ->get();
        $platformdata=null;

        $sql="SELECT platformType, platformId FROM platform_config";
        $propertylist = DB::connection('mysql2')->select($sql);
        $selectedplatform = '';

        return view('components.ogtag', compact('datas','platformdata','propertylist','selectedplatform'));
    }

    public function edit_ogtag(Request $request){
        $platformlist = PlatformOgTag::where('id',$request->id)->get();
        $platformdata = $platformlist[0];
        //dd($platformlist[0]);
        
        $datas = PlatformOgTag::select('platform_config.*', 'platform_og_tag.*')
                                ->join('platform_config', 'platform_og_tag.platformId' ,'=', 'platform_config.platformId')
                                ->get();
        //dd($datas);
        $sql="SELECT platformType, platformId FROM platform_config";
        $propertylist = DB::connection('mysql2')->select($sql);
        $selectedplatform = '';

        return view('components.ogtag', compact('datas','platformdata','propertylist', 'selectedplatform'));
    }

    public function delete_ogtag(Request $request){
        DB::connection('mysql2')->delete("DELETE FROM platform_og_tag WHERE id='".$request->id."'");       
        $datas = PlatformOgTag::select('platform_config.*', 'platform_og_tag.*')
                                ->join('platform_config', 'platform_og_tag.platformId' ,'=', 'platform_config.platformId')
                                ->get();
        $platformdata=null;
        $sql="SELECT platformType, platformId FROM platform_config";
        $propertylist = DB::connection('mysql2')->select($sql);
        $selectedplatform = '';

        return view('components.ogtag', compact('datas','platformdata','propertylist','selectedplatform'));
    }

    public function post_edit_ogtag(Request $request){
        $platformlist = PlatformOgTag::where('id',$request->id)->get();
        $platform = $platformlist[0];
        $platform->content = $request->content;
        $platform->name = $request->name;
        $platform->platformId = $request->selectPlatform;
        $platform->property = $request->property;        
        $platform->save();

        
        $datas = PlatformOgTag::select('platform_config.*', 'platform_og_tag.*')
                                ->join('platform_config', 'platform_og_tag.platformId' ,'=', 'platform_config.platformId')
                                ->get();
        $platformdata=null;

        $sql="SELECT platformType, platformId FROM platform_config";
        $propertylist = DB::connection('mysql2')->select($sql);
        $selectedplatform = '';

        return view('components.ogtag', compact('datas','platformdata','propertylist','selectedplatform'));
    }



}