<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Purchase extends Model
{
    /** @use HasFactory<\Database\Factories\PurchaseFactory> */
    use HasFactory;
    protected $fillable = [
        'supplier_id', 'invoice_no', 'total_price', 'amount_paid',
        'payment_type', 'payment_status', 'active',
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_purchase')
                    ->withPivot('quantity', 'price', 'return_status');
    }

    public function getPaymentStatusLabelAttribute(): string
    {
        return match ($this->payment_status) {
            1 => 'Unpaid',
            2 => 'Partially Paid',
            3 => 'Paid',
            default => 'Unknown',
        };
    }
}
