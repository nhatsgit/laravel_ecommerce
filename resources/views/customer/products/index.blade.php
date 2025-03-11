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

                <!-- Phân trang -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
