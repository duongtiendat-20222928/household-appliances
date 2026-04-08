@extends('layouts.master')

@section('content')
    <h3>Cập nhật Sản phẩm</h3>
    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <p><input type="text" name="name" value="{{ $product->name }}" required></p>
        <p><input type="number" name="price" value="{{ $product->price }}" required></p>
        <p><input type="number" name="quantity" value="{{ $product->quantity }}" required></p>
        <p>
            <select name="category_id" required>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </p>
        <p>
            <input type="file" name="image">
            @if ($product->image)
                <br><img src="{{ asset('storage/' . $product->image) }}" width="100" style="margin-top:10px;">
            @endif
        </p>
        <button type="submit" class="btn">Cập nhật</button>
    </form>
@endsection
