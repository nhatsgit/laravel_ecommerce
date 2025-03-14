@extends('layouts.app')

@section('content')
    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li class="active">Shopping Cart</li>
                </ol>
            </div>

            @if (session('cart') && count(session('cart')) > 0)
                <form action="{{ route('cart.update') }}" method="POST">
                    <div class="table-responsive cart_info">
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
                                            <form action="{{ route('cart.remove') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $id }}">
                                                <button type="submit" class="cart_quantity_delete">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="text-right">
                        <h3>Total: {{ number_format($total, 0, ',', '.') }} VND</h3>
                        {{-- <a href="{{ route('checkout') }}" class="btn btn-success">Proceed to Checkout</a> --}}
                    </div>
                    <button type="submit" class="btn btn-primary">Cập nhật giỏ hàng</button>
                    <a href="#" class="btn btn-success">Thanh toán</a>
                </form>
            @else
                <h3 class="text-center">Giỏ hàng trống</h3>
            @endif
        </div>
    </section>
@endsection
