<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketPopup extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'marketplace_popup_config';

   
   // protected $primaryKey = 'eventId';

    protected $casts = ['id' => 'string'];

    protected $fillable = ['id', 'popupUrl', 'regionCountryId', 'type', 'sequence', 'actionUrl'];




}
