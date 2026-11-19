<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuitarSpecification extends Model
{
    protected $fillable = [
        'guitar_id',
        'body_material',
        'pickup_type',
        'number_of_strings',
        'color'
    ];

    // Specification belongs to one guitar
    public function guitar()
    {
        return $this->belongsTo(Guitar::class);
    }
}