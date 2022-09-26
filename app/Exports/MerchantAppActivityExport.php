<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Client;
use App\Models\Cart;
use App\Models\Store;
use App\Models\Customer;
use App\Models\UserActivity;
use App\Models\StoreDeliveryDetail as StoreDelivery;

use DB;
use Session;
use Carbon\Carbon;
use DateTime;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MerchantAppActivityExport implements FromCollection, ShouldAutoSize, WithHeadings
{

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //query by Customer
        $selectedCountry = Session::get('selectedCountry');
          if($selectedCountry == 'MYS') {
          $datas = Client::select('client.*')
                        ->where('roleId', 'STORE_OWNER')
                        ->where('countryId', '=', 'MYS')
                        ->whereNotNull('mobilePingLastResponse')
                        ->orderBy('mobilePingLastResponse','DESC')
                        ->get();  
        }
           if($selectedCountry == 'PAK') {
           $datas = Client::select('client.*')
                            ->where('roleId', 'STORE_OWNER')
                            ->where('countryId', '=', 'PAK')
                            ->whereNotNull('mobilePingLastResponse')
                            ->orderBy('mobilePingLastResponse','DESC')
                            ->get();  
        }
                //dd($datas);
        foreach ($datas as $data) {
        
            //Get merchant app's status
            $sql="SELECT id, mobilePingLastResponse, mobilePingTxnId FROM client WHERE id='".$data->id."'ORDER BY created DESC LIMIT 1";
            $appstatus = DB::connection('mysql2')->select($sql);
            $lastseen = $appstatus[0]->mobilePingLastResponse;
            $pingtxn = $appstatus[0]->mobilePingTxnId;
            // If mobile ping last is more than 60 mins
            $pingtime = strtotime($lastseen);
            if($pingtime<60){
                $merchantstatus="Online";
            }else {
                $merchantstatus="Offline";
            }
            $data->AppStatus = $merchantstatus;
            $data->LastSeen = $lastseen;
        
            //Get store closing time
            $sql="SELECT A.id, GROUP_CONCAT(day) AS day, clientId FROM store A INNER JOIN store_timing B ON A.id=B.storeId WHERE isOff='1' AND clientId = '".$data->id."' GROUP BY storeId";
            $closingtime = DB::connection('mysql2')->select($sql);
            //dd($sql);
            if (count($closingtime) > 0) {
                $closing=$closingtime[0]->day;
            } else{
                $closing= "";
            }
            $data->CloseTime = $closing;
        
        }        
            $newArray = array();
        
                    foreach ($datas as $data) {
            
                        $cur_item = array();
            
                        array_push( 
                            $cur_item,
                             Carbon::parse($data['created'])->format('d/m/Y'),
                                     $data['name'], 
                                     $data['LastSeen'],
                                     $data['CloseTime'],
                        );
            
                        $newArray[] = $cur_item;
            
                    }
                return new Collection($newArray);
        
    }

    public function headings(): array
    {
        return [
            'Registered Date ID',
            'Client Name',
            'Last Seen',
            'Closing Date',
        ];
    }
}
