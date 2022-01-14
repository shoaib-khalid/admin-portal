<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use App\Models\User;
use App\Models\Client;
use App\Models\PaymentDetail as Payment;
use App\Models\Store;
use App\Models\Refund;
use App\Models\StoreDeliveryDetail as StoreDelivery;
use Carbon\Carbon;
use DateTime;

use App\Exports\UsersExport;
use App\Exports\DetailsExport;
use App\Exports\SettlementsExport;
use App\Exports\MerchantExport;
use App\Exports\PendingRefundExport;
use App\Exports\RefundHistoryExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;
 
use App\Mail\NotifyMail;
use App\Mail\EmailContent;

class RefundController extends Controller
{

    protected $url;
    protected $token;

    function __construct() {
            $this->url = config('services.report_svc.url');
            $this->token = config('services.report_svc.token');
    }

    public function pendingrefund(){

        $to = date("Y-m-d");
        $date = new DateTime('90 days ago');
        $from = $date->format("Y-m-d");

        // $datas = Client::limit(100)->get();
        $datas = Refund::select('order_refund.id','order_refund.created','orderId','invoiceId', 'store.name AS storeName', 'customer.name AS customerName', 'refundType','refundAmount','paymentChannel','refundStatus','remarks')
                        ->join('order as order', 'order_refund.orderId', '=', 'order.id')
                        ->join('customer as customer', 'order.customerId', '=', 'customer.id')
                        ->join('store as store', 'order.storeId', '=', 'store.id')
                        ->where('refundStatus', 'PENDING')
                        ->whereBetween('order_refund.created', [$from, $to." 23:59:59"])  
                        ->orderBy('order_refund.created', 'ASC')
                        ->get();
        //print_r($datas);                    

        // return $datas;
        // die();        
        $datechosen = $date->format('F d, Y')." - ".date('F d, Y');                
        return view('components.pendingrefund', compact('datas','datechosen'));
    }

    
    public function filter_pendingrefund(Request $req){

        $data = $req->input();

        $dateRange = explode( '-', $req->date_chosen4 );
        $start_date = $dateRange[0];
        $end_date = $dateRange[1];

        $start_date = date("Y-m-d", strtotime($start_date));
        $end_date = date("Y-m-d", strtotime($end_date));

         $datas = Refund::select('order_refund.id','order_refund.created','orderId','invoiceId', 'store.name AS storeName', 'customer.name AS customerName', 'refundType','refundAmount','paymentChannel','refundStatus','remarks')
                        ->join('order as order', 'order_refund.orderId', '=', 'order.id')
                        ->join('customer as customer', 'order.customerId', '=', 'customer.id')
                        ->join('store as store', 'order.storeId', '=', 'store.id')
                        ->where('refundStatus', 'PENDING')
                        ->whereBetween('order_refund.created', [$start_date, $end_date." 23:59:59"])                        
                        ->orderBy('order_refund.created', 'ASC')
                        ->get();
        
        //print_r($datas);                    

        // return $datas;
        // die();
        $datechosen = $req->date_chosen4;                
        return view('components.pendingrefund', compact('datas', 'datechosen'));

    }

    public function update_refund(Request $request){

        //update refund record
        try{    
            //save file to public folder
            $request->proof->store('refund', 'public');

            //dd($request->refund_id);
            $refund = Refund::find($request->refund_id);
            $refund->remarks = $request->remarks;
            $refund->proof = $request->proof->hashName();            
            $refund->refundStatus = "COMPLETED";
            $refund->updated = date("Y-m-d H:i:s");
            $refund->refunded = date("Y-m-d H:i:s");
            $res = $refund->save(); 

            //get customer email from order
            $orderData = Refund::select('order_refund.id','order_refund.created','order_refund.orderId',                
                'store.name AS storeName', 'store.address AS storeAddress', 'customer.name AS customerName', 'customer.email AS customerEmail', 'store_asset.logoUrl AS storeLogo', 
                'refundType','refundAmount','refundStatus','remarks', 
                'order.total', 'order.subTotal', 'order.appliedDiscount','order.total','order.invoiceId',
                'order.storeServiceCharges', 'order.deliveryCharges', 'order.deliveryDiscount',
                'shipment.address AS shipmentAddress', 'shipment.city AS shipmentCity',
                'payment.paymentChannel','payment.createdDate AS paymentDate'
                )
                        ->join('order as order', 'order_refund.orderId', '=', 'order.id')
                        ->join('customer as customer', 'order.customerId', '=', 'customer.id')
                        ->join('store as store', 'order.storeId', '=', 'store.id')
                        ->join('store_asset as store_asset', 'store.id', '=', 'store_asset.storeId')
                        ->join('order_shipment_detail as shipment', 'order.id', '=', 'shipment.orderId')
                        ->join('payment_orders as payment', 'order.id', '=', 'payment.clientTransactionId')
                        ->where('order_refund.id', $request->refund_id)
                        ->get();
            //dd($orderData);          
            $orderId = $orderData[0]['orderId'];

            //get order item from order
            $orderItems = DB::connection('mysql2')->table('order_item')
                        ->select('order_item.id AS orderItemId','productId', 'productPrice', 'price', 'quantity', 'name', 'productVariant')
                        ->join('product as product', 'order_item.productId', '=', 'product.id')
                        ->where('orderId', $orderId)
                        ->get();
            foreach ($orderItems as $item) {                
                $orderSubItems = DB::connection('mysql2')->table('order_subitem')
                                 ->select('name')
                                ->join('product as product', 'order_subitem.productId', '=', 'product.id')
                                ->where('orderItemId', $item->orderItemId)
                                ->get();
                $item->subItems = $orderSubItems;
            }

            //if (count($item->subItems)>0) { echo "got subitem"; } else { echo "no subitem"; }
            //dd($item->subItems);

            $invoiceNo = $orderData[0]['invoiceId'];
            $customerEmail = $orderData[0]['customerEmail'];
            
            $emailContent = new EmailContent();
            $emailContent->orderDetails = $orderData[0];
            $emailContent->orderId = $request->refund_id;
            $emailContent->attachmentFile =  storage_path('app')."/public/refund/".$request->proof->hashName();
            $emailContent->orderItems = $orderItems;

            Mail::to($customerEmail)->send(new NotifyMail($emailContent));  

        }catch(QueryException $ex){ 
            return $ex->getMessage(); 
        }

        $datas = Refund::select('order_refund.id','order_refund.created','orderId','invoiceId', 'store.name AS storeName', 'customer.name AS customerName', 'refundType','refundAmount','paymentChannel','refundStatus','remarks')
                        ->join('order as order', 'order_refund.orderId', '=', 'order.id')
                        ->join('customer as customer', 'order.customerId', '=', 'customer.id')
                        ->join('store as store', 'order.storeId', '=', 'store.id')
                        ->where('refundStatus', 'PENDING')
                        ->orderBy('order_refund.created', 'ASC')
                        ->get();    
        $date = new DateTime('90 days ago');
        $datechosen = $date->format('F d, Y')." - ".date('F d, Y');    
        return view('components.pendingrefund', compact('datas', 'datechosen'));
    }

    public function export_pendingrefund(Request $req) 
    {
        $data = $req->input();

        $dateRange = explode( '-', $req->date_chosen4_copy );
        $start_date = $dateRange[0];
        $end_date = $dateRange[1];

        $start_date = date("Y-m-d", strtotime($start_date));
        $end_date = date("Y-m-d", strtotime($end_date));

        // return $start_date."|".$end_date;
        // return $data;
        // die();
        

        // $from = "2021-08-01";
        // $to = "2021-08-30";

        return Excel::download(new PendingRefundExport($start_date, $end_date." 23:59:59"), 'pendingrefund.xlsx');
    }


     public function refundhistory(){

        $to = date("Y-m-d");
        $date = new DateTime('90 days ago');
        $from = $date->format("Y-m-d");

        // $datas = Client::limit(100)->get();
        $datas = Refund::select('order_refund.id','order_refund.created','orderId','invoiceId', 'store.name AS storeName', 'customer.name AS customerName', 'refundType','refundAmount','paymentChannel','refundStatus','remarks', 'refunded', 'proof')
                        ->join('order as order', 'order_refund.orderId', '=', 'order.id')
                        ->join('customer as customer', 'order.customerId', '=', 'customer.id')
                        ->join('store as store', 'order.storeId', '=', 'store.id')
                        ->where('refundStatus', '<>', 'PENDING')
                        ->whereBetween('order_refund.created', [$from, $to." 23:59:59"])  
                        ->orderBy('order_refund.created', 'DESC')
                        ->get();
        //print_r($datas);                    

        // return $datas;
        // die();
       
        $datechosen = $date->format('F d, Y')." - ".date('F d, Y');
        return view('components.refundhistory', compact('datas','datechosen'));
    }

    public function filter_refundhistory(Request $req){

        $data = $req->input();

        $dateRange = explode( '-', $req->date_chosen4 );
        $start_date = $dateRange[0];
        $end_date = $dateRange[1];

        $start_date = date("Y-m-d", strtotime($start_date));
        $end_date = date("Y-m-d", strtotime($end_date));

         $datas = Refund::select('order_refund.id','order_refund.created','orderId','invoiceId', 'store.name AS storeName', 'customer.name AS customerName', 'refundType','refundAmount','paymentChannel','refundStatus','remarks', 'proof')
                        ->join('order as order', 'order_refund.orderId', '=', 'order.id')
                        ->join('customer as customer', 'order.customerId', '=', 'customer.id')
                        ->join('store as store', 'order.storeId', '=', 'store.id')
                        ->where('refundStatus', '<>', 'PENDING')
                        ->whereBetween('order_refund.created', [$start_date, $end_date." 23:59:59"])  
                        ->orderBy('order_refund.created', 'ASC')
                        ->get();
        //print_r($datas);                    

        // return $datas;
        // die();

        //echo $start_date." - ".$end_date;
        //exit;                        
        $datechosen = $req->date_chosen4;   
        return view('components.refundhistory', compact('datas','datechosen'));

    }

    public function export_refundhistory(Request $req) 
    {
        $data = $req->input();

        $dateRange = explode( '-', $req->date_chosen4_copy );
        $start_date = $dateRange[0];
        $end_date = $dateRange[1];

        $start_date = date("Y-m-d", strtotime($start_date));
        $end_date = date("Y-m-d", strtotime($end_date));

        // return $start_date."|".$end_date;
        // return $data;
        // die();

        // $from = "2021-08-01";
        // $to = "2021-08-30";

        return Excel::download(new RefundHistoryExport($start_date, $end_date." 23:59:59"), 'refundhistory.xlsx');
    }

}