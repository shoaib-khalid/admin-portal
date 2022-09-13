<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Store;
use App\Models\Order;
use App\Models\Customer;

use DB;
use Carbon\Carbon;
use DateTime;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserIncompleteOrderExport implements FromCollection, ShouldAutoSize, WithHeadings
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

        $datas1 = Order::select('order.*', 'store.name AS storeName', 'customer.name AS customerName')
                        ->join('store AS store', 'order.storeId', 'store.id')
                        ->join('customer AS customer', 'order.customerId', 'customer.id')
                        ->where([
                            ['completionStatus','=','RECEIVED_AT_STORE'],
                            ['paymentStatus','<>','PAID'],
                            ['order.paymentType','=','ONLINEPAYMENT']
                        ])
                        ->whereBetween('order.created', [$this->from, $this->to." 23:59:59"]);

        $datas = Order::select('order.*', 'store.name AS storeName', 'customer.name AS customerName')
                        ->join('store AS store', 'order.storeId', 'store.id')
                        ->join('customer AS customer', 'order.customerId', 'customer.id')
                        ->where([
                            ['completionStatus','=','PAYMENT_FAILED'],
                        ])
                        ->whereBetween('order.created', [$this->from, $this->to." 23:59:59"])
                        ->union($datas1)
                        ->get();
             
        $newArray = array();

        foreach ($datas as $data) {
            $cur_item = array();

            array_push( 
                $cur_item,
                $data['created'],
                $data['storeName'],
                $data['customerName'],
                $data['total'],
                $data['paymentType'],
                $data['paymentStatus'],
                $data['completionStatus']
            );

            $newArray[] = $cur_item;
        }
        return new Collection($newArray);
    }

    public function headings(): array
    {
        return [
            'Created',
            'Store',
            'Customer',
            'Total',
            'Payment Type',
            'Payment Status',
            'Completion Status',
        ];
    }
}