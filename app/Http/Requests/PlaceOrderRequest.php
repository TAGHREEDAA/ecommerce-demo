<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class PlaceOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                $cart = auth()->user()->cart()->with('items.product')->first();

                if (!$cart || $cart->items->isEmpty()) {
                    $validator->errors()->add('cart', 'Your cart is empty.');
                    return;
                }

                foreach ($cart->items as $item) {
                    if ($item->quantity > $item->product->stock_quantity) {
                        $validator->errors()->add(
                            'stock',
                            "Insufficient stock for \"{$item->product->name}\"."
                        );
                    }
                }
            },
        ];
    }
}
