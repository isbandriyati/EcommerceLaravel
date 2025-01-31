<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;




Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {return view('admin.dashboard');})->name('dashboard');
    Route::get('/product', [ProductController::class, 'index'])->name('Admin.Products.index');
    Route::resource('/categories', CategoryController::class);

});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



















Route::get('/home',[HomeController::class, 'index']);

Route::get('/product', [ProductController::class, 'index'])->name('product.index');
Route::get('/category', [CategoriesController::class, 'index'])->name('category.index');

Route::get('/Dashboard', [DashboardController::class, 'index'])
->middleware('auth', 'verified')
->name('category.index');



require __DIR__.'/auth.php';
