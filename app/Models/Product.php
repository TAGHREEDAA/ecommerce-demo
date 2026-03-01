<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'price',
        'stock_quantity',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'stock_quantity' => 'integer',
        ];
    }

    public function decrementStock(int $quantity): void
    {
        if ($quantity > $this->stock_quantity) {
            throw new \InvalidArgumentException("Cannot decrement stock below zero.");
        }

        $this->decrement('stock_quantity', $quantity);
    }

    public function restoreStock(int $quantity): void
    {
        $this->increment('stock_quantity', $quantity);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
