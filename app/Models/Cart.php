<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cart';

    protected $casts = ['id' => 'string'];

    protected $fillable = ['id', 'customerId', 'storeId', 'created', 
                            'updated','isOpen'];

}
