<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderStatus;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    public function index(Request $request)
    {
        // Lấy danh sách trạng thái đơn hàng
        $orderStatuses = OrderStatus::all();

        // Query đơn hàng của user hiện tại
        $query = Order::with('order_status')
            ->where('user_id', Auth::id());

        // Lọc theo trạng thái đơn hàng (nếu có)
        if ($request->has('status') && !empty($request->status)) {
            $query->where('order_status_id', $request->status);
        }

        // Lấy danh sách đơn hàng sau khi lọc
        $orders = $query->orderByDesc('id')->get();

        return view('customer.orders.my-orders', compact('orders', 'orderStatuses'));
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

            // Lưu thông tin chi tiết đơn hàng và cập nhật số lượng tồn kho
            foreach ($cart as $productId => $item) {
                // Lưu order detail
                OrderDetail::create([
                    'order_id'   => $order->id,
                    'product_id' => $productId,
                    'quantity'   => $item['quantity']
                ]);

                // Giảm số lượng sản phẩm trong kho
                $product = Product::find($productId);
                if ($product) {
                    $product->decrement('so_luong_con', $item['quantity']); // Trừ số lượng
                    if ($product->so_luong_con <= 0) {
                        $product->update(['so_luong_con' => 0]); // Đảm bảo không về số âm
                    }
                }
            }

            DB::commit(); // Lưu transaction vào database

            // Xóa giỏ hàng khỏi session sau khi đặt hàng
            session()->forget('cart');

            return redirect()->route('myorders')->with('success', 'Đặt hàng thành công!');
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
    public function cancelOrder($id)
    {
        $order = Order::findOrFail($id);


        // Cập nhật trạng thái
        $order->update([
            'order_status_id' => 6
        ]);

        return redirect()->back()->with('success', 'Cập nhật trạng thái thành công!');
    }
}
