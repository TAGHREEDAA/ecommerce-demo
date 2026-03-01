<?php

namespace App\Services;

use App\Contracts\CartServiceInterface;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class CartService implements CartServiceInterface
{
    public function getOrCreateCart(User $user): Cart
    {
        return Cart::firstOrCreate(['user_id' => $user->id]);
    }

    public function addToCart(User $user, Product $product, int $quantity): void
    {
        $cart     = $this->getOrCreateCart($user);
        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        if ($cartItem) {
            $cartItem->update(['quantity' => $cartItem->quantity + $quantity]);
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity'   => $quantity,
            ]);
        }
    }

    public function getCartItems(User $user): Collection
    {
        $cart = $user->cart()->with('items.product')->first();

        return $cart ? $cart->items : Collection::make();
    }
}
