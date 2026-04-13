@extends('layouts.app')

@section('title', 'Đặt hàng thành công - GiaDungShop')

@section('content')
    <div class="container text-center mt-5 mb-5 pb-5" data-aos="zoom-in">
        <i class="fa-solid fa-circle-check text-success mb-3" style="font-size: 5rem;"></i>
        <h2 class="fw-bold text-dark">Đặt hàng thành công!</h2>
        <p class="text-muted">Cảm ơn quý khách đã tin tưởng và mua sắm tại GiaDungShop.</p>

        <div class="card mx-auto shadow-sm mt-4 border-primary border-2" style="max-width: 600px;">
            <div class="card-body bg-light p-4 rounded">
                <p class="mb-1 text-muted fs-5">Mã đơn hàng của bạn là:</p>

                <h1 class="text-primary fw-bold tracking-widest" style="letter-spacing: 2px;">
                    GDS-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                </h1>

                @guest
                    <div class="alert alert-warning mt-4 mb-0 text-start shadow-sm" role="alert">
                        <div class="d-flex">
                            <i class="fa-solid fa-triangle-exclamation text-danger fs-3 me-3 mt-1"></i>
                            <div>
                                <strong class="text-danger d-block mb-1">LƯU Ý QUAN TRỌNG:</strong>
                                Quý khách vui lòng chụp màn hình hoặc ghi lại <b>Mã đơn hàng
                                    (GDS-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }})
                                </b> ở trên. Đây là thông tin bắt buộc
                                để quý khách có thể <a href="{{ route('track.order') }}"
                                    class="text-primary fw-bold text-decoration-none">Tra cứu trạng thái giao hàng</a> sau này.
                            </div>
                        </div>
                    </div>
                @endguest
            </div>
        </div>

        <div class="card mx-auto shadow-sm mt-5 text-start" style="max-width: 800px;">
            <div class="card-header bg-white fw-bold py-3">
                <i class="fa-solid fa-receipt text-secondary me-2"></i> Chi tiết sản phẩm đã đặt
            </div>
            <div class="card-body p-0">
                <table class="table mb-0 align-middle">
                    <tbody>
                        @foreach ($order->items as $item)
                            <tr>
                                <td class="p-3 d-flex gap-3 border-0 border-bottom">
                                    <img src="{{ $item->product->image ? asset($item->product->image) : 'https://placehold.co/100x100' }}"
                                        width="70" height="70" class="rounded border" style="object-fit: cover;">
                                    <div>
                                        <h6 class="mb-1 fw-bold text-dark">{{ $item->product->name }}</h6>

                                        <div class="small text-muted mb-1 bg-light d-inline-block px-2 py-1 rounded border">
                                            <i class="fa-solid fa-shield-halved text-success me-1"></i>
                                            Bảo hành: <strong class="text-dark">{{ $item->product->warranty_months ?? 12 }}
                                                tháng</strong>
                                        </div>

                                        <div class="small text-muted mt-1">Số lượng: {{ $item->quantity }}</div>
                                    </div>
                                </td>
                                <td class="text-end p-3 fw-bold text-dark border-0 border-bottom">
                                    {{ number_format($item->price, 0, ',', '.') }} ₫
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white text-end p-4 border-top-0">
                <span class="text-muted me-3">Tổng thanh toán:</span>
                <strong class="text-danger fs-4">{{ number_format($order->total_amount, 0, ',', '.') }} ₫</strong>
            </div>
        </div>
        @if ($order->note)
            <div class="mt-3 p-3 bg-light rounded border">
                <h6 class="fw-bold mb-1 small"><i class="fa-solid fa-pen-to-square me-2"></i>Thông tin bổ sung:</h6>
                <p class="mb-0 small text-danger fw-bold">{{ $order->note }}</p>
            </div>
        @endif

        <div class="mt-5">
            <a href="/" class="btn btn-outline-primary fw-bold px-5 py-2 me-2" style="border-radius: 30px;">
                <i class="fa-solid fa-house me-2"></i> Về trang chủ
            </a>
            @guest
                <a href="{{ route('track.order') }}" class="btn btn-primary fw-bold px-5 py-2" style="border-radius: 30px;">
                    <i class="fa-solid fa-truck-fast me-2"></i> Tra cứu đơn hàng ngay
                </a>
            @endguest
        </div>
    </div>
@endsection
