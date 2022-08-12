<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Voucher;
use App\Models\VoucherTerms;
use App\Models\VoucherVertical;
use App\Models\VoucherStore;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use DateTime;
use Illuminate\Support\Facades\Http;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;


class VoucherRedemptionExport implements FromCollection, ShouldAutoSize, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $from;
    protected $to;

    function __construct($from, $to) {
            $this->from = $from;
            $this->to = $to;
    }

    public function collection()
    {
        $datas = Voucher::select('voucher.*','store.name AS storeName')
                        ->leftJoin('store as store', 'storeId', '=', 'store.id');
                       
 
        $newArray = array();
        
        foreach($datas as $data){
            $cur_item = array();

                array_push( 
                    $cur_item,
                    $data['created'],
                    $data['customer']['name'],
                    $data['total'],
                    $data['platformVoucherDiscount'],
                    $data['voucher']['voucherCode'],
                    $data['voucher']['name'],      
                );

                $newArray[] = $cur_item;
            
        }
        return new Collection($newArray);
    }

    public function headings(): array
    {
         
        return [
            'Date',
            'Customer Name',
            'Sales Amount',
            'Voucher Amount',
            'Voucher Code',
            'Voucher Name',
        ];
    }
}
