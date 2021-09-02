<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'client_payment_detail';

    protected $casts = ['id' => 'string'];

    protected $fillable = ['id', 
                            'taxNumber', 
                            'gstRate', 
                            'stRate', 
                            'whtRate', 
                            'bankName', 
                            'bankAccountNumber', 
                            'bankAccountTitle', 
                            'created', 
                            'updated', 
                            'clientId'
                        ];

    // protected $hidden = [
    //     'bankName',
    //     'bankAccountNumber',
    // ];
}
