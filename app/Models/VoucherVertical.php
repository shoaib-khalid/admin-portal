<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherVertical extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';

    protected $table = 'voucher_vertical';

    protected $casts = ['id' => 'string'];

    protected $fillable = ['id', 
                            'voucherId',
                            'verticalCode'                            
                        ];
}
