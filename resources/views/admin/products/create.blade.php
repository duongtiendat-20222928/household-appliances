@extends('admin.layouts.admin')

@section('title', 'Thêm Sản Phẩm Mới')

@section('content')
    <div class="card shadow border-0 mb-4">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 fw-bold text-primary"><i class="fa-solid fa-plus-circle me-2"></i>Điền thông tin sản phẩm</h6>
        </div>
        <div class="card-body">

            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tên sản phẩm <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required
                                placeholder="Ví dụ: Tủ lạnh Panasonic Inverter 234 lít">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Danh mục <span class="text-danger">*</span></label>
                                <select name="category_id" class="form-select" required>
                                    <option value="">-- Chọn danh mục --</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Thương hiệu <span class="text-danger">*</span></label>
                                <select name="brand_id" class="form-select" required>
                                    <option value="">-- Chọn thương hiệu --</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Giá gốc (VNĐ) <span class="text-danger">*</span></label>
                                <input type="number" name="price" class="form-control"min="0" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Giá khuyến mãi (VNĐ)</label>
                                <input type="number" name="sale_price" class="form-control"
                                    placeholder="Để trống nếu không giảm giá"min="0">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tải ảnh lên</label>
                            <input type="file" name="image_upload" class="form-control" accept="image/*">
                            <small class="text-muted">Hỗ trợ JPG, PNG. Tối đa 2MB.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Số lượng trong kho</label>
                            <input type="number" name="stock" class="form-control" value="100" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Bảo hành (Tháng)</label>
                            <input type="number" name="warranty_months" class="form-control" value="12"min="0"
                                required>
                        </div>
                    </div>
                </div>

                <hr>
                <div class="d-flex justify-content-end gap-2 mt-3">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Hủy bỏ</a>
                    <button type="submit" class="btn btn-primary fw-bold"><i class="fa-solid fa-save me-2"></i> Lưu Sản
                        Phẩm</button>
                </div>
            </form>
        </div>
    </div>
@endsection
