<!-- resources/views/myorders.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container mt-3">
        <h1>Order List</h1>

        <!-- Form lọc đơn hàng -->
        <form method="GET" action="{{ route('myorders') }}" class="mb-3 d-flex align-items-end gap-3">
            <div>
                <label for="status">Trạng thái:</label>
                <select name="status" id="status" class="form-control" style="width: 200px;">
                    <option value="">Tất cả</option>
                    @foreach ($orderStatuses as $status)
                        <option value="{{ $status->id }}" {{ request('status') == $status->id ? 'selected' : '' }}>
                            {{ $status->ten_trang_thai }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="from_date">Từ ngày:</label>
                <input type="date" name="from_date" id="from_date" class="form-control" style="width: 200px;"
                    value="{{ request('from_date') }}">
            </div>

            <div>
                <label for="to_date">Đến ngày:</label>
                <input type="date" name="to_date" id="to_date" class="form-control" value="{{ request('to_date') }}"
                    style="width: 200px;">
            </div>

            <div>
                <button type="submit" class="btn btn-primary">Lọc</button>
                <a href="{{ route('myorders') }}" class="btn btn-secondary">Reset</a>
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
