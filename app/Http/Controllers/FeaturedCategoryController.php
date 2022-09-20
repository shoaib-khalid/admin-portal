<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use App\Models\FeaturedCategory;
use App\Models\StoreCategory;
use Carbon\Carbon;
use DateTime;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Mail;
 
use App\Mail\NotifyMail;
use App\Mail\EmailContent;

class FeaturedCategoryController extends Controller
{

    protected $url;
    protected $token;

    function __construct() {
            $this->url = config('services.report_svc.url');
            $this->token = config('services.report_svc.token');
    }


    public function index(){        
        $datas = StoreCategory::select('*', 'displaySequence as sequence', 'name AS categoryName')
                ->whereRaw('verticalCode IS NOT NULL')
                ->orderBy('verticalCode', 'ASC')
                ->orderBy('displaySequence', 'ASC')
                ->get(); 
        //dd($datas);       
        $citySelected = "";
        $stateSelected = "";
        $categorySelected = "";
        $verticalSelected = "";

        $sql="SELECT id, name, regionStateId FROM region_city ORDER BY regionStateId, name";
        $cityList = DB::connection('mysql2')->select($sql);

        $sql="SELECT id, name, regionCountryId FROM region_country_state ORDER BY regionCountryId, name";
        $stateList = DB::connection('mysql2')->select($sql);

        $sql="SELECT id, name, verticalCode FROM store_category WHERE verticalCode IS NOT NULL ORDER BY verticalCode, name";
        $categoryList = DB::connection('mysql2')->select($sql);
        
        $sql="SELECT * FROM region_vertical";
        $verticalList = DB::connection('mysql2')->select($sql);

        return view('components.featuredcategory', compact('datas','cityList','citySelected', 'stateList', 'stateSelected', 'categoryList', 'categorySelected', 'verticalList', 'verticalSelected'));
    }

    public function filter_featuredcategory(Request $request){     
        
        $data = $request->input();
        $query = StoreCategory::select('*', 'displaySequence as sequence', 'name AS categoryName')
                ->whereRaw('verticalCode IS NOT NULL');
        
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

        $query->orderBy('verticalCode', 'ASC')->orderBy('displaySequence', 'ASC');
        //dd($query);
        $datas = $query->get();
    
        //dd($datas);       
        $citySelected = "";
        $stateSelected = "";
        $categorySelected = "";
        $verticalSelected = "";

        $sql="SELECT id, name, regionStateId FROM region_city ORDER BY regionStateId, name";
        $cityList = DB::connection('mysql2')->select($sql);

        $sql="SELECT id, name, regionCountryId FROM region_country_state ORDER BY regionCountryId, name";
        $stateList = DB::connection('mysql2')->select($sql);

        $sql="SELECT id, name, verticalCode FROM store_category WHERE verticalCode IS NOT NULL ORDER BY verticalCode, name";
        $categoryList = DB::connection('mysql2')->select($sql);
        
        $sql="SELECT * FROM region_vertical";
        $verticalList = DB::connection('mysql2')->select($sql);

        return view('components.featuredcategory', compact('datas','cityList','citySelected', 'stateList', 'stateSelected', 'categoryList', 'categorySelected', 'verticalList', 'verticalSelected'));
    }

    public function searchByVertical(Request $request) {    
      $datas = StoreCategory::select('*', 'displaySequence as sequence', 'name AS categoryName')
                ->whereRaw("verticalCode = '".$request->vertical."'")
                ->orderBy('verticalCode', 'ASC')
                ->orderBy('displaySequence', 'ASC')
                ->get(); 
      return response()->json(array('cityList'=> $datas), 200);
    }

    public function searchCityCategory(Request $request) {    
      $datas = FeaturedCategory::select('location_category_config.*','city.name AS cityName', 
                    'city.regionStateId AS stateId','category.name AS categoryName', 'category.verticalCode AS verticalCode')
                    ->join('region_city as city', 'location_category_config.cityId', '=', 'city.id')
                    ->join('store_category as category', 'location_category_config.categoryId', '=', 'category.id')
                    ->where('location_category_config.cityId', $request->city)
                    ->orderBy('category.verticalCode', 'ASC')
                    ->orderBy('location_category_config.sequence', 'ASC')
                    ->get();  
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

     public function add_featuredcategory(Request $request){
        $f = new FeaturedCategory();
        $f->cityId = $request->selectCity;
        $f->categoryId = $request->selectCategory;
        $f->sequence = $request->sequence;
        $f->save();

        $citySelected = $request->selectCity;
        $stateSelected = "";
        $categorySelected = $request->selectCategory;;
        
        $sql="SELECT id, name, regionStateId FROM region_city ORDER BY regionStateId, name";
        $cityList = DB::connection('mysql2')->select($sql);

        $sql="SELECT id, name, regionCountryId FROM region_country_state ORDER BY regionCountryId, name";
        $stateList = DB::connection('mysql2')->select($sql);

        $sql="SELECT id, name, verticalCode FROM store_category WHERE verticalCode IS NOT NULL ORDER BY verticalCode, name";
        $categoryList = DB::connection('mysql2')->select($sql);
        //dd($categoryList);

        $datas = FeaturedCategory::select('location_category_config.*','city.name AS cityName', 
                    'city.regionStateId AS stateId','category.name AS categoryName', 'category.verticalCode AS verticalCode')
                    ->join('region_city as city', 'location_category_config.cityId', '=', 'city.id')
                    ->join('store_category as category', 'location_category_config.categoryId', '=', 'category.id')
                    ->where('location_category_config.cityId', $request->selectCity)
                    ->orderBy('category.verticalCode', 'ASC')
                    ->orderBy('location_category_config.sequence', 'ASC')
                    ->get();

        $sql="SELECT * FROM region_vertical";
        $verticalList = DB::connection('mysql2')->select($sql);
        $verticalSelected = "";

        return view('components.featuredcategory', compact('datas','cityList','citySelected', 'stateList', 'stateSelected', 'categoryList', 'categorySelected', 'verticalList', 'verticalSelected'));

    }

    public function edit_featuredcategory(Request $request){
        if ($request->cityName==null) {            
            
            if ($request->sequence=="") {
                DB::connection('mysql2')->update("UPDATE store_category SET displaySequence=NULL WHERE id='".$request->id."'");
            } else {
                DB::connection('mysql2')->update("UPDATE store_category SET displaySequence=".$request->sequence." WHERE id='".$request->id."'");
            }
            
            $datas = StoreCategory::select('*', 'displaySequence as sequence', 'name AS categoryName')
                ->whereRaw('verticalCode IS NOT NULL')
                ->orderBy('verticalCode', 'ASC')
                ->orderBy('displaySequence', 'ASC')
                ->get(); 
            //dd($datas);       
            $citySelected = "";
            $stateSelected = "";
            
            $sql="SELECT id, name, regionStateId FROM region_city ORDER BY regionStateId, name";
            $cityList = DB::connection('mysql2')->select($sql);

            $sql="SELECT id, name, regionCountryId FROM region_country_state ORDER BY regionCountryId, name";
            $stateList = DB::connection('mysql2')->select($sql);

            $sql="SELECT id, name, verticalCode FROM store_category WHERE verticalCode IS NOT NULL ORDER BY verticalCode, name";
            $categoryList = DB::connection('mysql2')->select($sql);
            $categorySelected="";

            $sql="SELECT * FROM region_vertical";
            $verticalList = DB::connection('mysql2')->select($sql);
            $verticalSelected = "";

            return view('components.featuredcategory', compact('datas','cityList','citySelected', 'stateList', 'stateSelected', 'categoryList', 'categorySelected', 'verticalList', 'verticalSelected'));

        } else {

            DB::connection('mysql2')->update("UPDATE location_category_config SET sequence=".$request->sequence." WHERE id='".$request->id."'");

            $stateSelected = "";
            
            $sql="SELECT id, name, regionStateId FROM region_city ORDER BY regionStateId, name";
            $cityList = DB::connection('mysql2')->select($sql);

            $sql="SELECT id, name, regionCountryId FROM region_country_state ORDER BY regionCountryId, name";
            $stateList = DB::connection('mysql2')->select($sql);

            $sql="SELECT id, name, verticalCode FROM store_category WHERE verticalCode IS NOT NULL ORDER BY verticalCode, name";
            $categoryList = DB::connection('mysql2')->select($sql);
            $categorySelected="";

            $datas = FeaturedCategory::select('location_category_config.*','city.name AS cityName', 
                    'city.regionStateId AS stateId','category.name AS categoryName', 'category.verticalCode AS verticalCode')
                    ->join('region_city as city', 'location_category_config.cityId', '=', 'city.id')
                    ->join('store_category as category', 'location_category_config.categoryId', '=', 'category.id')
                    ->where('location_category_config.cityId', $request->cityId)
                    ->orderBy('category.verticalCode', 'ASC')
                    ->orderBy('location_category_config.sequence', 'ASC')
                    ->get();
            $citySelected = $request->cityId;

            $sql="SELECT * FROM region_vertical";
            $verticalList = DB::connection('mysql2')->select($sql);
            $verticalSelected = "";

            return view('components.featuredcategory', compact('datas','cityList','citySelected', 'stateList', 'stateSelected', 'categoryList', 'categorySelected', 'verticalList', 'verticalSelected'));
        }
        

        
    }


     public function delete_featuredcategory(Request $request){
        DB::connection('mysql2')->delete("DELETE FROM location_category_config WHERE id='".$request->id."'");
        
        $sql="SELECT id, name, regionStateId FROM region_city ORDER BY regionStateId, name";
        $cityList = DB::connection('mysql2')->select($sql);

        $sql="SELECT id, name, regionCountryId FROM region_country_state ORDER BY regionCountryId, name";
        $stateList = DB::connection('mysql2')->select($sql);

        $datas = FeaturedCategory::select('location_category_config.*','city.name AS cityName', 
                    'city.regionStateId AS stateId','category.name AS categoryName', 'category.verticalCode AS verticalCode')
                    ->join('region_city as city', 'location_category_config.cityId', '=', 'city.id')
                    ->join('store_category as category', 'location_category_config.categoryId', '=', 'category.id')
                    ->where('location_category_config.cityId', $request->cityId)
                    ->orderBy('category.verticalCode', 'ASC')
                    ->orderBy('location_category_config.sequence', 'ASC')
                    ->get();
        $citySelected = $request->cityId;
        $stateSelected = "";

        $sql="SELECT id, name, verticalCode FROM store_category WHERE verticalCode IS NOT NULL ORDER BY verticalCode, name";
        $categoryList = DB::connection('mysql2')->select($sql);
        $categorySelected="";

        $sql="SELECT * FROM region_vertical";
        $verticalList = DB::connection('mysql2')->select($sql);
        $verticalSelected = "";
        
        return view('components.featuredcategory', compact('datas','cityList','citySelected', 'stateList', 'stateSelected', 'categoryList', 'categorySelected', 'verticalList', 'verticalSelected'));

    }


}