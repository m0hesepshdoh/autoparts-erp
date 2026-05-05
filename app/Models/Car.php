<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Car extends Model
{
    /** @use HasFactory<\Database\Factories\CarFactory> */
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'name_en',
        'name_ar',
        'start_year',
        'end_year',
        'factory_car_id',
    ];

    public function factoryCar(): BelongsTo
    {
        return $this->belongsTo(FactoryCar::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
