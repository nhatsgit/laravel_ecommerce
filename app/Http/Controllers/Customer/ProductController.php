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
        $query = Product::query()
            ->where('da_an', false) // Chỉ lấy sản phẩm chưa ẩn
            ->where('so_luong_con', '>', 0); // Chỉ lấy sản phẩm còn hàng

        // Lọc theo từ khóa tìm kiếm (nếu có)
        if ($request->has('keyword')) {
            $keyword = $request->input('keyword');
            $query->where('name', 'like', '%' . $keyword . '%');
        }

        // Lọc theo danh mục (nếu có)
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category_id', $request->category);
        }

        // Lọc theo khoảng giá (đã tính cả giảm giá)
        if ($request->has('minPrice') || $request->has('maxPrice')) {
            $minPrice = $request->filled('minPrice') ? (int) $request->input('minPrice') : null;
            $maxPrice = $request->filled('maxPrice') ? (int) $request->input('maxPrice') : null;

            $query->where(function ($q) use ($minPrice, $maxPrice) {
                if ($minPrice !== null && $minPrice > 0) {
                    $q->whereRaw('(price * (1 - phan_tram_giam / 100)) >= ?', [$minPrice]);
                }
                if ($maxPrice !== null && $maxPrice > 0) {
                    $q->whereRaw('(price * (1 - phan_tram_giam / 100)) <= ?', [$maxPrice]);
                }
            });
        }

        // Lấy danh mục
        $categories = Category::all();

        // Phân trang và giữ lại các tham số khi phân trang
        $products = $query->orderByDesc('id')->paginate(9)->appends($request->all());

        return view('customer.products.index', compact('products', 'categories'));
    }



    public function show($id)
    {
        $product = Product::with('product_images')->findOrFail($id);
        return view('customer.products.show', compact('product'));
    }
    public function searchSuggestions(Request $request)
    {
        $keyword = $request->input('keyword');

        // Tìm sản phẩm có tên chứa keyword, giới hạn 5 sản phẩm
        $products = Product::where('name', 'like', "%$keyword%")
            ->limit(5)
            ->orderByDesc('id')
            ->get(['id', 'name']);

        return response()->json($products);
    }
}
