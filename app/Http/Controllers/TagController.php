<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use App\Models\TagConfig;
use App\Models\TagDetails;
use App\Models\TagKeyword;
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

class TagController extends Controller
{

    protected $url;
    protected $token;
    protected $baseurl;
    protected $basepreviewurl;
    protected $basepath;

    function __construct() {
            $this->url = config('services.report_svc.url');
            $this->token = config('services.report_svc.token');
            $this->baseurl = config('services.tagbanner_svc.url');
            $this->basepreviewurl = config('services.tagbanner_svc.previewurl');
            $this->basepath = config('services.tagbanner_svc.path');
    }


    public function index(){
        $datas = TagKeyword::select('tag_keyword.*')->get(); 
        foreach ($datas as $data) {
            //find details
            $query = TagDetails::select('tag_details.*' , 'product.name AS productName', 'store.name AS storeName', 'store_category.name as categoryName')
                ->leftjoin('product', 'tag_details.productId' ,'=', 'product.id')
                ->leftjoin('store', 'tag_details.storeId' ,'=', 'store.id')
                ->leftjoin('store_category', 'tag_details.categoryId' ,'=', 'store_category.id')
                ->where('tag_details.tagId', '=', $data->id); 
            $details = $query->get();
            //dd($details);
            $data->details = $details;

            $query = TagConfig::select('tag_config.*')->where('tag_config.tagId', '=', $data->id); 
            $configs = $query->get();
            //dd($details);
            $data->configs = $configs;
        }     
        //dd($datas);  
        return view('components.tag', compact('datas'));
    }

    public function tag_filter(Request $request){

        $data = $request->input();

        $query = PlatformOgTag::select('platform_config.*', 'platform_og_tag.*')
                              ->join('platform_config', 'platform_og_tag.platformId' ,'=', 'platform_config.platformId');

        $selectedplatform = $request->id_platform ;
        if($request->id_platform <> "" ){
               $query->where('platform_config.platformId', '=', $request->id_platform);           
         }

        return view('components.tag', compact('datas','platformdata','propertylist','selectedplatform'));
    }

    public function add_tag(Request $request){
        $data = new TagKeyword();
        $data->keyword = $request->keyword;
        $data->longitude = $request->longitude;
        $data->latitude = $request->latitude;
        $data->save();

        
        $datas = TagKeyword::select('tag_keyword.*')->get(); 
        foreach ($datas as $data) {
            //find details
            $query = TagDetails::select('tag_details.*' , 'product.name AS productName', 'store.name AS storeName', 'store_category.name as categoryName')
                ->leftjoin('product', 'tag_details.productId' ,'=', 'product.id')
                ->leftjoin('store', 'tag_details.storeId' ,'=', 'store.id')
                ->leftjoin('store_category', 'tag_details.categoryId' ,'=', 'store_category.id')
                ->where('tag_details.tagId', '=', $data->id); 
            $details = $query->get();
            //dd($details);
            $data->details = $details;

            $query = TagConfig::select('tag_config.*')->where('tag_config.tagId', '=', $data->id); 
            $configs = $query->get();
            //dd($details);
            $data->configs = $configs;
        }     

        return view('components.tag', compact('datas'));
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

    public function delete_tag(Request $request){
        DB::connection('mysql2')->delete("DELETE FROM tag_keyword WHERE id='".$request->id."'");       
        $datas = TagKeyword::select('tag_keyword.*')->get(); 
        foreach ($datas as $data) {
            //find details
            $query = TagDetails::select('tag_details.*' , 'product.name AS productName', 'store.name AS storeName', 'store_category.name as categoryName')
                ->leftjoin('product', 'tag_details.productId' ,'=', 'product.id')
                ->leftjoin('store', 'tag_details.storeId' ,'=', 'store.id')
                ->leftjoin('store_category', 'tag_details.categoryId' ,'=', 'store_category.id')
                ->where('tag_details.tagId', '=', $data->id); 
            $details = $query->get();
            //dd($details);
            $data->details = $details;

            $query = TagConfig::select('tag_config.*')->where('tag_config.tagId', '=', $data->id); 
            $configs = $query->get();
            //dd($details);
            $data->configs = $configs;
        }     
        return view('components.tag', compact('datas'));
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


    public function add_tag_details(Request $request){
        $keywordId = $request->keywordId;
        $datas = TagKeyword::select('tag_keyword.*')
                ->where('tag_keyword.id', '=', $keywordId)
                ->get();        
        return view('components.tag-add-details', compact('datas','keywordId'));
    }

    public function save_tag_details(Request $request){
        $keywordId = $request->keywordId;
        $storeId = $request->storeId;
        $data = new TagDetails();
        $data->tagId = $request->keywordId;
        $data->storeId = $request->storeId;
        $data->save();      
        return response()->json($data, 200); 
    }


    public function query_tag_details(Request $req){
       
        //find details
        $query = TagDetails::select('tag_details.*' , 'product.name AS productName', 'store.name AS storeName', 'store_category.name as categoryName')
            ->leftjoin('product', 'tag_details.productId' ,'=', 'product.id')
            ->leftjoin('store', 'tag_details.storeId' ,'=', 'store.id')
            ->leftjoin('store_category', 'tag_details.categoryId' ,'=', 'store_category.id')
            ->where('tag_details.tagId', '=', $req->keywordId); 
        $details = $query->get();
        return response()->json(array('storeList'=> $details), 200); 

    }


     public function deletemultiple_tag_details(Request $request){
        $ids = $request->ids;
        foreach ($ids as $id) {
            DB::connection('mysql2')->delete("DELETE FROM tag_details WHERE id='".$id."'");
        
        }
        
        //find details
        $query = TagDetails::select('tag_details.*' , 'product.name AS productName', 'store.name AS storeName', 'store_category.name as categoryName')
            ->leftjoin('product', 'tag_details.productId' ,'=', 'product.id')
            ->leftjoin('store', 'tag_details.storeId' ,'=', 'store.id')
            ->leftjoin('store_category', 'tag_details.categoryId' ,'=', 'store_category.id')
            ->where('tag_details.tagId', '=', $request->keywordId); 
        $details = $query->get();
        return response()->json(array('storeList'=> $details), 200); 
        
    }


      public function add_tag_config(Request $request){
        $keywordId = $request->keywordId;
        $datas = TagKeyword::select('tag_keyword.*')
                ->where('tag_keyword.id', '=', $keywordId)
                ->get();        
        return view('components.tag-add-config', compact('datas','keywordId'));
    }

    public function save_tag_config(Request $request){
        $keywordId = $request->keywordId;
        $storeId = $request->storeId;
        $file = $request->file('selectFile');        

        $data = new TagConfig();
        $data->tagId = $request->keywordId;
        $data->property = $request->prop;
        $data->content = $request->txtContent;

        if ($file) {
            $extension = $file->getClientOriginalExtension();
            //Move Uploaded File
            $newfilename = date("YmdHis").".".$extension;
            $destinationPath = $this->basepath;
            //echo " path:".$destinationPath;
            $file->move($destinationPath,$newfilename);
            $url = $this->baseurl."/".$newfilename;
            $data->content = $url;
        }

        $data->save();      
        
        $keywordId = $request->keywordId;
        $datas = TagKeyword::select('tag_keyword.*')
                ->where('tag_keyword.id', '=', $keywordId)
                ->get(); 
        return view('components.tag-add-config', compact('datas','keywordId'));
    }


    public function query_tag_config(Request $req){
       
        //find details
        $query = TagConfig::select('tag_config.*')
            ->where('tag_config.tagId', '=', $req->keywordId); 
        $details = $query->get();
        return response()->json(array('storeList'=> $details), 200); 

    }


     public function deletemultiple_tag_config(Request $request){
        $ids = $request->ids;
        foreach ($ids as $id) {
            DB::connection('mysql2')->delete("DELETE FROM tag_config WHERE id='".$id."'");
        
        }
        
        //find details
        $query = TagConfig::select('tag_config.*')
            ->where('tag_config.tagId', '=', $request->keywordId); 
        $details = $query->get();
        return response()->json(array('storeList'=> $details), 200); 
        
    }

}