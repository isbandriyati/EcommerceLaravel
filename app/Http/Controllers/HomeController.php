<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\brand;
use App\Models\Cart;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
    $products = Product::limit(6)->get();
    $categories = Category::all();
    $brands = Brand::all();

    // Cek apakah user sudah login sebelum mengambil keranjang
    $carts = auth()->check() ? Cart::where('user_id', auth()->id())->get() : collect();

    return view("HalamanHome.home", compact('products', 'categories', 'brands', 'cartItems'));
    }
}
