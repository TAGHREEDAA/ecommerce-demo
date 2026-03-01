<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    protected $fillable = ['cart_id', 'product_id', 'quantity'];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
        ];
    }

    // Computed: quantity × current product price. Requires product to be loaded.
    public function totalPrice(): Attribute
    {
        return Attribute::make(
            get: fn() => (float) ($this->quantity * $this->product->price)
        );
    }

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
