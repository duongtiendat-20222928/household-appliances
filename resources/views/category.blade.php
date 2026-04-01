@extends('layouts.app')

@section('title', $currentCategory->name . ' - GiaDungShop')

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
                                    class="{{ $currentCategory->id == $cat->id ? 'text-danger fw-bold' : 'text-dark' }}">
                                    <i class="fa-solid fa-angle-right me-2 text-muted"></i> {{ $cat->name }}
                                </a>
                            </li>
                        @endforeach
                    @endif
                </ul>
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
                                                        {{ number_format($
