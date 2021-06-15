<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $table = 'people';
    protected $fillable = ['id', 'name'];
    const RECORDS_PER_PAGE = 10;


    public function phones() {
        return $this->hasMany(Phone::class);
    }
}
