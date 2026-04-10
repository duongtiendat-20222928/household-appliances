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

    <div class="row bg-white p-4 rounded shadow-sm border m-0 mb-4">
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
                <div class="bg-light p-2 border-bottom fw-bold">
                    <i class="fa-solid fa-gift text-danger me-2"></i>Khuyến mãi trị giá 500.000đ
                </div>
                <div class="p-3 small">
                    <p class="mb-1"><i class="fa-solid fa-check text-success me-2"></i>Miễn phí giao hàng nội thành Hà
                        Nội.</p>
                    <p class="mb-1"><i class="fa-solid fa-check text-success me-2"></i>Bảo hành chính hãng
                        {{ $product->warranty_months ?? 12 }} tháng tại nhà.</p>
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
        </div>
    </div>


    <div class="bg-white p-4 rounded shadow-sm border mb-5">

        <div class="mb-5">
            <h5 class="fw-bold mb-4 pb-2 border-bottom"><i class="fa-solid fa-list-check text-primary me-2"></i> Thông số kỹ
                thuật</h5>
            @if (!empty($product->specifications))
                <table class="table table-striped table-bordered small">
                    <tbody>
                        @foreach ($product->specifications as $key => $value)
                            <tr>
                                <td class="w-25 text-muted fw-bold bg-light">{{ ucfirst(str_replace('_', ' ', $key)) }}
                                </td>
                                <td>{{ $value }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <table class="table table-striped table-bordered small">
                    <tbody>
                        <tr>
                            <td class="w-25 text-muted fw-bold bg-light">Thương hiệu</td>
                            <td>{{ $product->brand->name ?? 'Đang cập nhật' }}</td>
                        </tr>
                        <tr>
                            <td class="w-25 text-muted fw-bold bg-light">Bảo hành</td>
                            <td>{{ $product->warranty_months ?? 12 }} tháng</td>
                        </tr>
                        <tr>
                            <td class="w-25 text-muted fw-bold bg-light">Tình trạng</td>
                            <td>Mới 100% nguyên seal</td>
                        </tr>
                    </tbody>
                </table>
            @endif
        </div>

        <div class="border-top pt-4" id="reviews-section">
            <h5 class="fw-bold mb-4"><i class="fa-regular fa-comments text-danger me-2"></i> Đánh giá khách hàng</h5>

            <div class="row mb-4">
                <div class="col-md-4 text-center border-end mb-3 mb-md-0">
                    @php
                        $avgRating = $product->reviews()->where('is_approved', true)->avg('rating') ?? 0;
                        $reviewCount = $product->reviews()->where('is_approved', true)->count();
                    @endphp

                    <h1 class="text-danger fw-bold mb-0" style="font-size: 3.5rem;">{{ number_format($avgRating, 1) }}</h1>
                    <div class="text-warning fs-5 my-2">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= round($avgRating))
                                <i class="fa-solid fa-star"></i>
                            @else
                                <i class="fa-regular fa-star"></i>
                            @endif
                        @endfor
                    </div>
                    <p class="text-muted small mb-0">Dựa trên {{ $reviewCount }} lượt đánh giá</p>
                </div>

                <div class="col-md-8 ps-md-4">
                    @auth
                        <div class="bg-light p-3 rounded border">
                            <h6 class="fw-bold mb-2">Gửi đánh giá của bạn</h6>
                            <form action="{{ route('reviews.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">

                                <div class="mb-3 d-flex align-items-center gap-2">
                                    <label class="small fw-bold">Chất lượng:</label>
                                    <select name="rating"
                                        class="form-select form-select-sm w-auto border-warning text-warning fw-bold shadow-sm"
                                        required>
                                        <option value="5">⭐⭐⭐⭐⭐ Tuyệt vời</option>
                                        <option value="4">⭐⭐⭐⭐ Tốt</option>
                                        <option value="3">⭐⭐⭐ Bình thường</option>
                                        <option value="2">⭐⭐ Kém</option>
                                        <option value="1">⭐ Tệ</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <textarea name="comment" rows="3" class="form-control form-control-sm"
                                        placeholder="Mời bạn chia sẻ cảm nhận về sản phẩm..." required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm fw-bold px-4">Gửi đánh giá</button>
                            </form>
                        </div>
                    @else
                        <div
                            class="alert alert-secondary text-center py-4 mb-0 h-100 d-flex flex-column justify-content-center">
                            <p class="mb-3 text-muted">Vui lòng đăng nhập để gửi đánh giá và nhận điểm thưởng!</p>
                            <div><a href="{{ route('login') }}" class="btn btn-outline-primary fw-bold px-4">Đăng nhập
                                    ngay</a></div>
                        </div>
                    @endauth
                </div>
            </div>

            <div class="d-flex flex-column gap-3 mt-5">
                <h6 class="fw-bold mb-3">Tất cả bình luận ({{ $reviewCount }})</h6>

                @forelse($product->reviews()->where('is_approved', true)->latest()->get() as $review)
                    <div class="d-flex gap-3 border-bottom pb-3">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold text-uppercase shadow-sm"
                            style="width: 45px; height: 45px; font-size: 16px;">
                            {{ substr($review->user->name ?? 'K', 0, 1) }}
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <h6 class="fw-bold mb-0">{{ $review->user->name ?? 'Khách hàng' }}</h6>
                                <span class="badge bg-success small"><i class="fa-solid fa-circle-check"></i> Đã mua
                                    hàng</span>
                                <small class="text-muted ms-auto">{{ $review->created_at->diffForHumans() }}</small>
                            </div>
                            <div class="text-warning small mb-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fa-{{ $i <= $review->rating ? 'solid' : 'regular' }} fa-star"></i>
                                @endfor
                            </div>
                            <p class="mb-0 text-dark">{{ $review->comment }}</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5 bg-light rounded border">
                        <i class="fa-regular fa-comment-dots fs-1 text-muted opacity-50 mb-3"></i>
                        <p class="text-muted fw-bold mb-0">Chưa có đánh giá nào. Hãy là người đầu tiên nhận xét về sản phẩm
                            này!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
