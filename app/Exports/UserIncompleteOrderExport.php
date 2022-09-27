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

         foreach ($datas as $data) {
                $sql="SELECT B.customerId, address, email, phoneNumber FROM `order_shipment_detail` A
                INNER JOIN `order` B ON A.orderId=B.id WHERE orderId='".$data->id."'";
                //dd($sql);
                $customerdetail = DB::connection('mysql2')->select($sql);
                if (count($customerdetail) > 0) {
                    $customernumber=$customerdetail[0]->phoneNumber;
                    $customeraddress=$customerdetail[0]->address;
                    $customeremail=$customerdetail[0]->email;
                }
                $data->phoneNumber= $customernumber;
                $data->address = $customeraddress;
                $data->email = $customeremail;

                //check if any item in cart
                $sql="SELECT productId, quantity, productName FROM `order_item` A INNER JOIN `order` B ON A.orderId=B.id 
                INNER JOIN order_group C ON B.orderGroupId=C.id WHERE orderId='".$data->id."' GROUP BY C.customerId ";
                //dd($sql);
                $productdetail = DB::connection('mysql2')->select($sql);
                if (count($productdetail) > 0) {
                    $productname=$productdetail[0]->productName;
                    $productquantity=$productdetail[0]->quantity;
                    $productid=$productdetail[0]->productId;
                }
                $data->productName = $productname;
                $data->quantity = $productquantity;
                $data->productId = $productid;
            }
             
        $newArray = array();

        foreach ($datas as $data) {
            $cur_item = array();

            array_push( 
                $cur_item,
                $data['created'],
                $data['storeName'],
                $data['customerName'],
                $data['phoneNumber'],
                $data['address'],
                $data['email'],
                $data['total'],
                $data['paymentType'],
                $data['paymentStatus'],
                $data['completionStatus'],
                $data['productId'],
                $data['productName'],
                $data['quantity']
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
            'Customer Name',
            'Customer Email',
            'Customer Address',
            'Customer Phone Number',
            'Total',
            'Payment Type',
            'Payment Status',
            'Completion Status',
            'Product ID',
            'Product Name',
            'Quantity',
        ];
    }
}