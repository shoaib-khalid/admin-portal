<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use App\Models\CityRegion;
use App\Models\Locations;
use Carbon\Carbon;
use DateTime;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Mail;
 
use App\Mail\NotifyMail;
use App\Mail\EmailContent;

class CityRegionController extends Controller
{

    protected $url;
    protected $token;

    protected $baseurl;
    protected $basepreviewurl;
    protected $basepath;

    function __construct() {
            $this->baseurl = config('services.banner_svc.url');
            $this->basepreviewurl = config('services.banner_svc.previewurl');
            $this->basepath = config('services.banner_svc.path');
            $this->url = config('services.report_svc.url');
            $this->token = config('services.report_svc.token');
    }


    public function citylocation(){        
        $datas = Locations::select('location_config.*', 'city.regionStateId')
                    ->join('region_city as city', 'cityId', '=', 'city.id')
                    ->orderBy('sequence', 'ASC')
                    ->get();        
        $citySelected = "";
        $stateSelected = "";
        
        $sql="SELECT id, name, regionStateId FROM region_city ORDER BY regionStateId, name";
        $cityList = DB::connection('mysql2')->select($sql);

        $sql="SELECT id, name, regionCountryId FROM region_country_state ORDER BY regionCountryId, name";
        $stateList = DB::connection('mysql2')->select($sql);

        $regionCityList=array();
        $regionList = CityRegion::select('location_area.*','usercity.name AS userCityName', 
                    'storecity.name AS storeCityName','usercity.regionStateId AS stateId')
                    ->join('region_city as usercity', 'userLocationCityId', '=', 'usercity.id')
                    ->join('region_city as storecity', 'storeCityId', '=', 'storecity.id')
                    ->orderBy('usercity.regionStateId', 'ASC')
                    ->orderBy('usercity.name', 'ASC')->get();  
        foreach ($regionList as $region) {
            if (array_key_exists($region['userLocationCityId'],  $regionCityList))
                $regionCityList[$region['userLocationCityId']]=$regionCityList[$region['userLocationCityId']].", ".$region['storeCityId'];
            else
                $regionCityList[$region['userLocationCityId']]=$region['storeCityId'];
        }
        $basepreviewurl = $this->basepreviewurl;

        return view('components.locations', compact('datas','cityList','citySelected', 'stateList', 'stateSelected', 'regionCityList', 'basepreviewurl'));
    }

    public function filter_citylocation(Request $request){    
        
        $data = $request->input();
        $query = Locations::select('location_config.*', 'city.regionStateId')
                    ->join('region_city as city', 'cityId', '=', 'city.id')
                    ->join('region_country_state as state', 'city.regionStateId', '=', 'state.id');
       
        if($request->region=="MYS"){
            $query->where(function ($query) {
                $query->where('regionCountryId', '=', 'MYS');
                });              
        }
        //dd($query);
        if($request->region=="PAK"){
            $query->where(function ($query) {
                $query->where('regionCountryId', '=', 'PAK');
                });              
        }
                    
        $query->orderBy('sequence', 'ASC');
        $datas = $query->get();  
           
        $citySelected = "";
        $stateSelected = "";
        
        $sql="SELECT id, name, regionStateId FROM region_city ORDER BY regionStateId, name";
        $cityList = DB::connection('mysql2')->select($sql);

        $sql="SELECT id, name, regionCountryId FROM region_country_state ORDER BY regionCountryId, name";
        $stateList = DB::connection('mysql2')->select($sql);

        $regionCityList=array();
        $regionList = CityRegion::select('location_area.*','usercity.name AS userCityName', 
                    'storecity.name AS storeCityName','usercity.regionStateId AS stateId')
                    ->join('region_city as usercity', 'userLocationCityId', '=', 'usercity.id')
                    ->join('region_city as storecity', 'storeCityId', '=', 'storecity.id')
                    ->orderBy('usercity.regionStateId', 'ASC')
                    ->orderBy('usercity.name', 'ASC')->get();  
        foreach ($regionList as $region) {
            if (array_key_exists($region['userLocationCityId'],  $regionCityList))
                $regionCityList[$region['userLocationCityId']]=$regionCityList[$region['userLocationCityId']].", ".$region['storeCityId'];
            else
                $regionCityList[$region['userLocationCityId']]=$region['storeCityId'];
        }
        $basepreviewurl = $this->basepreviewurl;

        return view('components.locations', compact('datas','cityList','citySelected', 'stateList', 'stateSelected', 'regionCityList', 'basepreviewurl'));
    }

    public function add_location(Request $request){
        //copy file to folder
        $file = $request->file('selectFile');
        $extension = $file->getClientOriginalExtension();
        //Move Uploaded File
        $newfilename = date("YmdHis").".".$extension;
        $destinationPath = $this->basepath;
        echo " path:".$destinationPath;
        $file->move($destinationPath,$newfilename);
        $url = $this->baseurl."/".$newfilename;
        echo " url:".$url;
        $banner = new Locations();
        $banner->cityId = $request->selectCity;
        $banner->imageUrl = $url;
        $banner->sequence = $request->sequence;
        $banner->isDisplay = 1;
        $banner->save();

         $datas = Locations::select('location_config.*', 'city.regionStateId')
                    ->join('region_city as city', 'cityId', '=', 'city.id')
                    ->orderBy('sequence', 'ASC')
                    ->get();      
        $citySelected = "";
        $stateSelected = "";
        
        $sql="SELECT id, name, regionStateId FROM region_city ORDER BY regionStateId, name";
        $cityList = DB::connection('mysql2')->select($sql);

        $sql="SELECT id, name, regionCountryId FROM region_country_state ORDER BY regionCountryId, name";
        $stateList = DB::connection('mysql2')->select($sql);

        $regionCityList=array();
        $regionList = CityRegion::select('location_area.*','usercity.name AS userCityName', 
                    'storecity.name AS storeCityName','usercity.regionStateId AS stateId')
                    ->join('region_city as usercity', 'userLocationCityId', '=', 'usercity.id')
                    ->join('region_city as storecity', 'storeCityId', '=', 'storecity.id')
                    ->orderBy('usercity.regionStateId', 'ASC')
                    ->orderBy('usercity.name', 'ASC')->get();  
        foreach ($regionList as $region) {
            if (array_key_exists($region['userLocationCityId'],  $regionCityList))
                $regionCityList[$region['userLocationCityId']]=$regionCityList[$region['userLocationCityId']].", ".$region['storeCityId'];
            else
                $regionCityList[$region['userLocationCityId']]=$region['storeCityId'];
        }
        $basepreviewurl = $this->basepreviewurl;

        return view('components.locations', compact('datas','cityList','citySelected', 'stateList', 'stateSelected', 'regionCityList', 'basepreviewurl'));
    }

    public function delete_location(Request $request){
        DB::connection('mysql2')->delete("DELETE FROM location_config WHERE id='".$request->id."'");

         $datas = Locations::select('location_config.*', 'city.regionStateId')
                    ->join('region_city as city', 'cityId', '=', 'city.id')
                    ->orderBy('sequence', 'ASC')
                    ->get();        
        $citySelected = "";
        $stateSelected = "";
        
        $sql="SELECT id, name, regionStateId FROM region_city ORDER BY regionStateId, name";
        $cityList = DB::connection('mysql2')->select($sql);

        $sql="SELECT id, name, regionCountryId FROM region_country_state ORDER BY regionCountryId, name";
        $stateList = DB::connection('mysql2')->select($sql);

        $regionCityList=array();
        $regionList = CityRegion::select('location_area.*','usercity.name AS userCityName', 
                    'storecity.name AS storeCityName','usercity.regionStateId AS stateId')
                    ->join('region_city as usercity', 'userLocationCityId', '=', 'usercity.id')
                    ->join('region_city as storecity', 'storeCityId', '=', 'storecity.id')
                    ->orderBy('usercity.regionStateId', 'ASC')
                    ->orderBy('usercity.name', 'ASC')->get();  
        foreach ($regionList as $region) {
            if (array_key_exists($region['userLocationCityId'],  $regionCityList))
                $regionCityList[$region['userLocationCityId']]=$regionCityList[$region['userLocationCityId']].", ".$region['storeCityId'];
            else
                $regionCityList[$region['userLocationCityId']]=$region['storeCityId'];
        }
        $basepreviewurl = $this->basepreviewurl;

        return view('components.locations', compact('datas','cityList','citySelected', 'stateList', 'stateSelected', 'regionCityList', 'basepreviewurl'));

    }

    public function edit_location(Request $request){

        if ($request->file('selectFile')) {        
            //copy file to folder
            $file = $request->file('selectFile');
            $extension = $file->getClientOriginalExtension();
            //Move Uploaded File
            $newfilename = date("YmdHis").".".$extension;
            $destinationPath = $this->basepath;
            echo " path:".$destinationPath;
            $file->move($destinationPath,$newfilename);
            $url = $this->baseurl."/".$newfilename;
            echo " url:".$url;
            //exit;
        }

        $datalist = Locations::where('id',$request->id)->get();
        $data = $datalist[0];
        $data->sequence = $request->sequence;
        $data->isDisplay = 1;
        if ($request->file('selectFile')) {
            $data->imageUrl = $url;
        }
        $data->save();
        
        $datas = Locations::select('location_config.*', 'city.regionStateId')
                    ->join('region_city as city', 'cityId', '=', 'city.id')
                    ->orderBy('sequence', 'ASC')
                    ->get();  
        $citySelected = "";
        $stateSelected = "";
        
        $sql="SELECT id, name, regionStateId FROM region_city ORDER BY regionStateId, name";
        $cityList = DB::connection('mysql2')->select($sql);

        $sql="SELECT id, name, regionCountryId FROM region_country_state ORDER BY regionCountryId, name";
        $stateList = DB::connection('mysql2')->select($sql);

        $regionCityList=array();
        $regionList = CityRegion::select('location_area.*','usercity.name AS userCityName', 
                    'storecity.name AS storeCityName','usercity.regionStateId AS stateId')
                    ->join('region_city as usercity', 'userLocationCityId', '=', 'usercity.id')
                    ->join('region_city as storecity', 'storeCityId', '=', 'storecity.id')
                    ->orderBy('usercity.regionStateId', 'ASC')
                    ->orderBy('usercity.name', 'ASC')->get();  
        foreach ($regionList as $region) {
            if (array_key_exists($region['userLocationCityId'],  $regionCityList))
                $regionCityList[$region['userLocationCityId']]=$regionCityList[$region['userLocationCityId']].", ".$region['storeCityId'];
            else
                $regionCityList[$region['userLocationCityId']]=$region['storeCityId'];
        }
        $basepreviewurl = $this->basepreviewurl;
        
        return view('components.locations', compact('datas','cityList','citySelected', 'stateList', 'stateSelected', 'regionCityList', 'basepreviewurl'));

    }


    public function index(){        
        $datas = CityRegion::select('location_area.*','usercity.name AS userCityName', 
                    'storecity.name AS storeCityName','usercity.regionStateId AS stateId')
                    ->join('region_city as usercity', 'userLocationCityId', '=', 'usercity.id')
                    ->join('region_city as storecity', 'storeCityId', '=', 'storecity.id')
                    ->orderBy('usercity.regionStateId', 'ASC')
                    ->orderBy('usercity.name', 'ASC')->get();        
        $citySelected = "";
        $stateSelected = "";
        
        $sql="SELECT id, name, regionStateId FROM region_city ORDER BY regionStateId, name";
        $cityList = DB::connection('mysql2')->select($sql);

        $sql="SELECT id, name, regionCountryId FROM region_country_state ORDER BY regionCountryId, name";
        $stateList = DB::connection('mysql2')->select($sql);

        return view('components.cityregion', compact('datas','cityList','citySelected', 'stateList', 'stateSelected'));
    }

     public function filterCity(Request $request) {    
      $sql="SELECT id, name, regionStateId FROM region_city WHERE regionStateId = '".$request->stateId."' ORDER BY regionStateId, name";
      $cityList = DB::connection('mysql2')->select($sql);

      return response()->json(array('cityList'=> $cityList), 200);
    }

    public function searchCity(Request $request) {    
      $datas = CityRegion::select('location_area.*','usercity.name AS userCityName', 
                    'storecity.name AS storeCityName','usercity.regionStateId AS stateId')
                    ->join('region_city as usercity', 'userLocationCityId', '=', 'usercity.id')
                    ->join('region_city as storecity', 'storeCityId', '=', 'storecity.id')
                    ->where('location_area.userLocationCityId', $request->city)
                    ->orderBy('usercity.regionStateId', 'ASC')
                    ->orderBy('usercity.name', 'ASC')->get();   
      return response()->json(array('cityList'=> $datas), 200);
   }
  
    public function filter_cityregion(Request $req){

        $data = $req->input();
        
        $query = CityRegion::select('location_area.*','usercity.name AS userCityName', 
                                    'storecity.name AS storeCityName','usercity.regionStateId AS stateId')
                            ->join('region_city as usercity', 'userLocationCityId', '=', 'usercity.id')
                            ->join('region_city as storecity', 'storeCityId', '=', 'storecity.id')
                            ->join('region_country_state as state', 'usercity.regionStateId', '=', 'state.id');

        if($req->region=="MYS"){
            $query->where(function ($query) {
                $query->where('regionCountryId', '=', 'MYS');
                });              
        }
        //dd($query);
        if($req->region=="PAK"){
            $query->where(function ($query) {
                $query->where('regionCountryId', '=', 'PAK');
                });              
        }

        $query->orderBy('usercity.regionStateId', 'ASC')->orderBy('usercity.name', 'ASC');
        $datas = $query->get(); 
     
        $citySelected = "";
        $stateSelected = "";
        
        $sql="SELECT id, name, regionStateId FROM region_city ORDER BY regionStateId, name";
        $cityList = DB::connection('mysql2')->select($sql);

        $sql="SELECT id, name, regionCountryId FROM region_country_state ORDER BY regionCountryId, name";
        $stateList = DB::connection('mysql2')->select($sql);

        return view('components.cityregion', compact('datas','cityList','citySelected', 'stateList', 'stateSelected'));

    }

    public function add_cityregion(Request $request){
        $f = new CityRegion();
        $f->userLocationCityId = $request->selectCity;
        $f->storeCityId = $request->selectNCity;
        $f->save();

        $citySelected = $request->selectCity;
        $stateSelected = $request->selectState;
        
        $sql="SELECT id, name, regionCountryId FROM region_country_state ORDER BY regionCountryId, name";
        $stateList = DB::connection('mysql2')->select($sql);

        $sql="SELECT id, name, regionStateId FROM region_city ORDER BY regionStateId, name";
        $cityList = DB::connection('mysql2')->select($sql);

        $datas = CityRegion::select('location_area.*','usercity.name AS userCityName', 
                    'storecity.name AS storeCityName','usercity.regionStateId AS stateId')
                    ->join('region_city as usercity', 'userLocationCityId', '=', 'usercity.id')
                    ->join('region_city as storecity', 'storeCityId', '=', 'storecity.id')
                    ->where('location_area.userLocationCityId', $request->selectCity)
                    ->orderBy('usercity.regionStateId', 'ASC')
                    ->orderBy('usercity.name', 'ASC')->get();        

        return view('components.cityregion', compact('datas','cityList','citySelected', 'stateList', 'stateSelected'));

    }


     public function delete_cityregion(Request $request){
        DB::connection('mysql2')->delete("DELETE FROM location_area WHERE id='".$request->id."'");
        
        $datas = CityRegion::select('location_area.*','usercity.name AS userCityName', 
                    'storecity.name AS storeCityName','usercity.regionStateId AS stateId')
                    ->join('region_city as usercity', 'userLocationCityId', '=', 'usercity.id')
                    ->join('region_city as storecity', 'storeCityId', '=', 'storecity.id')
                    ->where('location_area.userLocationCityId', $request->cityId)
                    ->orderBy('usercity.regionStateId', 'ASC')
                    ->orderBy('usercity.name', 'ASC')->get();        
        $citySelected = $request->cityId;
        
        $sql="SELECT id, name, regionStateId FROM region_city WHERE regionStateId = '".$request->stateId."' ORDER BY regionStateId, name";
        $cityList = DB::connection('mysql2')->select($sql);

        $sql="SELECT id, name, regionCountryId FROM region_country_state ORDER BY regionCountryId, name";
        $stateList = DB::connection('mysql2')->select($sql);

        $stateSelected = $request->selectState;
        
        return view('components.cityregion', compact('datas','cityList','citySelected', 'stateList', 'stateSelected'));

    }


}