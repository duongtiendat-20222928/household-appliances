@extends('layouts.app')

@section('title', $product->name . ' - GiaDungShop')

@section('content')
    <nav aria-label="breadcrumb" class="mb-4 bg-white p-3 rounded shadow-sm border">
        <ol class="breadcrumb mb-0" style="font-size: 14px;">
            <li class="breadcrumb-item"><a href="/" class="text-decoration-none text-meta">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="#"
                    class="text-decoration-none text-meta">{{ $product->category->name ?? 'Danh mục' }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row bg-white p-4 rounded shadow-sm border m-0">
        <div class="col-md-5 mb-4 mb-md-0 text-center border-end">
            <img src="{{ $product->image ? asset($product->image) : 'https://placehold.co/600x600?text=No+Image' }}"
                class="img-fluid rounded mb-3 w-100" alt="{{ $product->name }}"
                style="object-fit: contain; max-height: 400px;"
                onerror="this.onerror=null; this.src='https://placehold.co/600x600?text=Anh+Bi+Loi';">

            <div class="d-flex justify-content-center gap-2">
                <img src="https://placehold.co/80x80" class="border p-1" style="cursor: pointer;">
                <img src="https://placehold.co/80x80" class="border p-1" style="cursor: pointer;">
                <img src="https://placehold.co/80x80" class="border p-1" style="cursor: pointer;">
            </div>
        </div>

        <div class="col-md-7 ps-md-4">
            <h3 class="fw-bold mb-3">{{ $product->name }}</h3>

            <p class="text-muted small mb-2">
                Thương hiệu: <span class="text-meta fw-bold">{{ $product->brand->name ?? 'Đang cập nhật' }}</span> |
                Tình trạng:
                @if ($product->stock > 0)
                    <span class="text-success fw-bold">Còn hàng ({{ $product->stock }})</span>
                @else
                    <span class="text-danger fw-bold">Hết hàng</span>
                @endif
            </p>

            @php $defaultVariant = $product->variants->first(); @endphp
            <div class="bg-light p-3 rounded mb-4 border">
                @if ($defaultVariant && $defaultVariant->sale_price)
                    <span class="price-red fs-2 me-3">{{ number_format($defaultVariant->sale_price, 0, ',', '.') }} ₫</span>
                    <span class="price-old fs-5">{{ number_format($defaultVariant->price, 0, ',', '.') }} ₫</span>
                @elseif($defaultVariant)
                    <span class="price-red fs-2">{{ number_format($defaultVariant->price, 0, ',', '.') }} ₫</span>
                @else
                    <span class="price-red fs-2">Liên hệ để báo giá</span>
                @endif
            </div>

            <div class="border rounded mb-4">
                <div class="bg-light p-2 border-bottom fw-bold"><i class="fa-solid fa-gift text-danger me-2"></i>Khuyến mãi
                    trị giá 500.000đ</div>
                <div class="p-3 small">
                    <p class="mb-1"><i class="fa-solid fa-check text-success me-2"></i>Miễn phí giao hàng nội thành Hà
                        Nội.</p>
                    <p class="mb-1"><i class="fa-solid fa-check text-success me-2"></i>Bảo hành chính hãng
                        {{ $product->warranty_months }} tháng tại nhà.</p>
                    <p class="mb-0"><i class="fa-solid fa-check text-success me-2"></i>Tặng phiếu mua hàng 200k cho đơn
                        hàng tiếp theo.</p>
                </div>
            </div>

            <form action="{{ route('cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                @if ($errors->has('error'))
                    <div class="alert alert-danger"><i
                            class="fa-solid fa-triangle-exclamation me-2"></i>{{ $errors->first('error') }}</div>
                @endif

                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="input-group" style="width: 150px;">
                        <span class="input-group-text bg-light">Số lượng</span>
                        <input type="number" name="quantity" class="form-control text-center" value="1" min="1"
                            max="{{ $product->stock }}">
                    </div>

                    <button type="submit" name="action" value="add"
                        class="btn btn-outline-danger btn-lg flex-grow-1 fw-bold text-uppercase"
                        {{ $product->stock <= 0 ? 'disabled' : '' }}>
                        <i class="fa-solid fa-cart-plus me-2"></i> Thêm vào giỏ
                    </button>

                    <button type="submit" name="action" value="buy_now"
                        class="btn btn-danger btn-lg flex-grow-1 fw-bold text-uppercase"
                        {{ $product->stock <= 0 ? 'disabled' : '' }}>
                        Mua ngay
                    </button>
                </div>
            </form>

            @if (session('success'))
                <div class="alert alert-success mt-3">
                    <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                    <a href="{{ route('cart.index') }}" class="alert-link ms-2">Xem giỏ hàng ngay</a>
                </div>
            @endif

            @if (!empty($product->specifications))
                <h6 class="fw-bold mt-4 border-bottom pb-2">Thông số kỹ thuật</h6>
                <table class="table table-sm table-striped small border">
                    <tbody>
                        @foreach ($product->specifications as $key => $value)
                            <tr>
                                <td class="w-25 text-muted">{{ ucfirst(str_replace('_', ' ', $key)) }}</td>
                                <td class="fw-bold">{{ $value }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
