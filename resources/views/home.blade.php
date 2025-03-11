@extends('layouts.app')

@section('content')
    <section id="slider"><!--slider-->
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            @foreach ($sliderProducts as $index => $product)
                                <li data-target="#slider-carousel" data-slide-to="{{ $index }}"
                                    class="{{ $index == 0 ? 'active' : '' }}"></li>
                            @endforeach
                        </ol>

                        <div class="carousel-inner">
                            @foreach ($sliderProducts as $index => $product)
                                <div class="item {{ $index == 0 ? 'active' : '' }}">
                                    <div class="col-sm-6">
                                        <h1><span>LARAVEL</span>-SHOP</h1>
                                        <h2>{{ $product->name }}</h2>
                                        <p>{{ $product->description }}</p>
                                        <button type="button" class="btn btn-default get"
                                            onclick="window.location.href='{{ route('products.show', ['id' => $product->id]) }}'">
                                            Xem ngay
                                        </button>

                                    </div>
                                    <div class="col-sm-6">
                                        <img style="width: 480px;height: 440px;" src="{{ asset($product->img_url) }}"
                                            class="girl img-responsive" alt="{{ $product->name }}" />
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                            <i class="fa fa-angle-left"></i>
                        </a>
                        <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section><!--/slider-->


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="features_items">
                    <h2 style="text-transform: capitalize;" class="title text-center">Gợi ý hôm nay</h2>

                    <x-product-list :products="$products" :uiSize="3" />

                </div>
            </div>
        </div>
    </div>
@endsection
