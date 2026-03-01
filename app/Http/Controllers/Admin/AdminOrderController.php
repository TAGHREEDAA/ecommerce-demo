<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RefundOrderRequest;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminOrderController extends Controller
{
    public function __construct(private OrderService $orderService) {}

    public function index(): View
    {
        $orders = $this->orderService->listAll();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $order->load('items.product', 'user');

        return view('admin.orders.show', compact('order'));
    }

    public function refund(RefundOrderRequest $request, Order $order): RedirectResponse
    {
        $this->orderService->refund($order);

        return back()->with('success', "Order #{$order->id} has been refunded.");
    }
}
