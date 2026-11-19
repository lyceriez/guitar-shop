<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guitar extends Model
{
    protected $fillable = [
        'brand_id',
        'name',
        'model',
        'price',
        'quantity',
        'description'
    ];

    // Many guitars belong to one brand
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function specification()
    {
        return $this->hasOne(GuitarSpecification::class);
    }

    public function customers()
    {
        return $this->belongsToMany(
            Customer::class,
            'guitar_customer',
            'guitar_id',
            'customer_id'
        )
            ->withPivot('purchase_date')
            ->withTimestamps();
    }
}