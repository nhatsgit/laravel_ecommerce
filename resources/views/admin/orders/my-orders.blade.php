<!-- resources/views/myorders.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container mt-3">
        <h1>Quản lý đơn hàng của shop</h1>

        <!-- Form lọc đơn hàng -->
        <form method="GET" action="{{ route('myorders') }}" class="mb-3">
            <div style="display: flex; gap: 10px; align-items: flex-end; flex-wrap: wrap;">
                <!-- Trạng thái -->
                <div>
                    <label for="status">Trạng thái:</label><br>
                    <select name="status" id="status" style="width: 180px; height: 36px;">
                        <option value="">Tất cả</option>
                        @foreach ($orderStatuses as $status)
                            <option value="{{ $status->id }}" {{ request('status') == $status->id ? 'selected' : '' }}>
                                {{ $status->ten_trang_thai }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Từ ngày -->
                <div>
                    <label for="from_date">Từ ngày:</label><br>
                    <input type="date" name="from_date" id="from_date" value="{{ request('from_date') }}"
                        style="height: 36px;">
                </div>

                <!-- Đến ngày -->
                <div>
                    <label for="to_date">Đến ngày:</label><br>
                    <input type="date" name="to_date" id="to_date" value="{{ request('to_date') }}"
                        style="height: 36px;">
                </div>

                <!-- Nút -->
                <div>
                    <button type="submit" style="height: 36px;">Lọc</button>
                    <a href="{{ route('myorders') }}"
                        style="height: 36px; padding: 8px 12px; background: #ccc; text-decoration: none; color: black; border-radius: 4px;">Reset</a>
                </div>
            </div>
        </form>

        <!-- Bảng danh sách đơn hàng -->
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Trạng thái đơn hàng</th>
                    <th>Thành tiền</th>
                    <th>Ngày đặt</th>
                    <th>Phương thức thanh toán</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->order_status->ten_trang_thai }}</td>
                        <td>{{ number_format($order->total_price, 0, ',', '.') }}₫</td>
                        <td>{{ \Carbon\Carbon::parse($order->order_date)->format('H:i d/m/Y') }}</td>
                        <td>{{ $order->payment }}</td>
                        <td>
                            <a href="{{ route('myorders.details', ['id' => $order->id]) }}" class="btn btn-success btn-sm">
                                Xem chi tiết
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
@endsection
