<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use App\Models\PlatformConfig;
use App\Models\PlatformOgTag;
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

class OgTagController extends Controller
{

    protected $url;
    protected $token;

    function __construct() {
            $this->url = config('services.report_svc.url');
            $this->token = config('services.report_svc.token');
    }


    public function index(){

        $datas = PlatformOgTag::select('platform_config.*', 'platform_og_tag.*')
                                ->join('platform_config', 'platform_og_tag.platformId' ,'=', 'platform_config.platformId')
                                ->get();
        $platformdata=null;
        $sql="SELECT platformType, platformId FROM platform_config";
        $propertylist = DB::connection('mysql2')->select($sql);
        $Marketplace = '';
        $Store_Front= '';
        $DineIn = '';
        $Merchant_Portal = '';
        $selectedplatform = '';
        return view('components.ogtag', compact('datas','platformdata','propertylist','selectedplatform'));
    }

    public function index_filter(Request $request){

        $data = $request->input();

        $query = PlatformOgTag::select('platform_config.*', 'platform_og_tag.*')
                              ->join('platform_config', 'platform_og_tag.platformId' ,'=', 'platform_config.platformId');

        $selectedplatform = $request->id_platform ;
        if($request->id_platform <> "" ){
               $query->where('platform_config.platformId', '=', $request->id_platform);           
         }


        $datas = $query->get();

        $platformdata=null;
        $sql="SELECT platformType, platformId FROM platform_config";
        $propertylist = DB::connection('mysql2')->select($sql);

        $Marketplace= $request->Marketplace;
        $Store_Front= $request->Store_Front;
        $DineIn= $request->DineIn;
        $Merchant_Portal= $request->Merchant_Portal;

        return view('components.ogtag', compact('datas','platformdata','propertylist','selectedplatform'));
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