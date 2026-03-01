<?php

namespace App\Http\Requests;

use App\Rules\SufficientStockRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCartItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $product = $this->route('product');

        return [
            'quantity' => ['required', 'integer', 'min:1', new SufficientStockRule($product)],
        ];
    }
}
