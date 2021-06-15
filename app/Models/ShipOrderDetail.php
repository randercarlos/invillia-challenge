<?php

namespace App\Models;

use App\Enums\MatchScoreEnum;
use Illuminate\Database\Eloquent\Model;

class ShipOrderDetail extends Model
{
    protected $table = 'ship_order_details';
    protected $fillable = ['ship_order_id', 'title', 'note', 'quantity', 'price'];
    protected $casts = [
        'quantity' => 'integer',
        'price' => 'float',
    ];
    const RECORDS_PER_PAGE = 10;

    public function shipOrder() {
        return $this->belongsTo(ShipOrder::class);
    }
}
