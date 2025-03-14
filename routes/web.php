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
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;


Route::controller(CartController::class)->group(function () {
    Route::post('/cart/add', 'add')->name('cart.add'); // Thêm vào giỏ hàng
    Route::get('/cart', 'index')->name('cart.index'); // Hiển thị giỏ hàng
    Route::post('/cart/remove', 'remove')->name('cart.remove'); // Xóa sản phẩm khỏi giỏ
    Route::post('/cart/update', 'update')->name('cart.update'); // Cập nhật số lượng
});

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
