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
                    @csrf <!-- Thêm dòng này để Laravel xác thực form -->

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
                                            <a href="{{ route('cart.remove', $id) }}" class="cart_quantity_delete">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="text-right">
                        <h3>Total: {{ number_format($total, 0, ',', '.') }} VND</h3>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">
                        <button type="submit" class="btn btn-primary">Cập nhật giỏ hàng</button>

                        <a href="{{ route('cart.checkout') }}">
                            <button type="button" class="btn btn-primary" style="background-color: green;">
                                Thanh toán
                            </button>
                        </a>
                    </div>

                </form>
            @else
                <h3 class="text-center">Giỏ hàng trống</h3>
            @endif
        </div>
    </section>
@endsection
