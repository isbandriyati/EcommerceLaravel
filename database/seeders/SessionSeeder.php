<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sessions')->insert([
            'id' => str_random(32),  // Membuat ID sesi acak
            'user_id' => 1,  // ID pengguna pertama
            'ip_address' => '192.168.1.1',  // Alamat IP dummy
            'user_agent' => 'Mozilla/5.0',  // User agent dummy
            'payload' => '{}',  // Payload dummy
            'last_activity' => time(),  // Waktu aktivitas terakhir
        ]);
    }
}
