<?php

namespace App\Contracts;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface CartServiceInterface
{
    public function getOrCreateCart(User $user): Cart;

    public function addToCart(User $user, Product $product, int $quantity): void;

    public function getCartItems(User $user): Collection;
}
