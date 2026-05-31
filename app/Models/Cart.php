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

    /**
     * Merge guest cart into user cart.
     */
    public static function mergeGuestCart($user, $sessionToken)
    {
        if (!$user || !$sessionToken) {
            return;
        }

        $guestCart = self::where('session_token', $sessionToken)->first();

        if ($guestCart) {
            // Find or create authenticated user cart
            $userCart = self::firstOrCreate(['user_id' => $user->id]);

            foreach ($guestCart->items as $item) {
                // Check if user already has item in cart
                $existingItem = CartItem::where('cart_id', $userCart->id)
                    ->where('product_id', $item->product_id)
                    ->first();

                if ($existingItem) {
                    $existingItem->increment('quantity', $item->quantity);
                    $item->delete();
                } else {
                    $item->update(['cart_id' => $userCart->id]);
                }
            }

            // Delete guest cart
            $guestCart->delete();
        }
    }
}

