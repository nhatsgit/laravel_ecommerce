@extends('layouts.app')

@section('content')
    <section class="container mt-5">
        <div class="product-details">
            <!-- product-details -->
            <div class="col-sm-5">
                <div class="view-product">
                    <img src="{{ asset($product->img_url) }}" alt="Product Image" />
                </div>
                <div id="similar-product" class="carousel slide" data-ride="carousel">
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        <div class="item active">
                            @foreach ($product->product_images as $image)
                                <a href="#"><img src="{{ asset($image->img_url) }}" width="50" height="50"
                                        alt="Product Image"></a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-7">
                <div class="product-information">
                    <!-- product-information -->
                    <h2>{{ $product->name }}</h2>
                    <p>Web ID: <span>{{ $product->id }}</span></p>
                    <p style="text-decoration: line-through;">{{ number_format($product->price, 0, ',', '.') }} VND</p>
                    <span>
                        <span> Giá:
                            <span>{{ number_format(($product->price * (100 - $product->phan_tram_giam)) / 100, 0, ',', '.') }}
                                VND</span></span>
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input id="txtQuantity" type="number" min="1" value="1" name="quantity"
                                onchange="updateCount()" oninput="removeNegative()" />
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-shopping-cart"></i> Bỏ vào giỏ
                            </button>
                        </form>
                    </span>
                    <p><b>Số lượng còn:</b> <span>{{ $product->so_luong_con }}</span></p>
                    <p><b>Mô tả:</b> <span>{{ $product->description }}</span></p>
                    <p><b>Thông số:</b> <span>{{ $product->thong_so }}</span></p>
                    <p><b>Hãng:</b> <span>{{ $product->brand->name }}</span></p>
                    <p><b>Loại:</b> <span>{{ $product->category->name }}</span></p>
                    <a href="#"><img src="{{ asset('myLayout/images/product-details/share.png') }}"
                            class="share img-responsive" alt="Share"></a>
                </div><!-- /product-information -->
            </div>
        </div><!-- /product-details -->
    </section>
@endsection
