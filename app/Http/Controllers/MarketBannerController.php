<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use App\Models\MarketBanner;
use Carbon\Carbon;
use DateTime;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Mail;
 
use App\Mail\NotifyMail;
use App\Mail\EmailContent;

class MarketBannerController extends Controller
{

    protected $baseurl;
    protected $basepreviewurl;
    protected $basepath;

    function __construct() {
            $this->baseurl = config('services.banner_svc.url');
            $this->basepreviewurl = config('services.banner_svc.previewurl');
            $this->basepath = config('services.banner_svc.path');
    }


    public function index(){        
        $datas = MarketBanner::get();
        $sql="SELECT id, name FROM region_country";
        $countryList = DB::connection('mysql2')->select($sql);
        $basepreviewurl = $this->basepreviewurl;
        return view('components.marketbanner', compact('datas','countryList', 'basepreviewurl'));
    }


    public function add_marketbanner(Request $request){
        //copy file to folder
        $file = $request->file('selectFile');
        //Move Uploaded File
        $newfilename = date("YmdHis");
        $destinationPath = $this->basepath;
        echo " path:".$destinationPath;
        $file->move($destinationPath,$newfilename);
        $url = $this->baseurl."/".$newfilename;
        echo " url:".$url;
        $banner = new MarketBanner();
        $banner->regionCountryId = $request->selectCountry;
        $banner->bannerUrl = $url;
        $banner->type = $request->selectType;
        $banner->save();

        $datas = MarketBanner::get();       
        $sql="SELECT id, name FROM region_country";
        $countryList = DB::connection('mysql2')->select($sql);
        return view('components.marketbanner', compact('datas','countryList'));
    }


    public function delete_marketbanner(Request $request){
        DB::connection('mysql2')->delete("DELETE FROM marketplace_banner_config WHERE id='".$request->id."'");
        $datas = MarketBanner::get();       
        $sql="SELECT id, name FROM region_country";
        $countryList = DB::connection('mysql2')->select($sql);
        $basepreviewurl = $this->basepreviewurl;
        return view('components.marketbanner', compact('datas','countryList', 'basepreviewurl'));
    }
  


}