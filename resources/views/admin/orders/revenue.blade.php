@extends('layouts.app')

@section('content')
    <div class="container mt-3">
        <h1>Thống kê doanh thu</h1>

        <!-- Form lọc -->
        <form method="GET" action="{{ route('admin.revenue') }}" class="mb-3">
            <div style="display: flex; gap: 10px; align-items: flex-end; flex-wrap: wrap;">
                <div>
                    <label for="from_date">Từ ngày:</label><br>
                    <input type="date" name="from_date" id="from_date" value="{{ request('from_date') }}"
                        style="height: 36px;">
                </div>

                <div>
                    <label for="to_date">Đến ngày:</label><br>
                    <input type="date" name="to_date" id="to_date" value="{{ request('to_date') }}"
                        style="height: 36px;">
                </div>

                <div>
                    <button type="submit" style="height: 36px;">Lọc</button>
                    <a href="{{ route('admin.revenue') }}"
                        style="height: 36px; padding: 8px 12px; background: #ccc; text-decoration: none; color: black; border-radius: 4px;">Reset</a>
                </div>
            </div>
        </form>

        <h3>Tổng doanh thu: <strong style="color: green">{{ number_format($totalRevenue, 0, ',', '.') }}₫</strong></h3>

        <!-- Bảng đơn hàng -->
        <table class="table table-bordered table-hover mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ngày đặt</th>
                    <th>Thành tiền</th>
                    <th>Phương thức thanh toán</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y H:i') }}</td>
                        <td>{{ number_format($order->total_price, 0, ',', '.') }}₫</td>
                        <td>{{ $order->payment }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
