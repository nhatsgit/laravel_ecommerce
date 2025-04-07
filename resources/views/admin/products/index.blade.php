@extends('layouts.app')

@section('content')
    <div class="container mt-3">
        <div>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary mb-3">
                Thêm sản phẩm mới
            </a>
            <h1>Quản lý sản phẩm của shop</h1>
        </div>
        <form method="GET" action="{{ route('admin.products.index') }}" class="mb-3">
            <select name="category" id="status" class="form-control" onchange="this.form.submit()" style="width: 200px;">
                <option value="">Tất cả</option>
                @foreach ($categories as $status)
                    <option value="{{ $status->id }}" {{ request('status') == $status->id ? 'selected' : '' }}>
                        {{ $status->name }}
                    </option>
                @endforeach
            </select>
        </form>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Giá</th>
                    <th>Mô tả</th>
                    <th>Loại</th>
                    <th>Ảnh Đại Diện</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ number_format($product->price, 0, ',', '.') }}₫</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td>
                            <img src="{{ asset($product->img_url) }}" width="100" height="100">
                        </td>
                        {{-- <td>
                        @foreach ($product->productImages as $image)
                            <img src="{{ asset($image->imgUrl) }}" width="50" height="50">
                        @endforeach
                    </td> --}}
                        <td>
                            <a href="{{ route('admin.products.edit', $product->id) }}" style="background-color: blue"
                                class="btn btn-primary btn-sm">Xem
                                chi tiết</a>
                            <form action="{{ route('admin.products.softdelete', $product->id) }}" method="POST"
                                class="d-inline">
                                @csrf

                                @if ($product->da_an)
                                    <button type="submit" class="btn btn-success btn-sm">
                                        Hiện sản phẩm
                                    </button>
                                @else
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        Ẩn sản phẩm
                                    </button>
                                @endif

                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>


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
@endsection
