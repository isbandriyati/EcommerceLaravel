<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call (ProductSeeder::class);

        $this->call([
            ProductSeeder::class,
            OrdersSeeder::class, // Panggil OrderSeeder
        ]);

        $this->call([
            UserSeeder::class,
            PasswordResetTokenSeeder::class,
            SessionSeeder::class,
        ]);

    }
}
