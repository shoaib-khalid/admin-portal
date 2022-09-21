<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use App\Models\StoreCategory;
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

class ParentCategoryController extends Controller
{

    protected $url;
    protected $token;

    protected $baseurl;
    protected $basepreviewurl;
    protected $basepath;

    function __construct() {
            $this->baseurl = config('services.banner_svc.url');
            $this->basepreviewurl = config('services.banner_svc.previewurl');
            $this->basepath = config('services.banner_svc.path');
            $this->url = config('services.report_svc.url');
            $this->token = config('services.report_svc.token');
    }


    public function index(){  
        $selectedCountry = Session::get('selectedCountry');
        if($selectedCountry == 'MYS') {
        $datas = StoreCategory::select('store_category.*')
                    ->whereRaw('verticalCode IS NOT NULL')
                    ->where('verticalCode', '=', 'FnB')
                    ->orWhere('verticalCode', '=', 'E-Commerce')
                    ->orderBy('verticalCode', 'ASC')
                    ->orderBy('name', 'ASC')
                    ->get();   
        }
        if($selectedCountry == 'PAK') {
            $datas = StoreCategory::select('store_category.*')
                        ->whereRaw('verticalCode IS NOT NULL')
                        ->where('verticalCode', '=', 'FnB_PK')
                        ->orWhere('verticalCode', '=', 'ECommerce_PK')
                        ->orderBy('verticalCode', 'ASC')
                        ->orderBy('name', 'ASC')
                        ->get();   
        }
        $sql="SELECT code FROM region_vertical";
        $verticallist = DB::connection('mysql2')->select($sql);
        $basepreviewurl = $this->basepreviewurl;
        $MYS = '';
        return view('components.parentcategory', compact('datas','basepreviewurl','verticallist','MYS'));
    }

    public function filter_parentcategory(Request $request){   
        
        $data = $request->input();

        $selectedCountry = $request->region;
        Session::put('selectedCountry', $selectedCountry);

        $query = StoreCategory::select('store_category.*')
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
         
        $query->orderBy('name', 'ASC');
        $datas = $query->get();

        $sql="SELECT code FROM region_vertical";
        $verticallist = DB::connection('mysql2')->select($sql);
        $basepreviewurl = $this->basepreviewurl;
        // $MYS= $request->MYS;
        return view('components.parentcategory', compact('datas','basepreviewurl','verticallist'));
    }

    public function add_parentcategory(Request $request){
        //copy file to folder
        $file = $request->file('selectFile');
        $extension = $file->getClientOriginalExtension();
        //Move Uploaded File
        $newfilename = date("YmdHis").".".$extension;
        $destinationPath = $this->basepath;
        //echo " path:".$destinationPath;
        $file->move($destinationPath,$newfilename);
        $url = $this->baseurl."/".$newfilename;
        //echo " url:".$url;
        $cat = new StoreCategory();
        $cat->id = $this->clean($request->parentCategory).$request->selectVertical;
        $cat->name = $request->parentCategory;
        $cat->verticalCode = $request->selectVertical;
        $cat->thumbnailUrl = $url;
        $cat->save();

        $datas = StoreCategory::select('store_category.*')
                    ->whereRaw('verticalCode IS NOT NULL')
                    ->get();        
        $sql="SELECT code FROM region_vertical";
        $verticallist = DB::connection('mysql2')->select($sql);
        $basepreviewurl = $this->basepreviewurl;
        return view('components.parentcategory', compact('datas','basepreviewurl','verticallist'));
        
    }

    public function delete_parentcategory(Request $request){
        DB::connection('mysql2')->delete("DELETE FROM store_category WHERE id='".$request->id."'");

        $datas = StoreCategory::select('store_category.*')
                    ->whereRaw('verticalCode IS NOT NULL')
                    ->get();        
        $sql="SELECT code FROM region_vertical";
        $verticallist = DB::connection('mysql2')->select($sql);
        $basepreviewurl = $this->basepreviewurl;
        return view('components.parentcategory', compact('datas','basepreviewurl','verticallist'));

    }

    public function edit_parentcategory(Request $request){

        if ($request->file('selectFile')) {        
            //copy file to folder
            $file = $request->file('selectFile');
            $extension = $file->getClientOriginalExtension();
            //Move Uploaded File
            $newfilename = date("YmdHis").".".$extension;
            $destinationPath = $this->basepath;
            echo " path:".$destinationPath;
            $file->move($destinationPath,$newfilename);
            $url = $this->baseurl."/".$newfilename;
            echo " url:".$url;
            //exit;
        }

        $datalist = StoreCategory::where('id',$request->id)->get();
        $data = $datalist[0];
        if ($request->file('selectFile')) {
            $data->thumbnailUrl = $url;
        }
        $data->save();
        
        $datas = StoreCategory::select('store_category.*')
                    ->whereRaw('verticalCode IS NOT NULL')
                    ->get();        
        $sql="SELECT code FROM region_vertical";
        $verticallist = DB::connection('mysql2')->select($sql);
        $basepreviewurl = $this->basepreviewurl;
        return view('components.parentcategory', compact('datas','basepreviewurl','verticallist'));

    }    

    function clean($string) {
       $string = str_replace(' ', '', $string); // Replaces all spaces.

       return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

}