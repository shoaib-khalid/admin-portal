<?php

namespace App\Exports;

use App\Models\Settlement;
use App\Models\PaymentDetail as Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Settlement2Export implements FromCollection, ShouldAutoSize, WithHeadings
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

        $datas = Settlement::whereBetween('settlementDate', [$this->from, $this->to." 23:59:59"])  
                        ->orderBy('settlementDate', 'DESC')
                        ->get();
                                        
        $newArray = array();

        foreach ($datas as $data) {

            $cur_item = array();

            array_push( 
                $cur_item,
                Carbon::parse($data['settlementDate'])->format('d/m/Y'),
                $data['storeName'],
                Carbon::parse($data['cycleStartDate'])->format('d/m/Y'), 
                Carbon::parse($data['cycleEndDate'])->format('d/m/Y'),
                $data['totalTransactionValue'],
                $data['totalServiceFee'],
                $data['totalDeliveryFee'],
                $data['totalCommisionFee'],
                $data['totalStoreShare'],
                $data['remarks']
            );

            $newArray[] = $cur_item;

        }
        
      
        // Array Format
        // return new Collection([
        //     [1, 2, 3],
        //     [4, 5, 6]
        // ]);

        // dd($newArray);
        // die();
        
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
            'Remarks'
        ];
    }
}
