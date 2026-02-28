<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@ecommerce.com',
            'is_admin' => true,
        ]);

        User::factory()->create([
            'name' => 'First Test User',
            'email' => 'user1@ecommerce.com',
        ]);

        User::factory()->create([
            'name' => 'Second Test User',
            'email' => 'user2@ecommerce.com',
        ]);

        $this->call(ProductSeeder::class);
    }
}
