<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;

    protected $fillable = [
        'invoice_no',
        'total_price',
        'sub_total',
        'tax',
        'shipping',
        'payment_status',
        'payment_method',
        'tracking',
        'building',
        'apartment',
        'floor',
        'address',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_order')
            ->withPivot('quantity', 'price', 'return_status');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function getTrackingLabelAttribute(): string
    {
        return match ($this->tracking) {
            1 => 'Ordered',
            2 => 'Pending',
            3 => 'Accepted',
            4 => 'Out for Delivery',
            5 => 'Received',
            default => 'Unknown',
        };
    }

    public function getPaymentStatusLabelAttribute(): string
    {
        return match ($this->payment_status) {
            1 => 'Paid',
            2 => 'Pending',
            3 => 'Unpaid',
            default => 'Unknown',
        };
    }

}