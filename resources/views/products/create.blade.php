@extends('layouts.master')

@section('content')
    <h3>Thêm Sản phẩm</h3>
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <p><input type="text" name="name" placeholder="Tên sản phẩm" required></p>
        <p><input type="number" name="price" placeholder="Giá" required></p>
        <p><input type="number" name="quantity" placeholder="Số lượng" required></p>
        <p>
            <select name="category_id" required>
                <option value="">Chọn danh mục</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </p>
        <p><input type="file" name="image"></p>
        <button type="submit" class="btn">Lưu sản phẩm</button>
    </form>
@endsection
