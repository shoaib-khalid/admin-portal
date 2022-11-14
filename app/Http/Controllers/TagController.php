<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use App\Models\TagConfig;
use App\Models\TagDetails;
use App\Models\TagProduct;
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
    protected $tagurl;

    function __construct() {
            $this->url = config('services.report_svc.url');
            $this->token = config('services.report_svc.token');
            $this->baseurl = config('services.tagbanner_svc.url');
            $this->basepreviewurl = config('services.tagbanner_svc.previewurl');
            $this->basepath = config('services.tagbanner_svc.path');
            $this->tagurl = config('services.tagbanner_svc.usageurl');
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

            $query = TagProduct::select('tag_product_feature.*','product.name AS productName',)
                        ->join('product', 'tag_product_feature.productId' ,'=', 'product.id')
                        ->where('tag_product_feature.tagId', '=', $data->id)
                        ->orderBy('sequence', 'ASC');
            $products = $query->get();
            //dd($details);
            $data->products = $products;
        }     
        //dd($datas); 
        $keyworddata=null; 
        $tagurl = $this->tagurl;
        return view('components.tag', compact('datas','keyworddata','tagurl'));
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

            $query = TagProduct::select('tag_product_feature.*','product.name AS productName',)
                        ->join('product', 'tag_product_feature.productId' ,'=', 'product.id')
                        ->where('tag_product_feature.tagId', '=', $data->id)
                        ->orderBy('sequence', 'ASC');
            $products = $query->get();
            //dd($details);
            $data->products = $products;
        }     
        $keyworddata=null; 
        $tagurl = $this->tagurl;
        return view('components.tag', compact('datas','keyworddata','tagurl'));
    }

    public function edit_tag(Request $request){
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

            $query = TagProduct::select('tag_product_feature.*','product.name AS productName',)
                        ->join('product', 'tag_product_feature.productId' ,'=', 'product.id')
                        ->where('tag_product_feature.tagId', '=', $data->id)
                        ->orderBy('sequence', 'ASC');
            $products = $query->get();
            //dd($details);
            $data->products = $products;
        }     
        //dd($datas); 

        $keyworddatas = TagKeyword::where('id',$request->id)->get();
        $keyworddata = $keyworddatas[0];

        $tagurl = $this->tagurl;
        return view('components.tag', compact('datas','keyworddata','tagurl'));
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

            $query = TagProduct::select('tag_product_feature.*','product.name AS productName',)
                        ->join('product', 'tag_product_feature.productId' ,'=', 'product.id')
                        ->where('tag_product_feature.tagId', '=', $data->id)
                        ->orderBy('sequence', 'ASC');
            $products = $query->get();
            //dd($details);
            $data->products = $products;
        }   
        $keyworddata=null;  
        $tagurl = $this->tagurl;
        return view('components.tag', compact('datas','keyworddata','tagurl'));
    }

    public function save_edit_tag(Request $request){
        $datas = TagKeyword::where('id',$request->id)->get();
        $data = $datas[0];
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

            $query = TagProduct::select('tag_product_feature.*','product.name AS productName',)
                        ->join('product', 'tag_product_feature.productId' ,'=', 'product.id')
                        ->where('tag_product_feature.tagId', '=', $data->id)
                        ->orderBy('sequence', 'ASC');
            $products = $query->get();
            //dd($details);
            $data->products = $products;
        }     
        $keyworddata=null;

        $tagurl = $this->tagurl;
        return view('components.tag', compact('datas','keyworddata','tagurl'));
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
        $data->productId = $request->productId;
        $data->categoryId = $request->categoryId;
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
        if ($data->property=="type") {
            $data->content = $request->typeContent;
        } else {
            $data->content = $request->txtContent;    
        }
        

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

    public function add_tag_product(Request $request){
        $keywordId = $request->keywordId;
        $datas = TagProduct::select('tag_product_feature.*')
                ->where('tag_product_feature.tagId', '=', $request->tagId)
                ->orderBy('sequence', 'ASC')
                ->get();  

        $query = TagDetails::select('tag_details.*' ,'store.name AS storeName')
            ->join('store', 'tag_details.storeId' ,'=', 'store.id')
            ->where('tag_details.tagId', '=', $keywordId); 
        $storelist = $query->get();

        return view('components.tag-add-product', compact('datas','keywordId','storelist'));
    }

    public function save_tag_product(Request $request){
        $data = new TagProduct();
        $data->tagId = $request->tagId;
        $data->productId = $request->productId;
        $data->sequence = $request->sequence;
        $data->save();      

        $details = TagProduct::select('tag_product_feature.*', 'product.name AS productName')
                ->join('product', 'tag_product_feature.productId' ,'=', 'product.id')
                ->where('tag_product_feature.tagId', '=', $request->tagId)
                ->orderBy('sequence', 'ASC')
                ->get();  
        return response()->json(array('productList'=> $details), 200);
    }


    public function query_tag_product(Request $req){
       
        //find details
        
        $details = TagProduct::select('tag_product_feature.*', 'product.name AS productName')
                ->join('product', 'tag_product_feature.productId' ,'=', 'product.id')
                ->where('tag_product_feature.tagId', '=', $req->keywordId)
                ->orderBy('sequence', 'ASC')
                ->get();  
       // dd($details);      
        return response()->json(array('productList'=> $details), 200); 

    }


     public function deletemultiple_tag_product(Request $request){
        $ids = $request->ids;
        foreach ($ids as $id) {
            DB::connection('mysql2')->delete("DELETE FROM tag_product_feature WHERE id='".$id."'");
        
        }
        
        //find details
        $details = TagProduct::select('tag_product_feature.*', 'product.name AS productName')
                ->join('product', 'tag_product_feature.productId' ,'=', 'product.id')
                ->where('tag_product_feature.tagId', '=', $request->keywordId)
                ->orderBy('sequence', 'ASC')
                ->get(); 
        return response()->json(array('productList'=> $details), 200); 
        
    }


    public function filter_tag_product(Request $req){
        
       $sql="SELECT A.*, B.name as storeName, B.city AS storeCity, C.name as category, D.sequence, E.name AS parentcategory
                    FROM product A 
                        INNER JOIN store B ON A.storeId=B.id 
                        INNER JOIN store_category C ON A.categoryId=C.id
                        LEFT JOIN tag_product_feature D ON D.productId=A.id AND D.tagId=".$req->tagId."
                        LEFT JOIN store_category E ON C.parentCategoryId=E.id
                    WHERE A.id IS NOT NULL ";
        if ($req->store_name<>"") {
            $sql .= "AND B.name like '%".$req->store_name."%'";    
        }
        if ($req->product_name<>"") {
            $sql .= "AND A.name like '%".$req->product_name."%'";    
        }
        if ($req->selectCategory<>"") {
            $sql .= "AND C.parentCategoryId = '".$req->selectCategory."'";    
        }
        if ($req->locationId<>"" && $req->locationId<>"main") {
            $sql .= "AND B.city = '".$req->locationId."'";    
        }
        //echo $sql;
        $searchresult = DB::connection('mysql2')->select($sql);
        return response()->json(array('productList'=> $searchresult), 200);        

    }
}