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
        
        $datas = FeaturedStore::select('store_display_config.*','store.name AS storeName', 'store.city AS storeCity','store.isDelivery AS storeDelivery')
                    ->join('store as store', 'storeId', '=', 'store.id')->orderBy('sequence', 'ASC')->get();        
        $storename = "";
        $searchresult=array();

        $sql="SELECT id, name, verticalCode FROM store_category WHERE verticalCode IS NOT NULL";
        $categorylist = DB::connection('mysql2')->select($sql);
        $categoryselected="";

        $sql="SELECT cityId FROM location_config";
        $locationlist = DB::connection('mysql2')->select($sql);

        return view('components.featuredstore', compact('datas','storename','searchresult', 'categorylist','categoryselected', 'locationlist'));
    }

    public function searchStore(Request $request) {    
      $sql="SELECT id, name FROM store WHERE verticalCode='".$request->vertical."' ORDER BY name";
      $storeList = DB::connection('mysql2')->select($sql);
      return response()->json(array('storeList'=> $storeList), 200);
   }

    public function filter_store(Request $req){
       
        $sql=" SELECT DISTINCT(A.id),
            A.name AS storeName,
            A.city AS storeCity,
            A.isDelivery AS storeDelivery,
            B.sequence, B.mainLevelSequence FROM store A 
            LEFT JOIN store_display_config B ON B.storeId=A.id
             WHERE A.id IS NOT NULL ";

        if ($req->store_name<>"") {
            $sql .= "AND A.name like '%".$req->store_name."%'";    
        }
        /*if ($req->selectCategory<>"") {
            $sql .= "AND C.parentCategoryId = '".$req->selectCategory."'";    
        }*/
        if ($req->locationId<>"" && $req->locationId<>"main") {
            $sql .= "AND A.city = '".$req->locationId."'";    
        }
       // echo $sql;

        $searchresult = DB::connection('mysql2')->select($sql);
        return response()->json(array('storeList'=> $searchresult), 200); 

    }

    public function add_featuredstore(Request $request){
        $f = new FeaturedStore();
        $f->storeId = $request->id;
        $f->sequence = $request->sequence;
        $f->isMainLevel = $request->mainPage;
        if ($f->isMainLevel==true) {
            $f->mainLevelSequence = $request->mainLevelSequence;
        }
        $f->save();

        $query = FeaturedStore::select('store_display_config.*',
                'store.name AS storeName', 'store.city AS storeCity','store.isDelivery AS storeDelivery')
                ->join('store as store', 'storeId', '=', 'store.id');

        if ($request->delivery=="TRUE")
            $query->where('isDelivery',1);

        if ($request->delivery=="FALSE")
            $query->where('isDelivery',0);

        if ($request->locationId=="main") {
            $query->where('isMainLevel',1);
        } elseif ($request->locationId<>"") {
            $query->where('store.city',$request->locationId);                
        }
        
        $datas = $query->orderBy('sequence', 'ASC')->get(); 

        return response()->json(array('storeList'=> $datas), 200);
    }


     public function delete_featuredstore(Request $request){
        DB::connection('mysql2')->delete("DELETE FROM store_display_config WHERE id='".$request->id."'");
        $datas = FeaturedStore::select('store_display_config.*','store.name AS storeName', 'store.city AS storeCity','store.isDelivery AS storeDelivery')
                    ->join('store as store', 'storeId', '=', 'store.id')->orderBy('sequence', 'ASC')->get();        
        $storename=null;
        $searchresult=array();
        
        $sql="SELECT id, name, verticalCode FROM store_category WHERE verticalCode IS NOT NULL";
        $categorylist = DB::connection('mysql2')->select($sql);
        $categoryselected="";

        $sql="SELECT cityId FROM location_config";
        $locationlist = DB::connection('mysql2')->select($sql);

        return view('components.featuredstore', compact('datas','searchresult', 'storename','categorylist','categoryselected', 'locationlist'));
        
    }

    public function deletemultiple_featuredstore(Request $request){
        $ids = $request->ids;
        foreach ($ids as $id) {
            DB::connection('mysql2')->delete("DELETE FROM store_display_config WHERE id='".$id."'");
        
        }
        
        $query = FeaturedStore::select('store_display_config.*',
                'store.name AS storeName', 'store.city AS storeCity','store.isDelivery AS storeDelivery')
                ->join('store as store', 'storeId', '=', 'store.id');
                
        if ($request->locationId=="main") {
            $query->where('isMainLevel',1);
        } elseif ($request->locationId<>"") {
            $query->where('store.city',$request->locationId);                
        }
        $datas = $query->orderBy('sequence', 'ASC')->get(); 

        return response()->json(array('storeList'=> $datas), 200);
        
    }

    public function edit_featuredstore(Request $request){
        $datalist = FeaturedStore::where('id',$request->id)->get();
        $data = $datalist[0];
        $data->sequence = $request->sequence;
        if ($request->isMainLevel=="true") {
            $data->isMainLevel = 1;
            $data->mainLevelSequence = $request->mainLevelSequence;
        } else {
            $data->isMainLevel = 0;
        }
        $data->save();
        
        $query = FeaturedStore::select('store_display_config.*',
                'store.name AS storeName', 'store.city AS storeCity','store.isDelivery AS storeDelivery')
                ->join('store as store', 'storeId', '=', 'store.id');
                
        if ($request->locationId=="main") {
            $query->where('isMainLevel',1);
        } elseif ($request->locationId<>"") {
            $query->where('store.city',$request->locationId);                
        }
        $datas = $query->orderBy('sequence', 'ASC')->get(); 

        return response()->json(array('storeList'=> $datas), 200);
    }


    public function storeSearchByLocation(Request $request) {   

        $query = FeaturedStore::select('store_display_config.*','store.name AS storeName', 'store.city AS storeCity','store.isDelivery AS storeDelivery')
                    ->join('store as store', 'storeId', '=', 'store.id');

        if ($request->locationId=="main") {
            $query->where('isMainLevel',1);
        } elseif ($request->locationId<>"") {
            $query->where('store.city',$request->locationId);                  
        }
        $datas = $query->orderBy('sequence', 'ASC')->get(); 
        //dd($datas);   
        return response()->json(array('storeList'=> $datas), 200);
    }



}