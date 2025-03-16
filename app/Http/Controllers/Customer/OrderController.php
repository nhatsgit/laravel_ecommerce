<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    public function index()
    {
        // Lấy danh sách đơn hàng của user hiện tại
        $orders = Order::with('order_status')->where('user_id', Auth::id())->get();
        // Trả về view myorders.blade.php và truyền danh sách đơn hàng
        return view('customer.orders.my-orders', compact('orders'));
    }
    public function createOrder(Request $request)
    {
        // Lấy giỏ hàng từ session
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->back()->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        // Tính tổng tiền đơn hàng
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        try {
            DB::beginTransaction(); // Bắt đầu transaction

            // Tạo đơn hàng mới
            $order = Order::create([
                'customer_name' => $request->customerName,
                'address'       => $request->address,
                'email'         => $request->email,
                'note'          => $request->note,
                'order_date'    => now(),
                'payment'       => $request->payment,
                'phone_number'  => $request->phoneNumber,
                'total_price'   => $totalPrice,
                'order_status_id' => 1, // 1: Chờ xác nhận
                'user_id'       => Auth::id(),
                'voucher_id'    => null, // Nếu có mã giảm giá thì xử lý sau
            ]);

            // Lưu thông tin chi tiết đơn hàng
            foreach ($cart as $productId => $item) {
                OrderDetail::create([
                    'order_id'   => $order->id,
                    'product_id' => $productId,
                    'quantity'   => $item['quantity']
                ]);
            }

            DB::commit(); // Lưu transaction vào database

            // Xóa giỏ hàng khỏi session sau khi đặt hàng
            session()->forget('cart');

            return redirect()->route('my-orders')->with('success', 'Đặt hàng thành công!');
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback nếu có lỗi
            return redirect()->back()->with('error', 'Đã có lỗi xảy ra: ' . $e->getMessage());
        }
    }
    public function showOrderDetail($orderId)
    {
        $order = Order::with(['order_details.product', 'order_status', 'voucher'])
            ->where('id', $orderId)
            ->firstOrFail();

        return view('customer.orders.order-details', compact('order'));
    }
}
