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

        // Lọc theo trạng thái đơn hàng
        if ($request->has('status') && !empty($request->status)) {
            $query->where('order_status_id', $request->status);
        }

        // Lọc theo ngày đặt hàng
        if ($request->has('from_date') && $request->has('to_date')) {
            $fromDate = $request->from_date;
            $toDate = $request->to_date;

            if (!empty($fromDate) && !empty($toDate)) {
                $query->whereBetween('order_date', [$fromDate . ' 00:00:00', $toDate . ' 23:59:59']);
            }
        }

        // Lấy danh sách đơn hàng sau khi lọc
        $orders = $query->orderByDesc('id')->get();

        return view('admin.orders.my-orders', compact('orders', 'orderStatuses'));
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
    public function revenue(Request $request)
    {
        $query = Order::where('order_status_id', 5);

        // Lọc theo ngày
        if ($request->from_date) {
            $query->whereDate('order_date', '>=', $request->from_date);
        }
        if ($request->to_date) {
            $query->whereDate('order_date', '<=', $request->to_date);
        }

        $orders = $query->orderByDesc('order_date')->get();
        $totalRevenue = $orders->sum('total_price');

        return view('admin.orders.revenue', compact('orders', 'totalRevenue'));
    }
}
