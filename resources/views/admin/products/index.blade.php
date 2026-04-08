@extends('admin.layouts.admin')

@section('title', 'Quản lý Sản phẩm')

@section('content')
    <div class="card shadow border-0">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h6 class="m-0 fw-bold text-primary"><i class="fa-solid fa-list me-2"></i>Danh sách Sản phẩm</h6>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm fw-bold">
                <i class="fa-solid fa-plus me-1"></i> Thêm sản phẩm mới
            </a>
            @if (session('success'))
                <div class="alert alert-success"><i class="fa-solid fa-check me-2"></i>{{ session('success') }}</div>
            @endif
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="50">ID</th>
                            <th width="80">Ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Danh mục</th>
                            <th>Tồn kho</th>
                            <th>Trạng thái</th>
                            <th width="120" class="text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td class="text-center">{{ $product->id }}</td>
                                <td>
                                    <img src="{{ $product->image ? asset($product->image) : 'https://placehold.co/50x50?text=No+Image' }}"
                                        alt="{{ $product->name }}" class="img-thumbnail"
                                        style="width: 50px; height: 50px; object-fit: cover;">
                                </td>
                                <td class="fw-bold">{{ $product->name }}</td>
                                <td>{{ $product->category->name ?? 'Không có' }}</td>
                                <td>
                                    @if ($product->stock > 10)
                                        <span class="badge bg-success">{{ $product->stock }}</span>
                                    @elseif($product->stock > 0)
                                        <span class="badge bg-warning text-dark">{{ $product->stock }} (Sắp hết)</span>
                                    @else
                                        <span class="badge bg-danger">Hết hàng</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $product->status == 'published' ? 'bg-info' : 'bg-secondary' }}">
                                        {{ $product->status == 'published' ? 'Hiển thị' : 'Đã ẩn' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.products.edit', $product->id) }}"
                                        class="btn btn-sm btn-outline-primary" title="Sửa"><i
                                            class="fa-solid fa-pen-to-square"></i></a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Sếp có chắc chắn muốn xóa vĩnh viễn sản phẩm này không?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa"><i
                                                class="fa-solid fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
