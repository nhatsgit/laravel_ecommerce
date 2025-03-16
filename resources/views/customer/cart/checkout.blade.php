@extends('layouts.app')

@section('title', $title ?? 'Your Cart')

@section('content')
    <section class="container mt-3">
        <section id="cart_items">
            <div class="container">
                <div class="table-responsive cart_info">
                    @if (session('cart') && count(session('cart')) > 0)
                        <table class="table table-condensed">
                            <thead>
                                <tr class="cart_menu">
                                    <td class="image">Item</td>
                                    <td class="description"></td>
                                    <td class="price">Price</td>
                                    <td class="quantity">Quantity</td>
                                    <td class="total">Total</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0; @endphp
                                @foreach (session('cart') as $id => $item)
                                    @php
                                        $subtotal = $item['price'] * $item['quantity'];
                                        $total += $subtotal;
                                    @endphp
                                    <tr>
                                        <td class="cart_product">
                                            <a href="{{ route('products.show', ['id' => $id]) }}">
                                                <img src="{{ asset($item['img_url']) }}" height="100" width="100"
                                                    alt="{{ $item['name'] }}">
                                            </a>
                                        </td>
                                        <td class="cart_description">
                                            <h4><a
                                                    href="{{ route('products.show', ['id' => $id]) }}">{{ $item['name'] }}</a>
                                            </h4>
                                            <p>ID: {{ $id }}</p>
                                        </td>
                                        <td class="cart_price">
                                            <p>{{ number_format($item['price'], 0, ',', '.') }} VND</p>
                                        </td>
                                        <td>
                                            <input type="number" name="quantities[{{ $id }}]"
                                                value="{{ $item['quantity'] }}" min="1" style="width: 60px;">
                                        </td>
                                        <td class="cart_total">
                                            <p class="cart_total_price">{{ number_format($subtotal, 0, ',', '.') }} VND</p>
                                        </td>
                                        <td class="cart_delete">
                                            <a href="{{ route('cart.remove', $id) }}" class="cart_quantity_delete">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-info">Giỏ hàng trống</div>
                    @endif
                </div>
            </div>
        </section>

        <h1>Place Your Order</h1>
        <form action="{{ route('myorders.create') }}" method="post">
            @csrf
            <div class="mb-3">
                <label for="customerName" class="form-label">Tên:</label>
                <input type="text" value="{{ auth()->user()->fullName }}" id="customerName" name="customerName"
                    class="form-control" required>

                <label for="address" class="form-label">Địa chỉ:</label>
                <input type="text" value="{{ auth()->user()->address }}" id="address" name="address"
                    class="form-control" required>

                <label for="email" class="form-label">Email:</label>
                <input type="email" value="{{ auth()->user()->email }}" id="email" name="email"
                    class="form-control" required>

                <label for="phoneNumber" class="form-label">SĐT:</label>
                <input type="text" value="{{ auth()->user()->phone }}" id="phoneNumber" name="phoneNumber"
                    class="form-control" required>

                <label for="note" class="form-label">Ghi chú:</label>
                <input type="text" id="note" name="note" value="Đặt Hàng" class="form-control" required>

                {{-- <!-- Button chọn mã giảm giá -->
                <button type="button" id="openModalBtn" onclick="openPopup()"
                    style="background: none; border: 1px solid green; color:green">
                    Chọn mã giảm giá
                </button>
                <input type="hidden" id="voucherId" name="voucherId" value="-1">

                <div id="myModal" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <div class="voucherContainer">
                            <b>Chọn Voucher Giảm Giá</b><br><br>
                            <div class="scrollable-voucher">
                                @foreach ($vouchers as $voucher)
                                    <div class="voucher"
                                        @if ($totalPrice < $voucher->donToiThieu) style="background-color:lightgray" @endif>
                                        <div class="Box1">
                                            <h2>{{ $voucher->phanTramGiam }}%</h2>
                                            <p>{{ $voucher->maGiamGia }}</p>
                                        </div>
                                        <div class="Box2">
                                            <ul>
                                                <li>Đơn tối thiểu: {{ number_format($voucher->donToiThieu, 0, ',', '.') }}₫
                                                </li>
                                                <li>Giảm tối đa: {{ number_format($voucher->giamToiDa, 0, ',', '.') }}₫
                                                </li>
                                                <li>Số lượng còn: {{ $voucher->soLuongCon }}</li>
                                            </ul>
                                            @if ($totalPrice >= $voucher->donToiThieu)
                                                <input type="radio" data-code="{{ $voucher->maGiamGia }}"
                                                    data-discount="{{ $voucher->phanTramGiam }}"
                                                    data-minprice="{{ $voucher->donToiThieu }}"
                                                    data-maxprice="{{ $voucher->giamToiDa }}" name="options"
                                                    value="{{ $voucher->id }}" onclick="toggleRadio(this)">
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="voucherbtn" onclick="showSelectedValue()">OK</button>
                        </div>
                    </div>
                </div>
                <br />
                <strong style="color:green" id="voucherInfo"></strong>
                <br> --}}

                <label for="options">Thanh Toán:</label>
                <select name="payment" id="options">
                    <option value="Trực tiếp">Trực Tiếp</option>
                    <option value="Online">Online</option>
                </select>
            </div>

            <label>Chi tiết thanh toán</label>
            {{-- <p>Tổng đơn hàng: {{ number_format($totalPrice, 0, ',', '.') }}₫</p>
            <input type="hidden" id="totalPriceText" value="{{ $totalPrice }}">
            <p id="percentDiscount">Giảm giá đơn hàng: 0 ₫</p> --}}
            <h3 style="color:green" id="totalOrderPrice">
                Tổng thanh toán: {{ number_format($total, 0, ',', '.') }}₫
            </h3>

            <button type="submit" class="btn btn-primary">Submit Order</button>
        </form>
    </section>
@endsection
