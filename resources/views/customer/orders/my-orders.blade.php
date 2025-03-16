<!-- resources/views/myorders.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container mt-3">
        <h1>Order List</h1>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Trạng thái đơn hàng</th>
                    <th>Thành tiền</th>
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
                        <td>{{ $order->payment }}</td>
                        <td>
                            {{-- <a href="{{ route('order.details', ['orderId' => $order->id]) }}" class="btn btn-success btn-sm">Xem chi tiết</a> --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
