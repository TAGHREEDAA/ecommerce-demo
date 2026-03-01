<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\AdminOrderController;

Route::redirect('/', '/products');

Route::get('/products', [ProductController::class, 'index'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/items/{product}', [CartController::class, 'store'])->name('cart.items.store');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
});

Route::middleware(['auth', 'can:admin'])->prefix('admin')->name('admin.orders.')->group(function () {
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('show');
    Route::post('/orders/{order}/refund', [AdminOrderController::class, 'refund'])->name('refund');
});

require __DIR__.'/auth.php';
