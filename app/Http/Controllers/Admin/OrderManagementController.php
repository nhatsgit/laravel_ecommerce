<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderStatus;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }
    public function index(Request $request)
    {
        // Lấy danh sách trạng thái đơn hàng
        $orderStatuses = OrderStatus::all();

        // Query đơn hàng của user hiện tại
        $query = Order::with('order_status');

        // Lọc theo trạng thái đơn hàng (nếu có)
        if ($request->has('status') && !empty($request->status)) {
            $query->where('order_status_id', $request->status);
        }

        // Lấy danh sách đơn hàng sau khi lọc
        $orders = $query->orderByDesc('id')->get();

        return view('customer.orders.my-orders', compact('orders', 'orderStatuses'));
    }
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        // Kiểm tra xem trạng thái có hợp lệ không
        if (!OrderStatus::where('id', $request->order_status_id)->exists()) {
            return redirect()->back()->with('error', 'Trạng thái không hợp lệ!');
        }

        // Cập nhật trạng thái
        $order->update([
            'order_status_id' => $request->order_status_id
        ]);

        return redirect()->back()->with('success', 'Cập nhật trạng thái thành công!');
    }
}
