<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();
        // ->where('da_an', false) // Chỉ lấy sản phẩm chưa ẩn
        // ->where('so_luong_con', '>', 0); // Chỉ lấy sản phẩm còn hàng

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

        return view('admin.products.index', compact('products', 'categories'));
    }



    public function show($id)
    {
        $product = Product::with('product_images')->findOrFail($id);
        return view('customer.products.show', compact('product'));
    }
    public function create()
    {
        $brands = Brand::all();
        $categories = Category::all();
        return view('admin.products.create', compact('brands', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'so_luong_con' => 'required|integer|min:0',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'img_url' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'product_images.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Lưu ảnh đại diện vào storage/app/public/productImages
        $imgUrl = null;
        if ($request->hasFile('img_url')) {
            $imgUrl = $request->file('img_url')->store('productImages', 'public'); // Lưu vào storage/app/public/productImages
        }

        // Tạo sản phẩm mới
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'so_luong_con' => $request->so_luong_con,
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'img_url' => 'storage/' . $imgUrl, // Đường dẫn sẽ là storage/productImages/name.png
            'da_an' => false,
            'phan_tram_giam' => 0,
            'thong_so' => null,
        ]);

        // Lưu ảnh minh họa
        if ($request->hasFile('product_images')) {
            foreach ($request->file('product_images') as $image) {
                $imageUrl = $image->store('productImages', 'public'); // Lưu vào storage/app/public/productImages
                ProductImage::create([
                    'product_id' => $product->id,
                    'img_url' => 'storage/' . $imageUrl
                ]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Sản phẩm đã được thêm thành công!');
    }
    public function edit($id)
    {
        $product = Product::with('product_images')->findOrFail($id);
        $brands = Brand::all();
        $categories = Category::all();

        return view('admin.products.edit', compact('product', 'brands', 'categories'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'so_luong_con' => 'required|integer|min:0',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'img_url' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'product_images.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $product = Product::findOrFail($id);

        // Cập nhật ảnh đại diện nếu có ảnh mới
        if ($request->hasFile('img_url')) {
            $imageUrl = $request->file('img_url')->store('productImages', 'public'); // Lưu vào storage
            $product->img_url = 'storage/' . $imageUrl;
        }

        // Cập nhật thông tin sản phẩm
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'so_luong_con' => $request->so_luong_con,
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id
        ]);

        // Nếu có ảnh minh họa mới, thêm vào DB
        if ($request->hasFile('product_images')) {
            foreach ($request->file('product_images') as $image) {
                $imagePath = $image->store('productImages', 'public'); // Lưu vào storage
                ProductImage::create([
                    'product_id' => $product->id,
                    'img_url' => 'storage/' . $imagePath
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được cập nhật thành công!');
    }
    public function softDelete($id)
    {
        $product = Product::findOrFail($id);

        // Chuyển đổi trạng thái `da_an`
        $product->da_an = !$product->da_an;
        $product->save();

        return redirect()->back()->with('success', 'Cập nhật trạng thái sản phẩm thành công!');
    }
}
