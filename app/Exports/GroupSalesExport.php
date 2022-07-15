<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GroupSalesExport implements FromCollection, ShouldAutoSize, WithHeadings
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

         $request = Http::withToken('accessToken')->get('https://api.symplified.biz/report-service/v1/store/null/orderGroupList', [
            'from' => $this->from,
            'to' =>$this->to,
            'sortBy' => 'created',            
            'sortingOrder' => "DESC",
            'pageSize' => 1000
        ]); 
        
        // $posts = Http::get('https://api.symplified.biz/report-service/v1/store/null/report/detailedDailySales?startDate=2021-07-1&endDate=2021-08-16')->json();
        if($request->successful()){

            $result = $request['data'];

        }

        $datas = $result['content'];


        $newArray = array();
        
       // dd($datas);
        foreach($datas as $data){
           

                $cur_item = array();

                $totalComm = 0;
                $storeName='';
                $orderStatus='';
                foreach ($data['orderList'] as $order) {
                    $totalComm = $totalComm + $order['klCommission'];
                    if ($storeName=='')
                        $storeName = $order['store']['name'];
                    else
                        $storeName = $storeName . ", " .$order['store']['name'];

                     if ($orderStatus=='')
                        $orderStatus = $order['completionStatus'];
                    else
                        $orderStatus = $orderStatus . ", " .$order['completionStatus'];
                }



                
                array_push( 
                    $cur_item,
                    $data['created'],
                    $data['customer']['name'], 
                    $storeName,
                    $data['subTotal'],
                    $data['appliedDiscount'],
                    $data['serviceCharges'],
                    $data['deliveryCharges'],
                    $data['deliveryDiscount'],
                    $data['platformVoucherDiscount'],
                    $totalComm,
                    $data['total'],
                    $data['paymentStatus'],
                    $orderStatus,
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
            'Customer Name',
            'Store Name',
            'Sub Total',
            'Applied Discount',
            'Service Charge',
            'Delivery Charge',
            'Delivery Discount',
            'Platform Voucher Discount',
            'Commision',
            'Total',
            'Payment Status',
            'Order Status',
        ];
    }
}

