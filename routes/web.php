<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Customer\ProductController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;

Route::get('/myorders', [OrderController::class, 'index'])->name('myorders');

Route::middleware(['auth'])->group(function () {
    Route::post('/myorders/create', [OrderController::class, 'createOrder'])->name('myorders.create');
    Route::get('/myorders', [OrderController::class, 'index'])->name('myorders');
    Route::get('/myorders/{id}', [OrderController::class, 'showOrderDetail'])->name('myorders.detail');
});
Route::controller(CartController::class)->group(function () {
    Route::post('/cart/add', 'add')->name('cart.add'); // Thêm vào giỏ hàng
    Route::get('/cart', 'index')->name('cart.index'); // Hiển thị giỏ hàng
    Route::get('/cart/checkout', 'checkout')->name('cart.checkout'); // Hiển thị giỏ hàng
    Route::post('/cart/update', 'update')->name('cart.update'); // Cập nhật số lượng
});
Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

Route::controller(ProductController::class)->group(function () {
    Route::get('/products', 'index')->name('products.index'); // Danh sách sản phẩm
    Route::get('/products/{id}', 'show')->name('products.show'); // Chi tiết sản phẩm
});

Route::get('/', [HomeController::class, 'index']);


Route::get('/admin', [AdminController::class, 'index'])->middleware('role:admin');
Route::get('/staff', [StaffController::class, 'index'])->middleware('role:staff');
Route::get('/customer', [CustomerController::class, 'index'])->middleware('role:customer');



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
