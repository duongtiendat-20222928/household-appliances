@extends('layouts.master')

@section('content')
    <h3>Thống kê tổng quan</h3>
    <p>Tổng số sản phẩm: <strong>{{ $totalProducts }}</strong></p>
    <p>Tổng số danh mục: <strong>{{ $totalCategories }}</strong></p>

    <h3>5 Sản phẩm mới nhất</h3>
    <table>
        <tr>
            <th>Tên</th>
            <th>Giá</th>
            <th>Danh mục</th>
        </tr>
        @foreach ($latestProducts as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ number_format($product->price) }} VND</td>
                <td>{{ $product->category->name ?? 'Không có' }}</td>
            </tr>
        @endforeach
    </table>
@endsection
