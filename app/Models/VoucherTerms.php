<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherTerms extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';

    protected $table = 'voucher_terms';

    protected $casts = ['id' => 'string'];

    protected $fillable = ['id', 
                            'voucherId',
                            'terms'                            
                        ];
}
