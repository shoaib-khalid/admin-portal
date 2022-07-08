<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    use HasFactory;
    public $timestamps = false;
    
    protected $connection = 'mysql3';

    protected $table = 'customer_activities';

    protected $casts = ['id' => 'string'];

    protected $fillable = ['id', 
                            'storeId', 
                            'customerId', 
                            'sessionId', 
                            'pageVisited', 
                            'ip', 
                            'os', 
                            'deviceModel', 
                            'browserType', 
                            'errorOccur',                            
                            'errorType',
                            'created',
                            'city',
                            'state',
                            'country',
                            'postcode',
                            'address'
                        ];
}
