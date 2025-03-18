@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <!-- Cột category chiếm 3/12 -->
            <div class="col-md-3 text-center">
                <form method="GET" action="{{ route('products.index') }}">
                    <h2>Danh mục</h2>
                    <div class="panel-group category-products" id="categoryView">
                        @foreach ($categories as $category)
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title" style="color: gray;">
                                        <input type="radio" name="category" value="{{ $category->id }}"
                                            {{ request('category') == $category->id ? 'checked' : '' }} />
                                        {{ $category->name }}
                                    </h4>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <h2>Tầm Giá</h2>
                    <table>
                        <tbody>
                            <tr>
                                <td><input name="minPrice" type="number" min="1000" value="{{ request('minPrice') }}"
                                        style="width: 100px" placeholder="Từ ₫" /></td>
                                <td>&mdash;</td>
                                <td><input name="maxPrice" type="number" min="1000" value="{{ request('maxPrice') }}"
                                        style="width: 100px" placeholder="Đến ₫" /></td>
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    <button type="submit" class="btn btn-primary" style="background-color: green">Lọc</button>
                    <button type="button" class="btn btn-primary">
                        <a href="{{ route('products.index') }}" style="color: white">
                            Xóa bộ lọc
                        </a>
                    </button>

                </form>

                <div className="shipping text-center">
                    <img src="{{ asset('images/home/shipping.jpg') }}" alt="" />
                </div>
            </div>

            <!-- Cột products chiếm 9/12 -->
            <div class="col-md-9">
                <div class="features_items">
                    <h2 style="text-transform: capitalize;" class="title text-center">Danh sách sản phẩm</h2>
                    <x-product-list :products="$products" :uiSize="4" />
                </div>

                <ul class="pagination">
                    {{-- Nút Previous --}}
                    @if ($products->onFirstPage())
                        <li class="disabled"><span>&laquo;</span></li>
                    @else
                        <li><a href="{{ $products->previousPageUrl() }}">&laquo;</a></li>
                    @endif

                    {{-- Hiển thị trang đầu tiên nếu cần --}}
                    @if ($products->currentPage() > 3)
                        <li><a href="{{ $products->url(1) }}">1</a></li>
                        <li class="disabled"><span>...</span></li>
                    @endif

                    {{-- Nếu còn cách trang cuối hơn 6 trang, chỉ hiển thị trang hiện tại ±2 --}}
                    @if ($products->currentPage() < $products->lastPage() - 6)
                        @for ($i = max(1, $products->currentPage() - 2); $i <= min($products->currentPage() + 2, $products->lastPage()); $i++)
                            <li class="{{ $i == $products->currentPage() ? 'active' : '' }}">
                                <a href="{{ $products->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor
                        <li class="disabled"><span>...</span></li>
                        {{-- Hiển thị 5 trang cuối cùng --}}
                        @for ($i = $products->lastPage() - 4; $i <= $products->lastPage(); $i++)
                            <li class="{{ $i == $products->currentPage() ? 'active' : '' }}">
                                <a href="{{ $products->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor
                    @else
                        {{-- Hiển thị tất cả trang nếu gần cuối --}}
                        @for ($i = max(1, $products->currentPage() - 2); $i <= $products->lastPage(); $i++)
                            <li class="{{ $i == $products->currentPage() ? 'active' : '' }}">
                                <a href="{{ $products->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor
                    @endif

                    {{-- Nút Next --}}
                    @if ($products->hasMorePages())
                        <li><a href="{{ $products->nextPageUrl() }}">&raquo;</a></li>
                    @else
                        <li class="disabled"><span>&raquo;</span></li>
                    @endif
                </ul>

            </div>
        </div>
    </div>
@endsection
