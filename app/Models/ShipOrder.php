<?php

namespace App\Models;

use App\Enums\MatchScoreEnum;
use Illuminate\Database\Eloquent\Model;

class ShipOrder extends Model
{
    protected $table = 'ship_orders';
    protected $fillable = ['person_id', 'destinatary_name', 'destinatary_address', 'destinatary_city',
        'destinatary_country'];
    const RECORDS_PER_PAGE = 10;

    public function person() {
        return $this->belongsTo(Person::class);
    }

    public function shipOrderDetails() {
        return $this->hasMany(shipOrder::class);
    }
}
