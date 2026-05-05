<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Supplier extends Model
{
    /** @use HasFactory<\Database\Factories\SupplierFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
        'phone',
        'start_account',
        'current_account',
        'account_status',
    ];

    protected function casts(): array
    {
        return [
            'account_status' => 'integer',
        ];
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }

    public function getAccountStatusLabelAttribute(): string
    {
        return match ($this->account_status) {
            1 => 'Credit',
            2 => 'Debit',
            default => 'Balanced',
        };
    }
}
