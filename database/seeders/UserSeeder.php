<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Pastikan Hash diimpor jika digunakan
use App\Models\User; // Pastikan ini ada



class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('123'),  // Gunakan Hash untuk password
            'role' => 'admin'
        ]);
    }
}
