@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center mt-4">Danh sách sản phẩm</h2>
    <div class="row">
        @foreach ($products as $product)
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="{{ asset($product->img_url) }}" class="card-img-top" alt="{{ $product->name }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">{{ number_format($product->price, 0, ',', '.') }} VNĐ</p>
                    <a href="{{ route('products.show', ['id' => $product->id]) }}" class="btn btn-primary">
                        Xem chi tiết
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Hiển thị phân trang -->
    <div class="d-flex justify-content-center mt-4">
        {{ $products->links() }}
    </div>
</div>
@endsection