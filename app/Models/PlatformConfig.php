<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlatformConfig extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'platform_config';
    public $timestamps = false;
   
   // protected $primaryKey = 'eventId';

    protected $casts = ['platformId' => 'string'];

    protected $fillable = ['platformId', 'platformName', 'platformType', 'platformCountry'];
}
