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
        return Transaction::all();
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
