<?php

namespace App\Exports;

use App\Models\Refund;
use App\Models\PaymentDetail as Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PendingRefundExport implements FromCollection, ShouldAutoSize, WithHeadings
{

    protected $from;
    protected $to;

    function __construct($from, $to) {
            $this->from = $from;
            $this->to = $to;
    }

    function convertRefundType($type) {
        if ($type=="ITEM_REVISED")
            return "PARTIAL REFUND";
        elseif ($type=="ITEM_CANCELLED")
            return "PARTIAL REFUND";
        else
            return $type;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
       $datas = Refund::select('orderId','invoiceId', 'store.name AS storeName', 'customer.name AS customerName', 'refundType','refundAmount','paymentChannel','refundStatus','remarks')
                        ->join('order as order', 'order_refund.orderId', '=', 'order.id')
                        ->join('customer as customer', 'order.customerId', '=', 'customer.id')
                        ->join('store as store', 'order.storeId', '=', 'store.id')
                        ->whereBetween('order_refund.created', [$this->from, $this->to])
                        ->where('refundStatus', '=', 'PENDING')                       
                        ->orderBy('order_refund.created', 'ASC')
                        ->get();

        $newArray = array();

        foreach ($datas as $data) {

            $cur_item = array();

            array_push( 
                $cur_item,
                 Carbon::parse($data['created'])->format('d/m/Y'),
                    $data['invoiceId'], 
                    $data['storeName'],
                    $data['customerName'], 
                    $this->convertRefundType($data['refundType']), 
                    $data['refundAmount'], 
                    $data['paymentChannel'], 
                    $data['refundStatus'], 
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
            'Date Created',
            'Store Name',
            'Customer Name',
            'Refund Type',
            'Refund Amount',
            'Payment Channel',
            'Refund Status',
            'Done Date',
            'Remarks'
        ];
    }
}
