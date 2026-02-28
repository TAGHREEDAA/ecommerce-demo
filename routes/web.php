<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;


Route::redirect('/', '/products');

Route::get('/products', [ProductController::class, 'index'])->name('dashboard');
require __DIR__.'/auth.php';
