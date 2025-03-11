<div class="row">
    @foreach ($products as $product)
        <div class="col-sm-{{ $uiSize }}">
            <div class="product-image-wrapper">
                <div class="single-products">
                    <div class="productinfo text-center">
                        <img src="{{ asset($product->img_url) }}" height="200" width="200" alt="">
                        <p style="text-align: right; color: red; background-color: yellow; display: inline;">
                            -{{ $product->phan_tram_giam }}%
                        </p>
                        <h2>{{ number_format(($product->price * (100 - $product->phan_tram_giam)) / 100, 0, ',', '.') }}
                            VND</h2>
                        <p>{{ $product->name }}</p>
                        <a class="btn btn-default add-to-cart">
                            <i class="fa fa-shopping-cart"></i> Bỏ Vào Giỏ
                        </a>
                        <a class="btn btn-default add-to-cart">
                            <i class="fa fa-info-circle"></i> Xem Chi Tiết
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
