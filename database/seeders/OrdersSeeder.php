<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Orders;
use App\Models\User;
use App\Models\Product;

class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Ambil data produk dan pengguna yang ada di database
         $user = User::first(); // Ambil user pertama
         $product = Product::first(); // Ambil product pertama
 
         // Jika ada user dan produk, buat pesanan
         if ($user && $product) {
             Orders::create([
                 'quantity' => 2,
                 'total' => 2 * $product->price,  // Harga total = quantity * harga produk
                 'user_id' => $user->id,
                 'product_id' => $product->id,
             ]);
            }
        }
}
