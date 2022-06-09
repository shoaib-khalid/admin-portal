<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use App\Models\FeaturedLocation;
use Carbon\Carbon;
use DateTime;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Mail;
 
use App\Mail\NotifyMail;
use App\Mail\EmailContent;

class FeaturedLocationController extends Controller
{

    protected $url;
    protected $token;

    function __construct() {
            $this->url = config('services.report_svc.url');
            $this->token = config('services.report_svc.token');
    }


    public function index(){
        
        $datas = FeaturedLocation::select('location_config.*','city.name AS cityName')
                    ->join('region_city as city', 'cityId', '=', 'city.id')->orderBy('sequence', 'ASC')->get();        
        
        return view('components.featuredlocation', compact('datas'));
    }

    

    public function edit_featuredlocation(Request $request){

        

        $datalist = FeaturedLocation::where('id',$request->id)->get();
        $data = $datalist[0];
        $data->sequence = $request->sequence;
        $data->save();
        
        $datas = FeaturedLocation::select('location_config.*','city.name AS cityName')
                    ->join('region_city as city', 'cityId', '=', 'city.id')->orderBy('sequence', 'ASC')->get();        
        
        
        
        return view('components.featuredlocation', compact('datas'));
    }



}