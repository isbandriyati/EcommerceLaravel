<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Models\Category;
use App\Models\Product;





Route::get('/', function () {
    return view('welcome');
});

Route::middleware('admin')->group(function () {
    Route::get('/dashboard', function () {return view('admin.dashboard');})->name('dashboard');
    Route::resource('product', ProductController::class);
    Route::resource('categories', CategoryController::class);

});


Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');



Route::get('/home',[HomeController::class, 'index']);
Route::get('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart/buy/{id}', [CartController::class, 'buy'])->name('cart.buy');
Route::get('/category/{id}', [ProductController::class, 'showCategory'])->name('products.byCategory');
Route::get('/category/{id}', [ProductController::class, 'showCategory'])->name('category.product');



Route::get('/Dashboard', [DashboardController::class, 'index'])
->middleware('auth', 'verified')
->name('category.index');


Route::get('/home', function () {
    $categories = Category::all();
    $products = Product::all();
    return view('HalamanHome.home', compact('categories', 'products'));
})->name('home');

require __DIR__.'/auth.php';
