@extends('admin.layouts.admin')

@section('title', 'Sửa Sản Phẩm')

@section('content')
    <div class="card shadow border-0 mb-4">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 fw-bold text-primary"><i class="fa-solid fa-pen-to-square me-2"></i>Chỉnh sửa: {{ $product->name }}
            </h6>
        </div>
        <div class="card-body">

            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tên sản phẩm <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Danh mục <span class="text-danger">*</span></label>
                                <select name="category_id" class="form-select" required>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Thương hiệu <span class="text-danger">*</span></label>
                                <select name="brand_id" class="form-select" required>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}"
                                            {{ $product->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        @php $variant = $product->variants->first(); @endphp
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Giá gốc (VNĐ) <span class="text-danger">*</span></label>
                                <input type="number" name="price" class="form-control"
                                    value="{{ $variant->price ?? 0 }}"min="0" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Giá khuyến mãi (VNĐ)</label>
                                <input type="number" name="sale_price" class="form-control"
                                    value="{{ $variant->sale_price ?? '' }}"min="0">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold d-block">Ảnh hiện tại</label>
                            <img src="{{ $product->image ? asset($product->image) : 'https://placehold.co/150x150?text=No+Image' }}"
                                class="img-thumbnail mb-2" style="max-height: 150px;">

                            <label class="form-label fw-bold">Tải ảnh mới (Bỏ trống nếu giữ nguyên)</label>
                            <input type="file" name="image_upload" class="form-control" accept="image/*">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Số lượng trong kho</label>
                            <input type="number" name="stock" class="form-control" value="{{ $product->stock }}"min="0"
                                required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Bảo hành (Tháng)</label>
                            <input type="number" name="warranty_months" class="form-control"
                                value="{{ $product->warranty_months }}"min="0" required>
                        </div>
                    </div>
                </div>

                <hr>
                <div class="d-flex justify-content-end gap-2 mt-3">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Hủy bỏ</a>
                    <button type="submit" class="btn btn-primary fw-bold"><i class="fa-solid fa-save me-2"></i> Cập nhật
                        thay đổi</button>
                </div>
            </form>
        </div>
    </div>
@endsection
