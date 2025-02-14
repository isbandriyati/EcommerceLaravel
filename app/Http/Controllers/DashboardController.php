<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahproduct = Product::count();
        $jumlahcategory = Category::count();
        $jumlahKlikProduct = Product::sum();
        return view('dashboard', compact('jumlahProduct', 'jumlahCategory', 'jumlahKlikProduct'));
    }
}
