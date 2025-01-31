<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; // Untuk membuat token acak


class PasswordResetTokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('password_reset_tokens')->insert([
            'email' => 'johndoe@example.com',
            'token' => str::random(60),  // Membuat token acak
            'created_at' => now(),
        ]);
    }
}
