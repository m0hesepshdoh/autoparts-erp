<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;
    protected $fillable = [
        'name_en',
        'name_ar',
        'description_en',
        'description_ar',
        'country',
        'purchase_price',
        'price',
        'stock',
        'images',
        'category_id',
        'brand_id',
        'car_id',
    ];

    protected function casts(): array
    {
        return [
            'images' => 'array',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'product_order')
            ->withPivot('quantity', 'price', 'return_status');
    }

    public function purchases(): BelongsToMany
    {
        return $this->belongsToMany(Purchase::class, 'product_purchase')
            ->withPivot('quantity', 'price', 'return_status');
    }

    public function wishlistUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'product_user')
            ->withPivot('quantity');
    }
}