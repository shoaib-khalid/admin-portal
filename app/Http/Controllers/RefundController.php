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
            
            $mime_type = mime_content_type($request->proof->path());
            
            $image_file_name = $request->proof->hashName();
            $image_name = $request->proof->path();
            if ($mime_type=="image/jpeg" || $mime_type=="image/jpg") {
                $image = imagecreatefromjpeg($image_name); 
                $imgResized = imagescale($image , 700, -1);
                ob_start(); // Let's start output buffering.
                imagejpeg($imgResized); //This will normally output the image, but because of ob_start(), it won't.
                $contents = ob_get_contents(); //Instead, output above is saved to $contents
                ob_end_clean(); //End the output buffer.
                $image64 = base64_encode($contents);
            } else {
                $image = imagecreatefrompng($image_name); 
                $imgResized = imagescale($image , 700, -1);
                ob_start(); // Let's start output buffering.
                imagepng($imgResized); //This will normally output the image, but because of ob_start(), it won't.
                $contents = ob_get_contents(); //Instead, output above is saved to $contents
                ob_end_clean(); //End the output buffer.
                $image64 = base64_encode($contents);
            }            

            $refund = Refund::find($request->refund_id);
             //dd($request->refund_id); 
            $refund->remarks = $request->remarks;
            $refund->refundStatus = "COMPLETED";
            $refund->updated = date("Y-m-d H:i:s");
            $refund->refunded = date("Y-m-d H:i:s");
            $refund->prooffile = $image64;
            $refund->prooftype = $mime_type;
            $res = $refund->save(); 

            //get customer email from order
            $orderData = Refund::select('order_refund.id','order_refund.created','order_refund.orderId',                
                'store.name AS storeName', 'store.address AS storeAddress', 'customer.name AS customerName', 'customer.email AS customerEmail', 
                'refundType','refundAmount','refundStatus','remarks', 
                'order.total', 'order.subTotal', 'order.appliedDiscount','order.total','order.invoiceId', 'order.orderGroupId',
                'order.storeServiceCharges', 'order.deliveryCharges', 'order.deliveryDiscount',
                'shipment.address AS shipmentAddress', 'shipment.city AS shipmentCity'                
                )
                        ->join('order as order', 'order_refund.orderId', '=', 'order.id')
                        ->join('customer as customer', 'order.customerId', '=', 'customer.id')
                        ->join('store as store', 'order.storeId', '=', 'store.id')               
                        ->join('order_shipment_detail as shipment', 'order.id', '=', 'shipment.orderId')
                        ->where('order_refund.id', $request->refund_id)
                        ->get();
            //dd($orderData);          
            $orderId = $orderData[0]['orderId'];
            $orderGroupId = $orderData[0]['orderGroupId'];

            //get payment channel
            $sql="SELECT paymentChannel, createdDate FROM payment_orders WHERE clientTransactionId='".$orderGroupId."'";
            $paymentdetails = DB::connection('mysql2')->select($sql);
            if (count($paymentdetails)>0) {
                $orderData[0]['paymentChannel']=paymentdetails[0]['paymentChannel'];
                $orderData[0]['paymentDate']=paymentdetails[0]['createdDate'];
            } 

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
            $emailContent->attachmentData = $contents;
            $emailContent->attachmentMimeType = $mime_type;
            $emailContent->attachmentFileName = $image_file_name;
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
        $datas = Refund::select('order_refund.id','order_refund.created','orderId','invoiceId', 'store.name AS storeName', 'customer.name AS customerName', 'refundType','refundAmount','paymentChannel','refundStatus','remarks', 'refunded', 'proof', 'prooffile')
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

         $datas = Refund::select('order_refund.id','order_refund.created','orderId','invoiceId', 'store.name AS storeName', 'customer.name AS customerName', 'refundType','refundAmount','paymentChannel','refundStatus','remarks', 'proof', 'prooffile')
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