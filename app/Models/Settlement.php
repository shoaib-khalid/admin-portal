<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settlement extends Model
{
    use HasFactory;
    public $timestamps = false;
    
    protected $connection = 'mysql2';

    protected $table = 'store_settlement';

    protected $casts = ['id' => 'string'];

    protected $fillable = ['id', 
                            'cycle', 
                            'storeId', 
                            'clientId', 
                            'clientName', 
                            'storeName', 
                            'totalTransactionValue', 
                            'totalServiceFee', 
                            'totalCommisionFee', 
                            'totalRefund',                            
                            'totalStoreShare',
                            'settlementStatus',
                            'remarks'
                        ];
}
