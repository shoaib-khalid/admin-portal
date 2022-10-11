<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlatformOgTag extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'platform_og_tag';

    public $timestamps = false;
   // protected $primaryKey = 'eventId';

    protected $casts = ['id' => 'string'];

    protected $fillable = ['id', 'property', 'content', 'name', 'platformId'];
}
