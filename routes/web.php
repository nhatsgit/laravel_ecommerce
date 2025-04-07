<?php

use App\Http\Controllers\Admin\OrderManagementController;
use App\Http\Controllers\Admin\ProductManagementController;
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


Route::middleware(['auth'])->group(function () {
    Route::post('/myorders/create', [OrderController::class, 'createOrder'])->name('myorders.create');
    Route::get('/myorders', [OrderController::class, 'index'])->name('myorders');
    Route::get('/myorders/{id}', [OrderController::class, 'showOrderDetail'])->name('myorders.details');
    Route::post('/myorders/cancelOrder/{id}', [OrderController::class, 'cancelOrder'])->name('myorders.cancelOrder');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/myorders', [OrderManagementController::class, 'index'])->name('admin.myorders');
    Route::get('/admin/revenue', [OrderManagementController::class, 'revenue'])->name('admin.revenue');
    Route::post('/admin/myorders/updateStatus/{id}', [OrderManagementController::class, 'updateStatus'])->name('admin.myorders.updateStatus');
});
Route::controller(CartController::class)->group(function () {
    Route::post('/cart/add', 'add')->name('cart.add'); // Thêm vào giỏ hàng
    Route::get('/cart', 'index')->name('cart.index'); // Hiển thị giỏ hàng
    Route::get('/cart/checkout', 'checkout')->name('cart.checkout'); // Hiển thị giỏ hàng
    Route::post('/cart/update', 'update')->name('cart.update'); // Cập nhật số lượng
    Route::get('/cart/remove/{id}', 'remove')->name('cart.remove');
});

Route::controller(ProductController::class)->group(function () {
    Route::get('/products', 'index')->name('products.index'); // Danh sách sản phẩm
    Route::get('/products/suggestions', 'searchSuggestions')->name('products.suggestions'); // Danh sách sản phẩm
    Route::get('/products/{id}', 'show')->name('products.show'); // Chi tiết sản phẩm
});
Route::controller(ProductManagementController::class)->group(function () {
    Route::get('/admin/products/edit/{id}', 'edit')->name('admin.products.edit');
    Route::post('/admin/products/update/{id}',  'update')->name('admin.products.update');
    Route::get('/admin/products/create',  'create')->name('admin.products.create');
    Route::post('/admin/products/store',  'store')->name('admin.products.store');
    Route::get('/admin/products', 'index')->name('admin.products.index'); // Danh sách sản phẩm
    Route::get('/admin/products/{id}', 'show')->name('admin.products.show'); // Chi tiết sản phẩm
    Route::post('/admin/products/softdelete/{id}',  'softDelete')->name('admin.products.softdelete');
});
Route::controller(ProductController::class)->group(function () {
    Route::get('/products', 'index')->name('products.index'); // Danh sách sản phẩm
    Route::get('/products/suggestions', 'searchSuggestions')->name('products.suggestions'); // Danh sách sản phẩm
    Route::get('/products/{id}', 'show')->name('products.show'); // Chi tiết sản phẩm
});

Route::get('/', [HomeController::class, 'index']);


Route::get('/admin', [AdminController::class, 'index'])->middleware('role:admin');
Route::get('/staff', [StaffController::class, 'index'])->middleware('role:staff');
Route::get('/customer', [CustomerController::class, 'index'])->middleware('role:customer');



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
