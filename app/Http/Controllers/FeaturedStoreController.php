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
                    ->join('store as store', 'storeId', '=', 'store.id')->get();
        $currentdata=null;

        $sql="SELECT code FROM region_vertical";
        $verticallist = DB::connection('mysql2')->select($sql);

        return view('components.featuredstore', compact('datas','currentdata','verticallist'));
    }

    public function searchStore(Request $request) {    
      $sql="SELECT id, name FROM store WHERE verticalCode='".$request->vertical."' ORDER BY name";
      $storeList = DB::connection('mysql2')->select($sql);
      return response()->json(array('storeList'=> $storeList), 200);
   }

    public function add_featuredstore(Request $request){
        $f = new FeaturedStore();
        $f->storeId = $request->selectStore;
        $f->sequence = $request->sequence;
        $f->save();

        $datas = FeaturedStore::get();
        $currentdata=null;

        $sql="SELECT code FROM region_vertical";
        $verticallist = DB::connection('mysql2')->select($sql);

        return view('components.featuredstore', compact('datas','currentdata','verticallist'));
    }


     public function delete_featuredstore(Request $request){
        DB::connection('mysql2')->delete("DELETE FROM store_display_config WHERE id='".$request->id."'");
        $datas = FeaturedStore::select('store_display_config.*','store.name AS storeName')
                    ->join('store as store', 'storeId', '=', 'store.id')->get();

        $currentdata=null;

        $sql="SELECT code FROM region_vertical";
        $verticallist = DB::connection('mysql2')->select($sql);

        return view('components.featuredstore', compact('datas','currentdata','verticallist'));
        
    }

    public function edit_featuredstore(Request $request){
        $datalist = FeaturedStore::where('id',$request->id)->get();
        $data = $datalist[0];
        $data->sequence = $request->sequence;
        $data->save();
        
        $currentdata=null;
        $datas = FeaturedStore::select('store_display_config.*','store.name AS storeName')
                    ->join('store as store', 'storeId', '=', 'store.id')->get();

        $sql="SELECT code FROM region_vertical";
        $verticallist = DB::connection('mysql2')->select($sql);

        return view('components.featuredstore',compact('datas','currentdata','verticallist'));
    }



}