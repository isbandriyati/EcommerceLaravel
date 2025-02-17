<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\BrandController;
use App\Models\Category;
use App\Models\Product;
use App\Models\brands;





Route::get('/', function () {
    return view('welcome');
});

Route::middleware('admin')->group(function () {
    Route::get('/dashboard', function () {return view('admin.dashboard');})->name('dashboards');
    Route::resource('product', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('brands', BrandController::class);

});


Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');



Route::get('/home',[HomeController::class, 'index']);

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');
Route::get('/cart/fetch', [CartController::class, 'fetchCart'])->name('cart.fetch');
Route::get('/checkout/wa', [CartController::class, 'checkoutWa'])->name('cart.checkout.wa');



Route::get('/category/{id}', [ProductController::class, 'showCategory'])->name('products.byCategory');
Route::get('/category/{id}', [ProductController::class, 'showCategory'])->name('category.product');






Route::get('/home', function () {
    $categories = Category::all();
    $products = Product::all();
    return view('HalamanHome.home', compact('categories', 'products'));
})->name('home');


Route::get('/products', [ProductController::class, 'userIndex'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');




require __DIR__.'/auth.php';
