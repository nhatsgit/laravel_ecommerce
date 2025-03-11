<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Nếu có từ khóa tìm kiếm
        if ($request->has('keyword')) {
            $keyword = $request->input('keyword');
            $query->where('name', 'like', '%' . $keyword . '%');
        }

        // Lấy danh mục
        $categories = Category::all(); // Lấy tất cả danh mục

        // Phân trang 9 sản phẩm mỗi trang và giữ lại keyword khi phân trang
        $products = $query->paginate(9)->appends(['keyword' => $request->keyword]);

        return view('customer.products.index', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('customer.products.show', compact('product'));
    }
}
