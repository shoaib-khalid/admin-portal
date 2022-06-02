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

        return view('components.featuredstore', compact('datas','storename','searchresult'));
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
        
        $sql="SELECT A.*, B.sequence
                    FROM store A          
                    LEFT JOIN store_display_config B ON B.storeId=A.id               
                    WHERE A.id IS NOT NULL ";
        if ($req->store_name<>"") {
            $sql .= "AND A.name like '%".$req->store_name."%'";    
        }
       
        $searchresult = DB::connection('mysql2')->select($sql);
       
        return view('components.featuredstore', compact('datas','searchresult', 'storename'));

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

        return view('components.featuredstore', compact('datas','searchresult', 'storename'));
    }


     public function delete_featuredstore(Request $request){
        DB::connection('mysql2')->delete("DELETE FROM store_display_config WHERE id='".$request->id."'");
        $datas = FeaturedStore::select('store_display_config.*','store.name AS storeName')
                    ->join('store as store', 'storeId', '=', 'store.id')->orderBy('sequence', 'ASC')->get();        
        $storename=null;
        $searchresult=array();
           
        return view('components.featuredstore', compact('datas','searchresult', 'storename'));
        
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
        
        return view('components.featuredstore', compact('datas','searchresult', 'storename'));
    }



}