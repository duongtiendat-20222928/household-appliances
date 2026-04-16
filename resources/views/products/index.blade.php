@extends('layouts.app')

@section('title', 'Tất cả sản phẩm - GiaDungShop')

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
            <div class="bg-white p-4 rounded shadow-sm border mb-4">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-4">
                    <h4 class="fw-bold m-0 text-uppercase text-dark">
                        <i class="fa-solid fa-boxes-stacked text-primary me-2"></i> Tất cả sản phẩm
                    </h4>
                </div>

                <div class="row g-4">
                    @forelse($products as $product)
                        @include('components.product-card', ['product' => $product])
                    @empty
                        <div class="col-12 text-center py-5">
                            <i class="fa-solid fa-box-open fs-1 text-muted opacity-50 mb-3"></i>
                            <h6 class="text-muted fw-bold">Chưa có sản phẩm nào...</h6>
                        </div>
                    @endforelse
                </div>

                <div class="d-flex justify-content-center mt-5">
                    {{ $products->links() }}
                </div>
            </div>
        </div>

    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('toggleCategoriesBtn');
            if (btn) {
                btn.addEventListener('click', function() {
                    let hiddenItems = document.querySelectorAll('.category-item.d-none');
                    if (hiddenItems.length > 0) {
                        hiddenItems.forEach(item => item.classList.remove('d-none'));
                        btn.innerHTML = 'Thu gọn <i class="fa-solid fa-angle-up ms-1"></i>';
                    } else {
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
