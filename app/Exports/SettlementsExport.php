<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SettlementsExport implements FromCollection, ShouldAutoSize, WithHeadings
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

        // $request = Http::withToken('accessToken')->get('https://api.symplified.biz/report-service/v1/store/null/report/detailedDailySales', [
        //     'startDate' => $this->from,
        //     'endDate' => $this->to,
        // ]); 

        $request = Http::withToken('accessToken')->get('https://api.symplified.biz/report-service/v1/store/null/settlement', [
            'from' => $this->from,
            'to' => $this->to,
            'sortingOrder' => "ASC",
        ]); 
        
        
        // $posts = Http::get('https://api.symplified.biz/report-service/v1/store/null/report/detailedDailySales?startDate=2021-07-1&endDate=2021-08-16')->json();
        if($request->successful()){

            $datas = $request['data']['content'];

        }


        $newArray = array();
        
        foreach($datas as $data){

            if ($data['totalTransactionValue'] != null) {
                $cur_item = array();

                array_push( 
                    $cur_item,
                    Carbon::parse($data['settlementDate'])->format('d/m/Y'),
                    $data['storeName'],
                    Carbon::parse($data['cycleStartDate'])->format('d/m/Y'), 
                    Carbon::parse($data['cycleEndDate'])->format('d/m/Y'),
                    $data['totalServiceFee'],
                    $data['totalServiceFee'],
                    $data['totalServiceFee'],
                    $data['totalCommisionFee'],
                    $data['totalCommisionFee']
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
            'Payout Date',
            'Store Name',
            'Start Date',
            'Cutoff Date',
            'Gross Amount',
            'Service Charge',
            'Delivery Charge',
            'Commision',
            'Nett Amount',
        ];
    }
}
