<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;


Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::resource('categories', CategoryController::class);
Route::resource('products', ProductController::class);

Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register'); 
Route::post('register', [AuthController::class, 'register']);
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']); 
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    // Route quản lý sản phẩm
    Route::resource('/admin/products', ProductController::class, [
    'as' => 'admin' // Đặt tiền tố 'admin' cho tất cả các route của products 
    ]);
    // Route quản lý danh mục
    Route::resource('/admin/categories', CategoryController::class, [
    'as' => 'admin' // Đặt tiền tố 'admin' cho tất cả các route của categories
    ]); 
});

Route::middleware(['auth'])->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index'); 
    Route::get('/products/{product}', [ProductController::class, 'show_normal'])->name('products.show');
});