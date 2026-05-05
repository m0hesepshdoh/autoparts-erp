<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'name_en',
        'name_ar',
        'category_id',
        'category_type',
    ];

    // Self-referential parent
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Self-referential children
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'category_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
