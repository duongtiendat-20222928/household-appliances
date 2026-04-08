@extends('layouts.master')

@section('content')
    <h3>Danh sách Sản phẩm</h3>

    <form action="{{ route('products.index') }}" method="GET" style="margin-bottom: 15px;">
        <input type="text" name="search" placeholder="Tìm tên sản phẩm..." value="{{ request('search') }}">
        <select name="sort">
            <option value="">Sắp xếp giá</option>
            <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Tăng dần</option>
            <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Giảm dần</option>
        </select>
        <button type="submit" class="btn">Lọc</button>
    </form>

    <table>
        <tr>
            <th>Ảnh</th>
            <th>Tên</th>
            <th>Danh mục</th>
            <th>Giá</th>
            <th>Hành động</th>
        </tr>
        @foreach ($products as $product)
            <tr>
                <td>
                    @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" width="50" alt="img">
                    @else
                        Không có
                    @endif
                </td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category->name ?? 'N/A' }}</td>
                <td>{{ number_format($product->price) }}</td>
                <td>
                    <a href="{{ route('products.edit', $product->id) }}" class="btn">Sửa</a>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;"
                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Xóa</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    <div style="margin-top: 15px;">
        {{ $products->links() }}
    </div>
@endsection
