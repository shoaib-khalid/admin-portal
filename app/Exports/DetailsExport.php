<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class DetailsExport implements FromCollection
{
    protected $from;
    protected $to;

    function __construct($from, $to) {
            $this->from = $from;
            $this->to = $to;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return User::all();

        $request = Http::withToken('accessToken')->get('https://api.symplified.biz/report-service/v1/store/null/report/detailedDailySales', [
            'startDate' => $this->from,
            'endDate' => $this->to,
            'sortingOrder' => "DESC",
        ]); 
        
        // $posts = Http::get('https://api.symplified.biz/report-service/v1/store/null/report/detailedDailySales?startDate=2021-07-1&endDate=2021-08-16')->json();
        if($request->successful()){

            $datas = $request['data'];

        }


        $newArray = array();
        
        foreach($datas as $data){
            $date = $data['date'];

            foreach($data['sales'] as $item){

                $cur_item = array();

                array_push( 
                    $cur_item,
                    $data['date'],
                    $item['storeId'], 
                    $item['merchantName'],
                    $item['storeName'],
                    $item['subTotal'],
                    $item['total'],
                    $item['serviceCharge'],
                    $item['deliveryCharge'],
                    $item['customerName'],
                    $item['orderStatus'],
                    $item['deliveryStatus'],
                    $item['commission']
                );

                $newArray[] = $cur_item;
            }
        }

        // Array Format
        // return new Collection([
        //     [1, 2, 3],
        //     [4, 5, 6]
        // ]);
        
        return new Collection($newArray);
    }
}

