<?php

namespace App\Exports;

use App\Models\Client;
use App\Models\PaymentDetail as Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Carbon\Carbon;
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
        $datas = Client::leftJoin('client_payment_detail as bank', 'bank.clientId', '=', 'client.id')
                        ->where('client.roleId', 'STORE_OWNER')
                        ->whereBetween('client.created', [$this->from, $this->to])
                        ->orderBy('client.created', 'DESC')
                        ->select('client.*', 'bank.bankName', 'bank.bankAccountNumber', 'bank.bankAccountTitle')
                        ->get();

// SELECT * FROM client AS a LEFT JOIN client_payment_detail AS bank ON bank.clientId=a.id WHERE a.created BETWEEN "2021-08-01" AND "2021-08-31" and a.roleId = "STORE_OWNER" order BY a.created DESC

        $newArray = array();

        foreach ($datas as $data) {

            $cur_item = array();

            array_push( 
                $cur_item,
                Carbon::parse($data['created'])->format('d/m/Y'),
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

        // dd($newArray);
        // die();
        
        return new Collection($newArray);
    }

    public function headings(): array
    {
        return [
            'Created At',
            'Merchant',
            'Email',
            'Bank Name',
            'Account No',
            'Account Name',
        ];
    }
}
