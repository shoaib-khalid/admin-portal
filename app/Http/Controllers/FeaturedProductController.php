<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use App\Models\FeaturedProduct;
use Carbon\Carbon;
use DateTime;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Mail;
 
use App\Mail\NotifyMail;
use App\Mail\EmailContent;

class FeaturedProductController extends Controller
{

    protected $url;
    protected $token;

    function __construct() {
            $this->url = config('services.report_svc.url');
            $this->token = config('services.report_svc.token');
    }


    public function index(){
        
        $datas = FeaturedProduct::select('product_feature_config.*','product.name AS productName','store.name AS storeName',  'store.city AS storeCity','store_category.name AS category', 'parent_category.name AS parentcategory')
                    ->join('product as product', 'productId', '=', 'product.id')
                    ->join('store_category as store_category', 'categoryId', '=', 'store_category.id')
                    ->join('store as store', 'product.storeId', '=', 'store.id')
                    ->leftJoin('store_category as parent_category', 'store_category.parentCategoryId', '=', 'store_category.id')
                    ->orderBy('sequence', 'ASC')->get();     

        $sql="SELECT id, name, verticalCode FROM store_category WHERE verticalCode IS NOT NULL";
        $categorylist = DB::connection('mysql2')->select($sql);

        $sql="SELECT cityId FROM location_config";
        $locationlist = DB::connection('mysql2')->select($sql);

        $searchresult=array();
        $product_name = "";
        $store_name = "";
        $categoryselected="";
        $locationselected="";

        return view('components.featuredproduct', compact('datas','searchresult','product_name', 'store_name','categorylist','categoryselected', 'locationlist', 'locationselected'));
    }

    public function filter_product(Request $req){

        $datas = FeaturedProduct::select('product_feature_config.*','product.name AS productName','store.name AS storeName', 'store_category.name AS category', 'parent_category.name AS parentcategory')
                    ->join('product as product', 'productId', '=', 'product.id')
                    ->join('store_category as store_category', 'categoryId', '=', 'store_category.id')
                    ->join('store as store', 'product.storeId', '=', 'store.id')
                    ->leftJoin('store_category as parent_category', 'store_category.parentCategoryId', '=', 'store_category.id')
                    ->orderBy('sequence', 'ASC')->get();            

        $sql="SELECT id, name, verticalCode FROM store_category WHERE verticalCode IS NOT NULL";
        $categorylist = DB::connection('mysql2')->select($sql);

        $sql="SELECT A.*, B.name as storeName, C.name as category, D.sequence, E.name AS parentcategory
                    FROM product A 
                        INNER JOIN store B ON A.storeId=B.id 
                        INNER JOIN store_category C ON A.categoryId=C.id
                        LEFT JOIN product_feature_config D ON D.productId=A.id
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
        //echo $sql;
        $searchresult = DB::connection('mysql2')->select($sql);
        $product_name = $req->product_name;
        $store_name = $req->store_name;
        $categoryselected= $req->selectCategory;

        return view('components.featuredproduct', compact('datas','searchresult', 'product_name', 'store_name', 'categorylist','categoryselected'));

    }

    public function add_featuredproduct(Request $request){
        $f = new FeaturedProduct();
        $f->productId = $request->id;
        $f->sequence = $request->sequence;
        $f->save();

         $datas = FeaturedProduct::select('product_feature_config.*','product.name AS productName','store.name AS storeName', 'store_category.name AS category', 'parent_category.name AS parentcategory')
                    ->join('product as product', 'productId', '=', 'product.id')
                    ->join('store_category as store_category', 'categoryId', '=', 'store_category.id')
                    ->join('store as store', 'product.storeId', '=', 'store.id')
                    ->leftJoin('store_category as parent_category', 'store_category.parentCategoryId', '=', 'store_category.id')
                    ->orderBy('sequence', 'ASC')->get();   
         
        $sql="SELECT id, name, verticalCode FROM store_category WHERE verticalCode IS NOT NULL";
        $categorylist = DB::connection('mysql2')->select($sql);

        $searchresult=array();
        $product_name = null;
        $store_name = null;
        $categoryselected="";

        return view('components.featuredproduct', compact('datas','searchresult', 'product_name', 'store_name', 'categorylist','categoryselected'));
    }

    public function edit_featuredproduct(Request $request){
        $datalist = FeaturedProduct::where('id',$request->id)->get();
        $data = $datalist[0];
        $data->sequence = $request->sequence;
        $data->save();
               
        $datas = FeaturedProduct::select('product_feature_config.*','product.name AS productName','store.name AS storeName', 'store_category.name AS category', 'parent_category.name AS parentcategory')
                    ->join('product as product', 'productId', '=', 'product.id')
                    ->join('store_category as store_category', 'categoryId', '=', 'store_category.id')
                    ->join('store as store', 'product.storeId', '=', 'store.id')
                    ->leftJoin('store_category as parent_category', 'store_category.parentCategoryId', '=', 'store_category.id')
                    ->orderBy('sequence', 'ASC')->get();   

        $sql="SELECT id, name, verticalCode FROM store_category WHERE verticalCode IS NOT NULL";
        $categorylist = DB::connection('mysql2')->select($sql);

        $searchresult=array();
        $product_name = null;
        $store_name = null;
        $categoryselected="";

        return view('components.featuredproduct', compact('datas','searchresult', 'product_name', 'store_name', 'categorylist','categoryselected'));
    }

     public function delete_featuredproduct(Request $request){
        DB::connection('mysql2')->delete("DELETE FROM product_feature_config WHERE id='".$request->id."'");
        $datas = FeaturedProduct::select('product_feature_config.*','product.name AS productName','store.name AS storeName', 'store_category.name AS category', 'parent_category.name AS parentcategory')
                    ->join('product as product', 'productId', '=', 'product.id')
                    ->join('store_category as store_category', 'categoryId', '=', 'store_category.id')
                    ->join('store as store', 'product.storeId', '=', 'store.id')
                    ->leftJoin('store_category as parent_category', 'store_category.parentCategoryId', '=', 'store_category.id')
                    ->orderBy('sequence', 'ASC')->get();        

        $sql="SELECT id, name, verticalCode FROM store_category WHERE verticalCode IS NOT NULL";
        $categorylist = DB::connection('mysql2')->select($sql);

        $searchresult=array();
        $product_name = null;
        $store_name = null;
        $categoryselected="";
        
        return view('components.featuredproduct', compact('datas','searchresult', 'product_name', 'store_name', 'categorylist','categoryselected'));
        
    }




}