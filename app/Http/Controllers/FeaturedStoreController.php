<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use App\Models\FeaturedStore;
use Carbon\Carbon;
use DateTime;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Mail;
 
use App\Mail\NotifyMail;
use App\Mail\EmailContent;

class FeaturedStoreController extends Controller
{

    protected $url;
    protected $token;

    function __construct() {
            $this->url = config('services.report_svc.url');
            $this->token = config('services.report_svc.token');
    }


    public function index(){
        
        $datas = FeaturedStore::select('store_display_config.*','store.name AS storeName')
                    ->join('store as store', 'storeId', '=', 'store.id')->orderBy('sequence', 'ASC')->get();        
        $storename = "";
        $searchresult=array();

        $sql="SELECT id, name, verticalCode FROM store_category WHERE verticalCode IS NOT NULL";
        $categorylist = DB::connection('mysql2')->select($sql);
        $categoryselected="";

        return view('components.featuredstore', compact('datas','storename','searchresult', 'categorylist','categoryselected'));
    }

    public function searchStore(Request $request) {    
      $sql="SELECT id, name FROM store WHERE verticalCode='".$request->vertical."' ORDER BY name";
      $storeList = DB::connection('mysql2')->select($sql);
      return response()->json(array('storeList'=> $storeList), 200);
   }

    public function filter_store(Request $req){
        
        $datas = FeaturedStore::select('store_display_config.*','store.name AS storeName')
                    ->join('store as store', 'storeId', '=', 'store.id')->orderBy('sequence', 'ASC')->get();        
        $storename = $req->store_name;       

        $sql="SELECT DISTINCT(B.id), B.name as storeName, B.city, C.name as category, D.sequence
                    FROM product A 
                        INNER JOIN store B ON A.storeId=B.id 
                        INNER JOIN store_category C ON A.categoryId=C.id
                        LEFT JOIN store_display_config D ON D.storeId=A.id
                    WHERE A.id IS NOT NULL ";
        if ($req->store_name<>"") {
            $sql .= "AND B.name like '%".$req->store_name."%'";    
        }
        if ($req->selectCategory<>"") {
            $sql .= "AND C.parentCategoryId = '".$req->selectCategory."'";    
        }
        echo $sql;
        $searchresult = DB::connection('mysql2')->select($sql);
        
        $sql="SELECT id, name, verticalCode FROM store_category WHERE verticalCode IS NOT NULL";
        $categorylist = DB::connection('mysql2')->select($sql);
        $categoryselected = $req->selectCategory;

        return view('components.featuredstore', compact('datas','searchresult', 'storename', 'categorylist','categoryselected'));

    }

    public function add_featuredstore(Request $request){
        $f = new FeaturedStore();
        $f->storeId = $request->id;
        $f->sequence = $request->sequence;
        $f->save();

        $datas = FeaturedStore::select('store_display_config.*','store.name AS storeName')
                    ->join('store as store', 'storeId', '=', 'store.id')->orderBy('sequence', 'ASC')->get();        
        $storename=null;
        $searchresult=array();

        $sql="SELECT id, name, verticalCode FROM store_category WHERE verticalCode IS NOT NULL";
        $categorylist = DB::connection('mysql2')->select($sql);
        $categoryselected="";

        return view('components.featuredstore', compact('datas','searchresult', 'storename', 'categorylist','categoryselected'));
    }


     public function delete_featuredstore(Request $request){
        DB::connection('mysql2')->delete("DELETE FROM store_display_config WHERE id='".$request->id."'");
        $datas = FeaturedStore::select('store_display_config.*','store.name AS storeName')
                    ->join('store as store', 'storeId', '=', 'store.id')->orderBy('sequence', 'ASC')->get();        
        $storename=null;
        $searchresult=array();
        
        $sql="SELECT id, name, verticalCode FROM store_category WHERE verticalCode IS NOT NULL";
        $categorylist = DB::connection('mysql2')->select($sql);
        $categoryselected="";

        return view('components.featuredstore', compact('datas','searchresult', 'storename','categorylist','categoryselected'));
        
    }

    public function edit_featuredstore(Request $request){
        $datalist = FeaturedStore::where('id',$request->id)->get();
        $data = $datalist[0];
        $data->sequence = $request->sequence;
        $data->save();
        
        $datas = FeaturedStore::select('store_display_config.*','store.name AS storeName')
                    ->join('store as store', 'storeId', '=', 'store.id')->orderBy('sequence', 'ASC')->get();        
        $storename=null;
        $searchresult=array();
        
        $sql="SELECT id, name, verticalCode FROM store_category WHERE verticalCode IS NOT NULL";
        $categorylist = DB::connection('mysql2')->select($sql);
        $categoryselected="";

        return view('components.featuredstore', compact('datas','searchresult', 'storename','categorylist','categoryselected'));
    }



}