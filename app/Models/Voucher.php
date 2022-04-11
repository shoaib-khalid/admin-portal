<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';

    protected $table = 'voucher';

    protected $casts = ['id' => 'string'];

    protected $fillable = ['id', 
                            'name',
                            'status',
                            'startDate',
                            'endDate',
                            'voucherType',
                            'storeId',
                            'discountType',                            
                            'calculationType',
                            'discountValue',
                            'maxDiscountAmount',
                            'voucherCode',
                            'totalQuantity',
                            'totalRedeem',
                            'deleteReason'                            
                        ];
}
