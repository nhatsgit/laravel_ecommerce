@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <!-- Cột category chiếm 3/12 -->
            <div class="col-md-3 text-center">
                <div class="panel-group category-products" id="categoryView">
                    <h2>Danh mục</h2>
                    @foreach ($categories as $category)
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title" style="color: gray;">
                                    <input type="radio" id="option{{ $category->id }}" name="category"
                                        value="{{ $category->id }}" />
                                    {{ $category->name }}
                                </h4>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div className="price-range">
                    <div className="well">
                        <h2>Tầm Giá</h2>
                        <table>
                            <tbody>
                                <tr>
                                    <td><input id="minPrice" type="number" min="1000" value={minPrice}
                                            style="width: 100px" placeholder="Từ ₫" />
                                    </td>
                                    <td>&mdash;</td>
                                    <td><input id="maxPrice" type="number" min="1000" value={maxPrice}
                                            style="width: 100px" placeholder="Đến ₫" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <br></br>
                        <button type="button">Lọc</button>
                    </div>
                </div>
                <div className="shipping text-center">
                    <img src="{{ asset('images/home/shipping.jpg') }}" alt="" />
                </div>
            </div>

            <!-- Cột products chiếm 9/12 -->
            <div class="col-md-9">
                <div class="features_items">
                    <h2 style="text-transform: capitalize;" class="title text-center">Gợi ý hôm nay</h2>
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
