<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, ShouldAutoSize, WithHeadings
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

        $request = Http::withToken('accessToken')->get('https://api.symplified.biz/report-service/v1/store/null/daily_sales', [
            'from' => $this->from,
            'to' => $this->to,
            'sortingOrder' => "DESC",
        ]); 
        
        // $posts = Http::get('https://api.symplified.biz/report-service/v1/store/null/report/detailedDailySales?startDate=2021-07-1&endDate=2021-08-16')->json();
        if($request->successful()){

            $datas = $request['data']['content'];

        }


        $newArray = array();
        
        foreach($datas as $data){
            $cur_item = array();

            array_push( 
                $cur_item,
                $data['date'],
                $data['store']['name'],
                $data['totalOrders'], 
                $data['amountEarned']
            );

            $newArray[] = $cur_item;
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
            'Total Order',
            'Amount Earned',
        ];
    }
}
