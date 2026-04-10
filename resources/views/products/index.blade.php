@extends('layouts.app')

@section('title', 'Tất cả sản phẩm - GiaDungShop')

@section('content')
    <div class="row">
        <div class="col-lg-3 d-none d-lg-block">
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
@endsection
