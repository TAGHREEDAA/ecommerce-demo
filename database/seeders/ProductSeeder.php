<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['name' => 'Wireless Headphones',  'price' => 149.99, 'stock_quantity' => 25],
            ['name' => 'Mechanical Keyboard',   'price' => 89.99,  'stock_quantity' => 30],
            ['name' => 'USB-C Hub',             'price' => 39.99,  'stock_quantity' => 50],
            ['name' => 'Laptop Stand',          'price' => 59.99,  'stock_quantity' => 15],
            ['name' => 'Webcam HD',             'price' => 69.99,  'stock_quantity' => 2],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
