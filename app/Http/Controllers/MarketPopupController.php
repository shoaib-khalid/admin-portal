<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use App\Models\MarketPopup;
use Carbon\Carbon;
use DateTime;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Mail;
 
use App\Mail\NotifyMail;
use App\Mail\EmailContent;

class MarketPopupController extends Controller
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
        $datas = MarketPopup::orderBy('sequence', 'ASC')->get(); 
        $sql="SELECT id, name FROM region_country";
        $countryList = DB::connection('mysql2')->select($sql);
        $basepreviewurl = $this->basepreviewurl;
        return view('components.marketpopup', compact('datas','countryList', 'basepreviewurl'));
    }


    public function add_marketpopup(Request $request){
        //copy file to folder
        $file = $request->file('selectFile');
        $extension = $file->getClientOriginalExtension();
        //Move Uploaded File
        $newfilename = date("YmdHis").".".$extension;
        $destinationPath = $this->basepath;
        //echo " path:".$destinationPath;
        $file->move($destinationPath,$newfilename);
        $url = $this->baseurl."/".$newfilename;
        //echo " url:".$url;
        $banner = new MarketPopup();
        $banner->regionCountryId = $request->selectCountry;
        $banner->popupUrl = $url;
        $banner->type = $request->selectType;
        $banner->sequence = $request->sequence;
        $banner->actionUrl = $request->actionUrl;
        $banner->save();

        $datas = MarketPopup::orderBy('sequence', 'ASC')->get(); 
        $sql="SELECT id, name FROM region_country";
        $countryList = DB::connection('mysql2')->select($sql);
        $basepreviewurl = $this->basepreviewurl;
        return view('components.marketpopup', compact('datas','countryList', 'basepreviewurl'));
    }


    public function delete_marketpopup(Request $request){
        DB::connection('mysql2')->delete("DELETE FROM marketplace_popup_config WHERE id='".$request->id."'");
        $datas = MarketPopup::orderBy('sequence', 'ASC')->get(); 
        $sql="SELECT id, name FROM region_country";
        $countryList = DB::connection('mysql2')->select($sql);
        $basepreviewurl = $this->basepreviewurl;
        return view('components.marketpopup', compact('datas','countryList', 'basepreviewurl'));
    }

    public function edit_marketpopup(Request $request){
        $datalist = MarketPopup::where('id',$request->id)->get();
        $data = $datalist[0];
        $data->sequence = $request->sequence;
        $data->actionUrl = $request->actionUrl;
        $data->save();

        $datas = MarketPopup::orderBy('sequence', 'ASC')->get(); 
        $sql="SELECT id, name FROM region_country";
        $countryList = DB::connection('mysql2')->select($sql);
        $basepreviewurl = $this->basepreviewurl;
        return view('components.marketpopup', compact('datas','countryList', 'basepreviewurl'));
    }
  


}