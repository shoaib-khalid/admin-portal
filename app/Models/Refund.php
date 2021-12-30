<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    use HasFactory;
    public $timestamps = false;
    
    protected $connection = 'mysql2';

    protected $table = 'order_refund';

    protected $casts = ['id' => 'string'];

    protected $fillable = ['id', 
                            'orderId', 
                            'refunded', 
                            'refundStatus', 
                            'refundType', 
                            'paymentChannel', 
                            'refundAmount', 
                            'remarks', 
                            'created', 
                            'updated',
                        ];
}
