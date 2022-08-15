<?php

namespace App\Exports;

use App\Models\Voucher;
use App\Models\VoucherTerms;
use App\Models\VoucherVertical;
use App\Models\VoucherStore;
use App\Models\Store;
use DateTime;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class VoucherListExport implements FromCollection, ShouldAutoSize, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        foreach($datas as $data){

            $cur_item = array();

            array_push( 
                $cur_item,
                $data['name'],
                $data['status'],
                $data['startDate'],
                $data['endDate'],
                $data['voucherType'],
                $data['storeName']
                $data['discountType']['calculationType'],
                $data['discountValue'],
                $data['maxDiscountAmount'],
                $data['voucherCode'],
                $data['requireToClaim'],
                $data['totalQuantity']
            );

            $newArray[] = $cur_item;

        }       
    }

    
    public function headings(): array
    {
         
        return [
            'Name',
            'Status',
            'Start Date',
            'End Date',
            'Voucher Type',
            'Store Name',
            'Discount Type',
            'Discount Value',
            'Capped Amt',
            'Voucher Code',
            'Total Claim',
            'Available Qty',
        ];
    }
}
