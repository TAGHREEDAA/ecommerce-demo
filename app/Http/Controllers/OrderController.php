<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\PlaceOrderRequest;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct(private OrderService $orderService) {}

    public function index(): View
    {
        $orders = $this->orderService->list(auth()->user());

        return view('orders.index', compact('orders'));
    }

    public function store(PlaceOrderRequest $request): RedirectResponse
    {
        $order = $this->orderService->placeOrder(auth()->user());

        return redirect()->route('orders.show', $order)
            ->with('success', 'Order placed successfully.');
    }

    public function show(Order $order): View
    {
        abort_if($order->user_id !== auth()->id(), 403);

        $order->load('items.product');

        return view('orders.show', compact('order'));
    }
}
