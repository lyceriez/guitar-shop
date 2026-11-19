<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
        'name',
        'country'
    ];

    // One brand has many guitars
    public function guitars()
    {
        return $this->hasMany(Guitar::class);
    }
}