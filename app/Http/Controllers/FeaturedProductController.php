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
        
        $datas = FeaturedProduct::select('product_feature_config.*','product.name AS productName','store.name AS storeName', 'store_category.name AS category')
                    ->join('product as product', 'productId', '=', 'product.id')
                    ->join('store_category as store_category', 'categoryId', '=', 'store_category.id')
                    ->join('store as store', 'product.storeId', '=', 'store.id')
                    ->get();        
        $searchresult=array();
        return view('components.featuredproduct', compact('datas','searchresult'));
    }

    public function filter_product(Request $req){

        $datas = FeaturedProduct::select('product_feature_config.*','product.name AS productName','store.name AS storeName', 'store_category.name AS category')
                    ->join('product as product', 'productId', '=', 'product.id')
                    ->join('store_category as store_category', 'categoryId', '=', 'store_category.id')
                    ->join('store as store', 'product.storeId', '=', 'store.id')
                    ->get();

        $sql="SELECT A.*, B.name as storeName, C.name as category
                    FROM product A 
                        INNER JOIN store B ON A.storeId=B.id 
                        INNER JOIN store_category C ON A.categoryId=C.id
                    WHERE A.name like '%".$req->product_name."%'";
        $searchresult = DB::connection('mysql2')->select($sql);
       
        return view('components.featuredproduct', compact('datas','searchresult'));

    }

    public function add_featuredproduct(Request $request){
        $f = new FeaturedProduct();
        $f->productId = $request->id;
        $f->sequence = $request->sequence;
        $f->save();

        $datas = FeaturedProduct::select('product_feature_config.*','product.name AS productName','store.name AS storeName', 'store_category.name AS category')
                    ->join('product as product', 'productId', '=', 'product.id')
                    ->join('store_category as store_category', 'categoryId', '=', 'store_category.id')
                    ->join('store as store', 'product.storeId', '=', 'store.id')
                    ->get();
        $searchresult=array();

        return view('components.featuredproduct', compact('datas','searchresult'));
    }

    public function edit_featuredproduct(Request $request){
        $datalist = FeaturedProduct::where('id',$request->id)->get();
        $data = $datalist[0];
        $data->sequence = $request->sequence;
        $data->save();
               
        $datas = FeaturedProduct::select('product_feature_config.*','product.name AS productName','store.name AS storeName', 'store_category.name AS category')
                    ->join('product as product', 'productId', '=', 'product.id')
                    ->join('store_category as store_category', 'categoryId', '=', 'store_category.id')
                    ->join('store as store', 'product.storeId', '=', 'store.id')
                    ->get();
        $searchresult=array();

        return view('components.featuredproduct',compact('datas','searchresult'));
    }

     public function delete_featuredproduct(Request $request){
        DB::connection('mysql2')->delete("DELETE FROM product_feature_config WHERE id='".$request->id."'");
        $datas = FeaturedProduct::select('product_feature_config.*','product.name AS productName','store.name AS storeName', 'store_category.name AS category')
                    ->join('product as product', 'productId', '=', 'product.id')
                    ->join('store_category as store_category', 'categoryId', '=', 'store_category.id')
                    ->join('store as store', 'product.storeId', '=', 'store.id')
                    ->get();
        $searchresult=array();
        return view('components.featuredproduct', compact('datas','searchresult'));
        
    }




}