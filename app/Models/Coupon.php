<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'expiry_date',
        'usage_limit',
        'used_count',
        'min_order_value',
    ];

    /**
     * Check if coupon is valid for a given order value.
     */
    public function isValidForValue(float $value): bool
    {
        // 1. Expiry check
        if (now()->gt($this->expiry_date)) {
            return false;
        }

        // 2. Usage limit check
        if ($this->usage_limit !== null && $this->used_count >= $this->usage_limit) {
            return false;
        }

        // 3. Minimum order value check
        if ($this->min_order_value !== null && $value < $this->min_order_value) {
            return false;
        }

        return true;
    }

    /**
     * Calculate discount for a given amount.
     */
    public function calculateDiscount(float $amount): float
    {
        if ($this->type === 'percentage') {
            return ($this->value / 100) * $amount;
        }

        // fixed type
        return min($this->value, $amount);
    }
}
