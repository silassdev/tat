<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'session_token'];

    /**
     * User relationship.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Items in the cart.
     */
    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Total quantity of items in the cart.
     */
    public function getItemsCountAttribute(): int
    {
        return $this->items()->sum('quantity');
    }

    /**
     * Total amount of the cart contents.
     */
    public function getTotalAttribute(): float
    {
        return $this->items->reduce(function ($carry, $item) {
            return $carry + ($item->product->price * $item->quantity);
        }, 0.00);
    }
}
