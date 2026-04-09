@extends('layouts.app')

@section('content')
    <div class="row">

        <div class="col-lg-3 d-none d-lg-block" data-aos="fade-right">
            <div class="bg-white p-3 rounded shadow-sm border h-100">
                <h6 class="fw-bold mb-3 border-bottom pb-3 text-primary">
                    <i class="fa-solid fa-bars-staggered me-2"></i> DANH MỤC SẢN PHẨM
                </h6>
                <ul class="list-unstyled sidebar-menu mb-0" style="font-size: 15px;">
                    @if (isset($categories))
                        @foreach ($categories as $cat)
                            <li>
                                <a href="{{ route('category.show', $cat->id) }}">
                                    <i class="fa-solid fa-caret-right me-2 text-primary"></i> {{ $cat->name }}
                                </a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>

        <div class="col-lg-9">

            {{-- BANNER: Đã thêm carousel-fade để chuyển ảnh mờ ảo thay vì trượt ngang --}}
            <div id="heroBanner" class="carousel slide carousel-fade mb-4 shadow rounded overflow-hidden"
                data-bs-ride="carousel" data-bs-interval="3500" data-aos="fade-down">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('images/banners/banner.jpg') }}" class="d-block w-100"
                            style="object-fit: cover; height: 400px; transition: transform 0.5s ease;">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('images/banners/banner2.png') }}" class="d-block w-100"
                            style="object-fit: cover; height: 400px;">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('images/banners/banner3.png') }}" class="d-block w-100"
                            style="object-fit: cover; height: 400px;">
                    </div>
                </div>
            </div>

            {{-- SẢN PHẨM --}}
            <div class="bg-white p-4 rounded shadow-sm border mb-4" data-aos="fade-up">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-4">
                    <h4 class="fw-bold m-0 text-uppercase text-dark">
                        <i class="fa-solid fa-fire text-danger me-2" style="animation: pulse-red 1s infinite;"></i> Sản phẩm
                        nổi bật
                    </h4>
                </div>

                <div class="row g-4">
                    @forelse($products as $product)
                        <div class="col-md-4 col-sm-6" data-aos="zoom-in-up" data-aos-delay="{{ $loop->index * 100 }}">
                            <div class="card h-100 border product-card position-relative overflow-hidden">

                                <div class="discount-badge">-15%</div>

                                <a href="{{ route('product.show', $product->slug) }}" class="overflow-hidden p-3 d-block">
                                    <img src="{{ $product->image ? asset($product->image) : 'https://placehold.co/400x400?text=No+Image' }}"
                                        class="card-img-top" style="object-fit: contain; height: 220px; transition: 0.5s;"
                                        onmouseover="this.style.transform='scale(1.1)'"
                                        onmouseout="this.style.transform='scale(1)'">
                                </a>

                                <div class="card-body px-3 pt-2 pb-3 d-flex flex-column bg-white">

                                    {{-- Tên --}}
                                    <a href="{{ route('product.show', $product->slug) }}"
                                        class="text-decoration-none text-dark">
                                        <h6 class="card-title fw-bold"
                                            style="font-size: 15px; -webkit-line-clamp: 2; display: -webkit-box; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.4;">
                                            {{ $product->name }}
                                        </h6>
                                    </a>

                                    {{-- ⭐ Rating --}}
                                    <div class="text-warning mb-2" style="font-size: 12px;">
                                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                            class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                            class="fa-solid fa-star-half-stroke"></i>
                                        <span class="text-muted ms-1">(99+)</span>
                                    </div>

                                    {{-- 📦 Tồn kho --}}
                                    <div class="mb-3 text-muted bg-light px-2 py-1 rounded small">
                                        <i class="fa-solid fa-box-archive me-1 text-primary"></i>
                                        @if ($product->stock > 0)
                                            Còn: <strong class="text-success">{{ $product->stock }}</strong> sp
                                        @else
                                            <strong class="text-danger">Hết hàng</strong>
                                        @endif
                                    </div>

                                    <div class="mt-auto">
                                        {{-- Giá --}}
                                        <div class="mb-3">
                                            @if ($product->variants->isNotEmpty())
                                                @php $firstVariant = $product->variants->first(); @endphp

                                                @if ($firstVariant->sale_price)
                                                    <div class="price-red fs-5 mb-1">
                                                        {{ number_format($firstVariant->sale_price, 0, ',', '.') }} đ</div>
                                                    <div class="price-old d-inline-block px-1 rounded">
                                                        {{ number_format($firstVariant->price, 0, ',', '.') }} đ</div>
                                                @else
                                                    <div class="price-red fs-5">
                                                        {{ number_format($firstVariant->price, 0, ',', '.') }} đ</div>
                                                @endif
                                            @else
                                                <div class="price-red fs-5">Liên hệ</div>
                                            @endif
                                        </div>

                                        {{-- Button Nâng cấp --}}
                                        <div class="mt-3">
                                            <form action="{{ route('cart.add') }}" method="POST"
                                                class="d-flex gap-2 mb-2">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <input type="hidden" name="quantity" value="1">
                                                <input type="hidden" name="warranty_fee" value="0">

                                                <button type="submit" name="action" value="add"
                                                    class="btn btn-outline-primary w-50 btn-sm fw-bold px-1"
                                                    title="Thêm vào giỏ">
                                                    <i class="fa-solid fa-cart-plus"></i> Thêm giỏ
                                                </button>

                                                <button type="submit" name="action" value="buy_now"
                                                    class="btn btn-gradient w-50 btn-sm fw-bold px-1"
                                                    title="Thanh toán luôn">
                                                    Mua ngay
                                                </button>
                                            </form>

                                            <a href="{{ route('product.show', $product->slug) }}"
                                                class="btn btn-light w-100 btn-sm border fw-bold text-muted">
                                                <i class="fa-regular fa-eye me-1"></i> Xem chi tiết
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @empty
                        <div class="col-12 text-center py-5">
                            <i class="fa-solid fa-box-open fs-1 text-muted opacity-50 mb-3"></i>
                            <h6 class="text-muted fw-bold">Đang cập nhật sản phẩm...</h6>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
@endsection
