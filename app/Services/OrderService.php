<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function list(User $user): Collection
    {
        return $user->orders()->latest()->get();
    }

    public function listAll(): Collection
    {
        return Order::with('user')->latest()->get();
    }

    public function placeOrder(User $user): Order
    {
        /** @var Cart $cart */
        $cart = $user->cart()->with('items.product')->first();

        return DB::transaction(function () use ($user, $cart) {
            $order = $this->createOrder($user, $cart);
            $this->createOrderItems($order, $cart);
            $this->clearCart($cart);

            return $order;
        });
    }

    private function createOrder(User $user, Cart $cart): Order
    {
        $subtotal = (float) $cart->items->sum(fn($item) => $item->total_price);

        return Order::create([
            'user_id'     => $user->id,
            'total_price' => (int) round($subtotal),
            'status'      => OrderStatus::Pending,
        ]);
    }

    private function createOrderItems(Order $order, Cart $cart): void
    {
        foreach ($cart->items as $item) {
            $price     = (float) $item->product->price;
            $unitPrice = (int) round($price);

            $order->items()->create([
                'product_id'  => $item->product_id,
                'quantity'    => $item->quantity,
                'unit_price'  => $unitPrice,
                'total_price' => $unitPrice * $item->quantity,
            ]);

            $item->product->decrementStock($item->quantity);
        }
    }

    private function clearCart(Cart $cart): void
    {
        $cart->items()->delete();
    }
}
