<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1); // Mặc định là 1 nếu không truyền

        // Lấy giỏ hàng từ session (nếu chưa có thì là mảng rỗng)
        $cart = session()->get('cart', []);

        // Kiểm tra sản phẩm đã có trong giỏ chưa
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity; // Tăng số lượng nếu đã có
        } else {
            // Lấy thông tin sản phẩm từ database
            $product = Product::find($productId);
            if (!$product) {
                return redirect()->back()->with('error', 'Sản phẩm không tồn tại!');
            }

            // Thêm sản phẩm vào giỏ hàng
            $cart[$productId] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'img_url' => $product->img_url ?? 'default.jpg',
            ];
        }

        // Lưu giỏ hàng vào session
        session()->put('cart', $cart);

        // Chuyển hướng đến trang giỏ hàng
        return redirect()->route('cart.index')->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
    }
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('customer.cart.index', compact('cart'));
    }
    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$request->product_id])) {
            unset($cart[$request->product_id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Đã xoá sản phẩm khỏi giỏ!');
    }
    public function update(Request $request)
    {
        $cart = session()->get('cart', []);

        foreach ($request->input('quantities') as $productId => $quantity) {
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] = max(1, $quantity); // Đảm bảo số lượng >= 1
            }
        }

        session()->put('cart', $cart);
        return redirect()->route('cart.index')->with('success', 'Giỏ hàng đã được cập nhật!');
    }
}
