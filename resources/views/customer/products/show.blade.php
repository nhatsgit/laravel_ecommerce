@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <img src="{{ asset($product->img_url) }}" alt="{{ $product->name }}" class="img-fluid">
        </div>
        <div class="col-md-6">
            <h1>{{ $product->name }}</h1>
            <p>{{ $product->description }}</p>
            <h3>Giá: {{ number_format($product->price, 0, ',', '.') }} VNĐ</h3>
            <p>Còn lại: {{ $product->so_luong_con }} sản phẩm</p>
        </div>
    </div>
</div>
@endsection