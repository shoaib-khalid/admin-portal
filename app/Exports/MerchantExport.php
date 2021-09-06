<?php

namespace App\Exports;

use App\Models\Client;
use App\Models\PaymentDetail as Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MerchantExport implements FromCollection, ShouldAutoSize, WithHeadings
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
        $datas = Client::whereBetween('client.created', [$this->from, $this->to])
                        ->where('client.roleId', 'STORE_OWNER')
                        ->leftJoin('client_payment_detail as bank', 'bank.clientId', '=', 'client.id')
                        ->orderBy('created', 'ASC')
                        ->get();

        $newArray = array();

        foreach ($datas as $data) {

            $cur_item = array();

            array_push( 
                $cur_item,
                $data['username'], 
                $data['email'],
                $data['bankName'],
                $data['bankAccountNumber'],
                $data['bankAccountTitle']
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
            'Merchant',
            'Email',
            'Bank Name',
            'Account No',
            'Account Name',
        ];
    }
}
