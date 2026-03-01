<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCartItemRequest;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(private CartService $cartService) {}

    public function index(): View
    {
        $cartItems = $this->cartService->getCartItems(auth()->user());
        $total     = $cartItems->sum(fn($item) => $item->total_price);

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function store(StoreCartItemRequest $request, Product $product): RedirectResponse
    {
        $this->cartService->addToCart(auth()->user(), $product, $request->validated('quantity'));

        return back()->with('success', '"' . $product->name . '" added to cart.');
    }
}
