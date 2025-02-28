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







Route::middleware('admin')->group(function () {
    Route::get('/dashboard', function () {return view('admin.dashboard');})->name('dashboards');
    Route::resource('product', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('brands', BrandController::class);

});


Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');



Route::get('/',[HomeController::class, 'index']);

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');
Route::get('/checkout/wa', [CartController::class, 'checkoutWa'])->name('cart.checkout.wa');
Route::get('/cart/items', [CartController::class, 'getCartItems']);




Route::get('/category/{id}', [ProductController::class, 'showCategory'])->name('products.byCategory');
Route::get('/brand/{id}', [ProductController::class, 'showBrand'])->name('products.byBrand');
Route::get('/category/{id}', [ProductController::class,'ProductCategory'])->name('index.category');
Route::get('/products/filter', [ProductController::class, 'filterProducts'])->name('products.filter');




Route::get('/home',[HomeController::class, 'index'])->name('home');



Route::get('/products', [ProductController::class, 'userIndex'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

Route::get('/config', function () {
    Artisan::call('config:clear');
    Artisan::call('config:cache');
});



require __DIR__.'/auth.php';
