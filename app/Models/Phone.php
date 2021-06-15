<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    protected $table = 'phones';
    protected $fillable = ['phone', 'person_id'];

    public function person() {
        return $this->belongsTo(Person::class);
    }
}
