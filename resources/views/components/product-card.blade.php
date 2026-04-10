<div class="col-md-4 col-sm-6" data-aos="zoom-in-up">
    <div class="card h-100 border product-card position-relative overflow-hidden">

        <div class="discount-badge">-15%</div>

        <a href="{{ route('product.show', $product->slug) }}" class="overflow-hidden p-3 d-block">
            <img src="{{ $product->image ? asset($product->image) : 'https://placehold.co/400x400?text=No+Image' }}"
                class="card-img-top" style="object-fit: contain; height: 220px; transition: 0.5s;"
                onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
        </a>

        <div class="card-body px-3 pt-2 pb-3 d-flex flex-column bg-white">
            <a href="{{ route('product.show', $product->slug) }}" class="text-decoration-none text-dark">
                <h6 class="card-title fw-bold"
                    style="font-size: 15px; -webkit-line-clamp: 2; display: -webkit-box; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.4;">
                    {{ $product->name }}
                </h6>
            </a>

            <div class="text-warning mb-2" style="font-size: 12px;">
                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                    class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i>
                <span class="text-muted ms-1">(99+)</span>
            </div>

            <div class="mb-3 text-muted bg-light px-2 py-1 rounded small">
                <i class="fa-solid fa-box-archive me-1 text-primary"></i>
                @if ($product->stock > 0)
                    Còn: <strong class="text-success">{{ $product->stock }}</strong> sp
                @else
                    <strong class="text-danger">Hết hàng</strong>
                @endif
            </div>

            <div class="mt-auto">
                <div class="mb-3">
                    @if ($product->variants->isNotEmpty())
                        @php $firstVariant = $product->variants->first(); @endphp
                        @if ($firstVariant->sale_price)
                            <div class="price-red fs-5 mb-1">{{ number_format($firstVariant->sale_price, 0, ',', '.') }}
                                đ</div>
                            <div class="price-old d-inline-block px-1 rounded">
                                {{ number_format($firstVariant->price, 0, ',', '.') }} đ</div>
                        @else
                            <div class="price-red fs-5">{{ number_format($firstVariant->price, 0, ',', '.') }} đ</div>
                        @endif
                    @else
                        <div class="price-red fs-5">Liên hệ</div>
                    @endif
                </div>

                <div class="mt-3">
                    <form action="{{ route('cart.add') }}" method="POST" class="d-flex gap-2 mb-2">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <input type="hidden" name="warranty_fee" value="0">
                        <button type="submit" name="action" value="add"
                            class="btn btn-outline-primary w-50 btn-sm fw-bold px-1" title="Thêm vào giỏ"
                            {{ $product->stock <= 0 ? 'disabled' : '' }}>
                            <i class="fa-solid fa-cart-plus"></i> Thêm giỏ
                        </button>
                        <button type="submit" name="action" value="buy_now"
                            class="btn btn-gradient w-50 btn-sm fw-bold px-1" title="Thanh toán luôn"
                            {{ $product->stock <= 0 ? 'disabled' : '' }}>
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
