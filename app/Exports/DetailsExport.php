<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DetailsExport implements FromCollection, ShouldAutoSize, WithHeadings
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

        $request = Http::withToken('accessToken')->get('https://api.symplified.it/report-service/v1/store/null/report/detailedDailySales', [
            'startDate' => $this->from,
            'endDate' => $this->to,
            'sortingOrder' => "DESC",
            'pageSize' => 1000
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
                    $item['storeName'], 
                    $item['customerName'],
                    $item['subTotal'],
                    $item['serviceCharge'],
                    $item['deliveryCharge'],
                    $item['commission'],
                    $item['total'],
                    $item['orderStatus'],
                    $item['deliveryStatus'],
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

    public function headings(): array
    {
        return [
            'Date',
            'Store Name',
            'Customer Name',
            'Sub Total',
            'Service Charge',
            'Delivery Charge',
            'Commision',
            'Total',
            'Order Status',
            'Delivery Status',
        ];
    }
}

