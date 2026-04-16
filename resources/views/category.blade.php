@extends('layouts.app')

@section('title', $currentCategory->name . ' - GiaDungShop')

@section('content')
    <div class="row">
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-bold text-primary">
                    <i class="fa-solid fa-bars me-2"></i> DANH MỤC SẢN PHẨM
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush" id="categoryList">
                        @foreach ($categories as $index => $category)
                            <a href="{{ route('category.show', $category->id ?? ($category->slug ?? 1)) }}"
                                class="list-group-item list-group-item-action border-0 category-item {{ $index >= 5 ? 'd-none' : '' }}">
                                <i class="fa-solid fa-caret-right text-primary me-2"></i> {{ $category->name }}
                            </a>
                        @endforeach
                    </ul>

                    @if (count($categories) > 5)
                        <div class="text-center py-2 border-top bg-light">
                            <button type="button" class="btn btn-sm text-primary fw-bold w-100" id="toggleCategoriesBtn"
                                style="box-shadow: none;">
                                Xem thêm <i class="fa-solid fa-angle-down ms-1"></i>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="bg-white p-3 rounded shadow-sm border mb-4">
                <h5 class="fw-bold m-0 border-bottom pb-3 mb-3 text-uppercase">
                    <i class="fa-solid fa-folder-open text-meta me-2"></i>
                    Danh mục: <span class="text-danger">{{ $currentCategory->name }}</span>
                </h5>

                <div class="row g-3">
                    @forelse($products as $product)
                        <div class="col-md-4 col-sm-6">
                            <div class="card h-100 border product-card position-relative">
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
                                            class="btn btn-outline-primary w-100 btn-sm fw-bold">Xem chi tiết</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <i class="fa-solid fa-box-open fs-1 text-muted opacity-50 mb-3"></i>
                            <h5 class="text-muted fw-bold">Danh mục này hiện đang trống!</h5>
                            <p class="text-muted small">Chúng tôi đang cập nhật thêm sản phẩm, bạn quay lại sau nhé.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('toggleCategoriesBtn');
            if (btn) {
                btn.addEventListener('click', function() {
                    // Tìm tất cả các danh mục đang bị ẩn
                    let hiddenItems = document.querySelectorAll('.category-item.d-none');

                    if (hiddenItems.length > 0) {
                        // Nếu đang có mục bị ẩn -> Mở rộng hết ra
                        hiddenItems.forEach(item => item.classList.remove('d-none'));
                        btn.innerHTML = 'Thu gọn <i class="fa-solid fa-angle-up ms-1"></i>';
                    } else {
                        // Nếu đang hiện đầy đủ -> Ẩn bớt từ mục thứ 6 trở đi
                        let allItems = document.querySelectorAll('.category-item');
                        allItems.forEach((item, index) => {
                            if (index >= 5) item.classList.add('d-none');
                        });
                        btn.innerHTML = 'Xem thêm <i class="fa-solid fa-angle-down ms-1"></i>';
                    }
                });
            }
        });
    </script>
@endsection
