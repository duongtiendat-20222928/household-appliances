@extends('layouts.app')

@section('content')
    <div class="row">

        <div class="col-lg-3 d-none d-lg-block">
            <div class="bg-white p-3 rounded shadow-sm border">
                <h6 class="fw-bold mb-3 border-bottom pb-2"><i class="fa-solid fa-bars me-2"></i> DANH MỤC GIA DỤNG</h6>
                <ul class="list-unstyled sidebar-menu mb-0" style="font-size: 14px;">
                    @if (isset($categories))
                        @foreach ($categories as $cat)
                            <li>
                                <a href="{{ route('category.show', $cat->id) }}"
                                    class="text-decoration-none text-dark d-block py-2 border-bottom">
                                    <i class="fa-solid fa-angle-right me-2 text-muted"></i> {{ $cat->name }}
                                </a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>

        <div class="col-lg-9">

            <div class="mb-4">
                <img src="{{ asset('images/banners/download.jpg') }}" class="img-fluid rounded shadow-sm w-100"
                    alt="Banner Khuyến Mãi Gia Dụng Mua Hè">
            </div>

            <div class="bg-white p-3 rounded shadow-sm border mb-4">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                    <h5 class="fw-bold m-0 text-uppercase"><i class="fa-solid fa-fire text-danger me-2"></i> Sản phẩm nổi
                        bật</h5>
                    <a href="#" class="text-decoration-none text-meta small">Xem tất cả ></a>
                </div>

                <div class="row g-3">
                    @forelse($products as $product)
                        <div class="col-md-4 col-sm-6">
                            <div class="card h-100 border product-card position-relative">

                                <div class="discount-badge">-15%</div>

                                <a href="{{ route('product.show', $product->slug) }}">
                                    <img src="{{ $product->image ? asset($product->image) : 'https://placehold.co/400x400?text=No+Image' }}"
                                        class="card-img-top p-3" alt="{{ $product->name }}"
                                        style="object-fit: contain; height: 250px;"
                                        onerror="this.onerror=null; this.src='https://placehold.co/400x400?text=Anh+Bi+Loi';">
                                </a>

                                <div class="card-body px-3 pt-0 pb-3 d-flex flex-column">
                                    <a href="{{ route('product.show', $product->slug) }}"
                                        class="text-decoration-none text-dark">
                                        <h6 class="card-title"
                                            style="font-size: 14px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                            {{ $product->name }}
                                        </h6>
                                    </a>

                                    <div class="text-warning mb-2" style="font-size: 12px;">
                                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                            class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                            class="fa-solid fa-star-half-stroke"></i>
                                    </div>

                                    <div class="mt-auto">
                                        <div class="mb-3">
                                            @if ($product->variants->isNotEmpty())
                                                @php $firstVariant = $product->variants->first(); @endphp
                                                @if ($firstVariant->sale_price)
                                                    <div class="price-red fs-5">
                                                        {{ number_format($firstVariant->sale_price, 0, ',', '.') }} đ</div>
                                                    <div class="price-old">
                                                        {{ number_format($firstVariant->price, 0, ',', '.') }} đ</div>
                                                @else
                                                    <div class="price-red fs-5">
                                                        {{ number_format($firstVariant->price, 0, ',', '.') }} đ</div>
                                                @endif
                                            @else
                                                <div class="price-red fs-5">Liên hệ</div>
                                            @endif
                                        </div>

                                        <a href="{{ route('product.show', $product->slug) }}"
                                            class="btn btn-outline-primary w-100 btn-sm fw-bold">
                                            Xem chi tiết
                                        </a>
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
