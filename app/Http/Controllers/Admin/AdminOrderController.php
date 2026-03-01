<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use Illuminate\View\View;

class AdminOrderController extends Controller
{
    public function __construct(private OrderService $orderService) {}

    public function index(): View
    {
        $orders = $this->orderService->listAll();

        return view('admin.orders.index', compact('orders'));
    }
}
