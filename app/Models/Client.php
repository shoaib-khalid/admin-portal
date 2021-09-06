<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'client';

    protected $casts = ['id' => 'string'];

    protected $fillable = ['id', 'username', 'name', 'phoneNumber', 
                            'email', 'roleId', 'deactivated', 'locked', 'created', 
                            'updated', 'roleId', 'storeId', 'liveChatAgentId'];

    protected $hidden = [
        'password',
    ];
}
