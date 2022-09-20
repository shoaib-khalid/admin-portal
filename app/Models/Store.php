<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';

    protected $table = 'store';

    protected $casts = ['id' => 'string'];

    protected $fillable = ['id', 
                            'name', 
                            'city', 
                            'address', 
                            'clientId', 
                            'verticalCode', 
                            'storeDescription', 
                            'postcode', 
                            'state', 
                            'email', 
                            'contactName',
                            'phone',
                            'domain',
                            'liveChatOrdersGroupId',
                            'liveChatOrdersGroupName',
                            'liveChatCsrGroupId',
                            'liveChatCsrGroupName',
                            'regionCountryId',
                            'phoneNumber',
                            'regionCountryStateId',
                            'serviceChargesPercentage',
                            'paymentType',
                            'isDelivery',
                        ];
}
