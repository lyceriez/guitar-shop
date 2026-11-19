<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address'
    ];

    // One customer can purchase many guitars
    public function guitars()
{
    return $this->belongsToMany(
        Guitar::class,
        'guitar_customer',
        'customer_id',
        'guitar_id'
    )
    ->withPivot('purchase_date')
    ->withTimestamps();
}
}