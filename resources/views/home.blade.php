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
            {{-- BANNER --}}
            <div id="heroBanner" class="carousel slide carousel-fade mb-4 shadow rounded overflow-hidden"
                data-bs-ride="carousel" data-bs-interval="3500" data-aos="fade-down">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('images/banners/banner.jpg') }}" class="d-block w-100"
                            style="object-fit: cover; height: 400px;">
                    </div>
                </div>
            </div>

            {{-- KHỐI SẢN PHẨM NỔI BẬT --}}
            <div class="bg-white p-4 rounded shadow-sm border mb-4" data-aos="fade-up">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-4">
                    <h4 class="fw-bold m-0 text-uppercase text-dark">
                        <i class="fa-solid fa-fire text-danger me-2" style="animation: pulse-red 1s infinite;"></i> Sản phẩm
                        nổi bật
                    </h4>
                </div>

                <div class="row g-4">
                    @forelse($featuredProducts as $product)
                        @include('components.product-card', ['product' => $product])
                    @empty
                        <div class="col-12 text-center py-4">
                            <p class="text-muted">Chưa có sản phẩm nổi bật</p>
                        </div>
                    @endforelse
                </div>
                <div class="bg-white p-4 rounded shadow-sm border mb-4" data-aos="fade-up">
                    <div class="d-flex align-items-center mb-3">
                        <span class="fs-3 me-2">😎</span>
                        <h4 class="fw-bold m-0 text-uppercase text-dark">#CHỦ ĐỀ</h4>
                    </div>

                    <div class="d-flex gap-2 mb-4 overflow-auto pb-2" style="white-space: nowrap;">
                        <a href="#" class="btn btn-outline-primary px-4 fw-bold active"
                            style="border-radius: 8px;">Khuyến mãi</a>
                        <a href="#" class="btn btn-outline-secondary px-4 text-dark"
                            style="border-radius: 8px; border-color: #ddd;">Mạng xã hội GiaDungShop</a>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-3 col-sm-6">
                            <a href="#" class="text-decoration-none text-dark d-block card border-0 h-100 hover-zoom">
                                <div class="overflow-hidden rounded mb-2">
                                    <img src="https://placehold.co/400x225/0052cc/ffffff?text=SALE+TO+GIA+RE"
                                        class="w-100 rounded" style="transition: 0.3s; object-fit: cover; height: 140px;"
                                        alt="News">
                                </div>
                                <p class="fw-bold mb-0"
                                    style="font-size: 14px; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                    SALE TO GIÁ RẺ. Duy nhất 17H ngày 04/04 Cơ hội Trúng Máy lạnh 1 HP/ Quạt hộp trị giá lên
                                    đến 5,49 triệu
                                </p>
                            </a>
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <a href="#" class="text-decoration-none text-dark d-block card border-0 h-100 hover-zoom">
                                <div class="overflow-hidden rounded mb-2">
                                    <img src="https://placehold.co/400x225/00a8ff/ffffff?text=SAMSUNG+TV"
                                        class="w-100 rounded" style="transition: 0.3s; object-fit: cover; height: 140px;"
                                        alt="News">
                                </div>
                                <p class="fw-bold mb-0"
                                    style="font-size: 14px; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                    Đặt Trước Bộ Đôi Xuất Sắc Tivi Samsung Mini LED M8X & OLED S85H Mới 2026: Nhận Quà Tặng
                                    Khủng, Trả chậm 0%
                                </p>
                            </a>
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <a href="#" class="text-decoration-none text-dark d-block card border-0 h-100 hover-zoom">
                                <div class="overflow-hidden rounded mb-2">
                                    <img src="https://placehold.co/400x225/555555/ffffff?text=SONY+HT-S60"
                                        class="w-100 rounded" style="transition: 0.3s; object-fit: cover; height: 140px;"
                                        alt="News">
                                </div>
                                <p class="fw-bold mb-0"
                                    style="font-size: 14px; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                    Mua dàn âm thanh Sony HT-S60 tặng bộ chân đế loa rear System 6 chính hãng
                                </p>
                            </a>
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <a href="#" class="text-decoration-none text-dark d-block card border-0 h-100 hover-zoom">
                                <div class="overflow-hidden rounded mb-2">
                                    <img src="https://placehold.co/400x225/ffcc00/333333?text=BAO+HANH+MO+RONG"
                                        class="w-100 rounded" style="transition: 0.3s; object-fit: cover; height: 140px;"
                                        alt="News">
                                </div>
                                <p class="fw-bold mb-0"
                                    style="font-size: 14px; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                    Tổng hợp các gói dịch vụ bảo hành mở rộng, bảo hành 1 đổi 1 và gói vệ sinh máy lạnh
                                    chuyên nghiệp
                                </p>
                            </a>
                        </div>
                    </div>

                    <div class="text-center mt-4 pt-2">
                        <a href="#" class="text-decoration-none fw-bold" style="color: #007bff; font-size: 15px;">
                            Xem thêm <i class="fa-solid fa-chevron-right ms-1" style="font-size: 12px;"></i>
                        </a>
                    </div>
                </div>
                <div class="text-center mt-5">
                    <a href="{{ route('products.index') }}" class="btn btn-outline-primary btn-lg fw-bold px-5"
                        style="border-radius: 30px;">
                        Xem tất cả sản phẩm <i class="fa-solid fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
