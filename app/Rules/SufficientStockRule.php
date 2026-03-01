<?php

namespace App\Rules;

use App\Models\Product;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class SufficientStockRule implements ValidationRule
{
    public function __construct(private readonly Product $product) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $user        = auth()->user();
        $cart        = $user->cart()->with('items')->first();
        $existingQty = $cart?->items->firstWhere('product_id', $this->product->id)?->quantity ?? 0;
        $requested   = (int) $value;

        if (($existingQty + $requested) > $this->product->stock_quantity) {
            $available = $this->product->stock_quantity - $existingQty;
            $fail("Only {$available} more item(s) can be added (already {$existingQty} in cart, {$this->product->stock_quantity} in stock).");
        }
    }
}
