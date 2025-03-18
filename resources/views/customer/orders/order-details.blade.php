@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng')

@section('content')

    <div class="container mt-3">
        <h1>Chi tiết đơn hàng</h1>
        <section id="cart_items">
            <div class="container">
                <div class="table-responsive cart_info">
                    <table class="table table-condensed">
                        <thead>
                            <tr class="cart_menu">
                                <td class="image" style="width: 200px;">Ảnh</td>
                                <td class="description">Tên sản phẩm</td>
                                <td class="price">Đơn Giá</td>
                                <td class="quantity">Số Lượng</td>
                                <td class="total">Thành Tiền</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->order_details as $orderDetail)
                                <tr>
                                    <td class="cart_product" style="width: 200px;">
                                        <a href="{{ route('products.show', ['id' => $orderDetail->product->id]) }}">
                                            <img src="{{ asset($orderDetail->product->img_url) }}" alt=""
                                                width="120" height="100">
                                        </a>
                                    </td>
                                    <td class="cart_description">
                                        <h4>
                                            <a href="{{ route('products.show', ['id' => $orderDetail->product->id]) }}">
                                                {{ $orderDetail->product->name }}
                                            </a>
                                        </h4>
                                        <p>Web ID: {{ $orderDetail->product->id }}</p>
                                    </td>
                                    <td class="cart_price">
                                        <p>
                                            {{ number_format(($orderDetail->product->price / 100) * (100 - $orderDetail->product->phan_tram_giam), 0, ',', '.') }}₫
                                        </p>
                                    </td>
                                    <td>
                                        <input type="number" min="1" value="{{ $orderDetail->quantity }}"
                                            style="width:100px" readonly />
                                    </td>
                                    <td class="cart_total">
                                        <p class="cart_total_price">
                                            {{ number_format((($orderDetail->quantity * $orderDetail->product->price) / 100) * (100 - $orderDetail->product->phanTramGiam), 0, ',', '.') }}₫
                                        </p>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <div>
            <h3><strong>Trạng thái đơn hàng:</strong> {{ $order->order_status->ten_trang_thai }}</h3>
            {{-- @if (auth()->user()->hasRole('ADMIN') || auth()->user()->hasRole('STAFF'))
                @if ($order->orderStatus->id < 5)
                    <form action="{{ route('order.updateOrder', ['id' => $order->id]) }}" method="post">
                        @csrf
                        <input type="submit" value="Cập nhật trạng thái tiếp theo"
                            onclick="return confirm('Bạn Có Chắc Chắn Muốn Cập nhật trạng thái Đơn Này?');"
                            class="btn btn-success" />
                    </form>
                @endif
            @endif --}}
            @if (auth()->check() && auth()->user()->role === 'admin')
                @if ($order->order_status_id < 5)
                    <form method="post" action="{{ route('admin.myorders.updateStatus', $order->id) }}">
                        @csrf
                        <input type="hidden" name="order_status_id" value="{{ $order->order_status_id + 1 }}">
                        <input type="submit" value="Cập nhật trạng thái tiếp theo"
                            onclick="return confirm('Bạn có chắc chắn muốn cập nhật trạng thái đơn hàng?');"
                            class="btn btn-success" />
                    </form>
                @endif
            @endif
            <h2>Thông tin đơn hàng</h2>
            <p><strong>Tên Người Nhận:</strong> {{ $order->customer_name }}</p>
            <p><strong>SĐT:</strong> {{ $order->phone_number }}</p>
            <p><strong>Email:</strong> {{ $order->email }}</p>
            <p><strong>Địa chỉ giao hàng:</strong> {{ $order->address }}</p>
            <p><strong>Ghi chú:</strong> {{ $order->note }}</p>
            <p><strong>Phương thức thanh toán:</strong> {{ $order->payment }}</p>
            <p><strong>Mã giảm giá:</strong>
                @if (!$order->voucher)
                    Không có
                @else
                    <span style="color:green">
                        {{ $order->voucher->maGiamGia }}: giảm {{ $order->voucher->phanTramGiam }}% tổng đơn hàng
                        @if ($order->voucher->donToiThieu > 0)
                            , đơn tối thiểu {{ number_format($order->voucher->donToiThieu, 0, ',', '.') }}₫
                        @endif
                        @if ($order->voucher->giamToiDa > 0)
                            , giảm tối đa {{ number_format($order->voucher->giamToiDa, 0, ',', '.') }}₫
                        @endif
                    </span>
                @endif
            </p>
            <h3 style="color:green"><strong>Tổng tiền:</strong> {{ number_format($order->total_price, 0, ',', '.') }}₫
            </h3>
            @if (auth()->check() && auth()->user()->role === 'customer')
                @if ($order->order_status_id < 3)
                    <form method="post" action="{{ route('myorders.cancelOrder', $order->id) }}">
                        @csrf
                        <input type="submit" value="Hủy đơn" onclick="return confirm('Bạn có chắc chắn muốn hủy đơn?');"
                            class="btn btn-success" />
                    </form>
                @endif
            @endif
            {{-- @if (auth()->user()->hasRole('USER') && $order->orderStatus->id <= 2)
                <form action="{{ route('order.cancelOrder', ['id' => $order->id]) }}" method="post">
                    @csrf
                    <input type="submit" value="Hủy Đơn" onclick="return confirm('Bạn Có Chắc Chắn Muốn Hủy Đơn Này?');"
                        class="btn btn-danger" />
                </form>
            @endif --}}
        </div>
    </div>
@endsection
