<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        // Lấy danh sách sản phẩm và phân trang (mỗi trang 9 sản phẩm)
        $products = Product::paginate(9);

        // Trả về view với dữ liệu sản phẩm
        return view('customer.products.index', compact('products'));
    }
    public function show($id)
    {
        $product = Product::findOrFail($id); // Lấy sản phẩm theo ID, nếu không có thì trả về lỗi 404
        return view('customer.products.show', compact('product'));
    }
}
