<?php

namespace App\Exports;

use App\Models\Refund;
use App\Models\PaymentDetail as Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserActivitySummaryExportDate implements FromCollection, ShouldAutoSize, WithHeadings
{

    protected $datas;
    protected $req;

    function __construct($datas, $req) {
            $this->datas = $datas;
            $this->req = $req;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
      
        $newArray = array();

        foreach ($this->datas as $data) {

            $cur_item = array();

            array_push( $cur_item, $data->dt);

            if ($this->req->groupstore<>"") { 
                array_push( $cur_item,  $data->storeName);
            }
            if ($this->req->groupdevice<>"") {
                array_push( $cur_item,  $data->device);
            }
            if ($this->req->groupos<>"") {
                array_push( $cur_item,  $data->os);
            }
            if ($this->req->groupbrowser<>"") { 
                array_push( $cur_item,  $data->browser);
            } 
            if ($this->req->grouppage<>"") {
                array_push( $cur_item,  $data->page);
            }

            array_push( $cur_item,$data->total);
            array_push( $cur_item,$data->totalUnique);
          
            $newArray[] = $cur_item;

        }
        
      
        // Array Format
        // return new Collection([
        //     [1, 2, 3],
        //     [4, 5, 6]
        // ]);

        //dd($newArray);
        // die();
        
        return new Collection($newArray);
    }

    public function headings(): array
    {
        $headers = array();  

        array_push( $headers,  'Date');

        if ($this->req->groupstore<>"") { 
            array_push( $headers,  'Store');
        }
        if ($this->req->groupdevice<>"") {
            array_push( $headers,  'Device');
        }
        if ($this->req->groupos<>"") {
            array_push( $headers,  'OS');
        }
        if ($this->req->groupbrowser<>"") { 
            array_push( $headers,  'Browser');
        } 
        if ($this->req->grouppage<>"") {
            array_push( $headers,  'Page');
        }
        array_push( $headers, 'Total Hits');
        array_push( $headers, 'Total Unique User');
        return $headers;
    }
}
