<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'tax',
        'shipping',
        'image',
        'payment_url',
        'payment_token',
        'payment_integration_id',
    ];
}
