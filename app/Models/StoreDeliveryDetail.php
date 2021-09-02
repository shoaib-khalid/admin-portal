<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreDeliveryDetail extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';

    protected $table = 'store_delivery_detail';

    protected $casts = ['storeId' => 'string'];

    protected $fillable = ['storeId', 
                            'type', 
                            'itemType', 
                            'maxOrderQuantityForBike', 
                            'allowsStorePickup',
                        ];
}
