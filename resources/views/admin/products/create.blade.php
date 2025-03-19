@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Thêm Sản Phẩm Mới</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Tên sản phẩm</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea class="form-control" id="description" name="description"></textarea>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Giá</label>
                <input type="number" class="form-control" id="price" name="price" required>
            </div>

            <div class="mb-3">
                <label for="so_luong_con" class="form-label">Số lượng</label>
                <input type="number" class="form-control" id="so_luong_con" name="so_luong_con" required>
            </div>

            <div class="mb-3">
                <label for="brand_id" class="form-label">Thương hiệu</label>
                <select class="form-control" id="brand_id" name="brand_id" required>
                    <option value="">Chọn thương hiệu</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label">Danh mục</label>
                <select class="form-control" id="category_id" name="category_id" required>
                    <option value="">Chọn danh mục</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="img_url" class="form-label">Ảnh đại diện</label>
                <input type="file" class="form-control" id="img_url" name="img_url" required>
            </div>

            <div class="mb-3">
                <label for="product_images" class="form-label">Ảnh minh họa (có thể chọn nhiều ảnh)</label>
                <input type="file" class="form-control" id="product_images" name="product_images[]" multiple>
            </div>

            <button type="submit" class="btn btn-primary">Thêm Sản Phẩm</button>
        </form>
    </div>
@endsection
