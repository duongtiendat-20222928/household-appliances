<div class="col-lg-3 col-md-4 col-sm-6 mb-3">
    <div class="card h-100 border product-card hover-shadow" style="transition: 0.3s;">
        <a href="{{ route('product.show', $product->slug) }}" class="text-center">
            <img src="{{ $product->image ? asset($product->image) : 'https://placehold.co/400x400?text=No+Image' }}"
                class="card-img-top p-3" alt="{{ $product->name }}" style="object-fit: contain; height: 180px;"
                onerror="this.onerror=null; this.src='https://placehold.co/400x400?text=Anh+Bi+Loi';">
        </a>

        <div class="card-body px-3 pt-0 pb-3 d-flex flex-column">
            <a href="{{ route('product.show', $product->slug) }}" class="text-decoration-none text-dark mb-2">
                <h6 class="card-title fw-bold"
                    style="font-size: 14px; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 38px;">
                    {{ $product->name }}
                </h6>
            </a>

            <div class="d-flex justify-content-between align-items-center mb-2" style="font-size: 12px;">
                <div class="text-warning">
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                        class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i>
                </div>
                <span class="text-muted">Kho: <strong>{{ $product->stock ?? 10 }}</strong></span>
            </div>

            <div class="mt-auto mb-3">
                @if ($product->variants && $product->variants->isNotEmpty())
                    @php $firstVariant = $product->variants->first(); @endphp
                    <div class="text-danger fw-bold fs-6">
                        {{ number_format($firstVariant->sale_price ?? $firstVariant->price, 0, ',', '.') }} ₫
                    </div>
                    @if ($firstVariant->sale_price)
                        <div class="text-muted text-decoration-line-through" style="font-size: 12px;">
                            {{ number_format($firstVariant->price, 0, ',', '.') }} ₫
                        </div>
                    @endif
                @else
                    <div class="text-danger fw-bold fs-6">Liên hệ</div>
                @endif
            </div>

            <div class="d-flex gap-1 mt-auto">
                <button class="btn btn-outline-primary btn-sm flex-fill fw-bold px-1" title="Thêm vào giỏ">
                    <i class="fa-solid fa-cart-plus"></i>
                </button>
                <a href="{{ route('product.show', $product->slug) }}"
                    class="btn btn-primary btn-sm flex-fill fw-bold px-1" style="font-size: 13px;">
                    Mua ngay
                </a>
            </div>
        </div>
    </div>
</div>