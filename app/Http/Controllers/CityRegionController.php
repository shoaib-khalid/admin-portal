<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use App\Models\CityRegion;
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

    function __construct() {
            $this->url = config('services.report_svc.url');
            $this->token = config('services.report_svc.token');
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
        
        $datas = CityRegion::select('location_area.*','usercity.name AS userCityName', 
                    'storecity.name AS storeCityName','usercity.regionStateId AS stateId')
                    ->join('region_city as usercity', 'userLocationCityId', '=', 'usercity.id')
                    ->join('region_city as storecity', 'storeCityId', '=', 'storecity.id')
                    ->where('location_area.userLocationCityId', $req->selectCity)
                    ->orderBy('usercity.regionStateId', 'ASC')
                    ->orderBy('usercity.name', 'ASC')->get();        
        $citySelected = $req->selectCity;
        
        $sql="SELECT id, name, regionStateId FROM region_city ORDER BY regionStateId, name";
        $cityList = DB::connection('mysql2')->select($sql);

        return view('components.cityregion', compact('datas','cityList','citySelected'));

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