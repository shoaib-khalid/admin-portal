<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherServiceType extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';

    protected $table = 'voucher_service_type';

    protected $casts = ['id' => 'string'];

    protected $fillable = ['id', 
                            'voucherId',
                            'serviceType'                            
                        ];
}
