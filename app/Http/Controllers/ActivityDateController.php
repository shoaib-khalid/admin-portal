<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use App\Models\User;
use App\Models\Client;
use App\Models\Cart;
use App\Models\PaymentDetail as Payment;
use App\Models\Store;
use App\Models\Customer;
use App\Models\Refund;
use App\Models\UserActivity;
use App\Models\StoreDeliveryDetail as StoreDelivery;
use Carbon\Carbon;
use DateTime;
use Session;

use App\Exports\UsersExport;
use App\Exports\DetailsExport;
use App\Exports\SettlementsExport;
use App\Exports\MerchantExport;
use App\Exports\PendingRefundExport;
use App\Exports\RefundHistoryExport;
use App\Exports\UserActivitySummaryExport;
use App\Exports\UserActivitySummaryExportDate;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;
 
use App\Mail\NotifyMail;
use App\Mail\EmailContent;

class ActivityDateController extends Controller
{

    protected $url;
    protected $token;

    function __construct() {
            $this->url = config('services.report_svc.url');
            $this->token = config('services.report_svc.token');
    }

    

    public function useractivitysummarydate(){

        $datas=array();
        $date = new DateTime('7 days ago');
        $datechosen = $date->format('F d, Y')." - ".date('F d, Y');  
        $storename=null;
        $device=null;
        $browser=null;
        $groupbrowser=null;
        $groupdevice=null;
        $groupos=null;
        $grouppage=null;
        $groupstore=null;
        $MYS=null;
        $PAK=null;

        return view('components.useractivitysummarydate', compact('datas','datechosen','storename','device','browser', 'groupstore','groupbrowser','groupdevice','groupos','grouppage','MYS','PAK'));        
    }
   

    public function filter_useractivitysummarydate(Request $req){

       // echo "excel:".$req->exportExcel;

        $date = new DateTime('7 days ago');

        $data = $req->input();

        $dateRange = explode( '-', $req->date_chosen4 );
        $start_date = $dateRange[0];
        $end_date = $dateRange[1];

        $start_date = date("Y-m-d", strtotime($start_date));
        $end_date = date("Y-m-d", strtotime($end_date));

        $selectedCountry = $req->region;
        Session::put('selectedCountry', $selectedCountry);

        $groupList="SUM(totalCount) AS total, SUM(totalUniqueUser) AS totalUnique, dt"; 

        $where="";

        if($req->region == "ALL"){
            $where= "AND page IS NOT NULL";
          }

        if($req->region == "MYS"){
         $where= "AND (page like '%deliverin.my%' OR page like '%dev-my%') ";

        //     // $where = UserActivity::where('pageVisited', 'like', '%dev-my%')->get();
          }
        if($req->region == "PAK"){
            $where = "AND (page like '%easydukan.co%' OR page like '%dev-pk%') ";
        //     // $where = UserActivity::where('pageVisited', 'like', '%dev-my%')->get();
         }

        $groupBy="dt "; 
        if ($req->groupstore<>"") {
            $groupList .= " , storeId";
            if ($groupBy=="")
                $groupBy .= " storeId";
            else
                $groupBy .= " , storeId";
        }      
        if ($req->groupbrowser<>"") {
            $groupList .= " , browser";
            if ($groupBy=="")
                $groupBy .= " browser";
            else
                $groupBy .= " , browser";
        }
        if ($req->groupdevice<>"") {
            $groupList .= " , device";
            if ($groupBy=="")
                $groupBy .= " device";
            else
                $groupBy .= " , device";
        }
        if ($req->groupos<>"") {
            $groupList .= " , os";
            if ($groupBy=="")
                $groupBy .= " os";
            else
                $groupBy .= " , os";
        }
        if ($req->grouppage<>"") {
            $groupList .= " , page";
            if ($groupBy=="")
                $groupBy .= " page";
            else
                $groupBy .= " , page";
        }

        //query group by sessionId
        $sql="SELECT ".$groupList." FROM customer_activities_summary WHERE dt BETWEEN '".$start_date."' AND '".$end_date." 23:59:59'";
        //dd($sql);


        if ($req->storename_chosen<>"") {
            $search_store_info = Store::where('name', 'like',  '%'.$req->storename_chosen.'%' )->get(); 
            $search_storeId_list = array();  
            $commaList="";      
            if (count($search_store_info) > 0) {
               foreach ($search_store_info as $storefound) {
                    if ($commaList=="") 
                        $commaList = "'".$storefound['id']."'";
                    else
                        $commaList .= ",'".$storefound['id']."'";                    
               }
            }  
            $sql .= " AND storeId IN (".$commaList.")";
        }
        

        if ($req->device_chosen<>"") {
            $sql .= " AND device = ".$req->device_chosen;            
        }
        if ($req->browser_chosen<>"") {
            $sql .= " AND browser = ".$req->browser_chosen;            
        }

     
        $sql .= $where;
        $sql .= " GROUP BY ".$groupBy." ORDER BY dt";
    // dd($sql);
        $datas = DB::connection('mysql3')->select($sql);

        if ($req->groupstore<>"") {
            $storeList=array();
            $newArray = array();        
            foreach ($datas as $data) {    
                $storeName = '';
                if (! array_key_exists($data->storeId, $storeList)) {
                    $store_info = Store::where('id', $data->storeId)
                                        ->get();
                    if (count($store_info) > 0) {
                        $storeList[$data->storeId] = $store_info[0]['name']; 
                        $storeName = $storeList[$data->storeId];
                    }    

                } else {
                    $storeName = $storeList[$data->storeId];
                }
                
                $data->storeName =  $storeName;
                $object = $data;

                array_push( 
                    $newArray,
                    $object
                );

            }           

            $datas = $newArray;
            //dd($datas);
        }

        if ($req->groupstore=="" && $req->groupbrowser=="" && $req->groupdevice=="" && $req->groupos=="" && $req->grouppage=="") {
            $sql2="SELECT SUM(totalUnique), SUM(totalUniqueGuest), dt FROM total_unique_user_overall WHERE dt BETWEEN '".$start_date."' AND '".$end_date." 23:59:59' GROUP BY dt";
        } else {
            $sql2="SELECT totalUnique, totalUniqueGuest, storeId, dt FROM total_unique_user WHERE dt BETWEEN '".$start_date."' AND '".$end_date." 23:59:59'";
        }
        
        // $sql2 = $where;
        $newArray2 = array();   
        foreach ($datas as $data) { 
            if (property_exists($data, 'storeId')) {
                 $sql2="SELECT totalUnique, totalUniqueGuest, storeId, dt FROM total_unique_user WHERE dt='".$data->dt."' AND storeId='".$data->storeId."'";
                 $datas2 = DB::connection('mysql3')->select($sql2);
                 if (count($datas2)>0) {
                    $data->totalUser =  $datas2[0]->totalUnique;   
                    $data->totalGuest =  $datas2[0]->totalUniqueGuest;   
                 }  else {
                    $data->totalUser =  0;
                    $data->totalGuest =  0;
                 }
            } else {
                $sql2="SELECT SUM(totalUnique) AS totalUnique, SUM(totalUniqueGuest) AS totalUniqueGuest FROM total_unique_user_overall WHERE dt='".$data->dt."'";
                 $datas2 = DB::connection('mysql3')->select($sql2);
                 if (count($datas2)>0) {
                    $data->totalUser =  $datas2[0]->totalUnique;
                    $data->totalGuest =  $datas2[0]->totalUniqueGuest;        
                 } 
                 else{
                    $data->totalUser =  0;
                    $data->totalGuest =  0;
                 }
            }
            
            $object = $data;

            array_push( 
                $newArray2,
                $object
            );
        }
        $datas = $newArray2;
        //dd($datas);
       

        $groupstore=$req->groupstore;
        $groupbrowser=$req->groupbrowser;
        $groupdevice=$req->groupdevice;
        $groupos=$req->groupos;
        $grouppage=$req->grouppage;

        $datechosen = $req->date_chosen4;                
        $storename = $req->storename_chosen;
        $device = $req->device_chosen;
        $browser = $req->browser_chosen;
        $MYS = $req->MYS;
        $PAK = $req->PAK;


        if ($req->exportExcel==1) {
             return Excel::download(new UserActivitySummaryExportDate($datas, $req), 'CustomerSummaryByDate.xlsx');
         } else {
            return view('components.useractivitysummarydate', compact('datas','datechosen','storename','device','browser','groupstore','groupbrowser','groupdevice','groupos','grouppage','MYS','PAK'));    
         }
        
    }    

}