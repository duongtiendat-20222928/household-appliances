@extends('layouts.app')

@section('title', 'Kết quả tra cứu đơn hàng - GiaDungShop')

@section('content')
    <div class="container mt-5 mb-5 pb-5" data-aos="fade-up">

        <div class="text-center mb-4">
            <h3 class="fw-bold text-uppercase"><i class="fa-solid fa-magnifying-glass text-primary me-2"></i> Kết quả tra cứu
            </h3>
            <p class="text-muted">Thông tin chi tiết đơn hàng của bạn</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">Mã đơn: <span
                                class="text-primary">GDS-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span></h5>
                        <span
                            class="badge bg-{{ $order->status == 'pending' ? 'warning text-dark' : ($order->status == 'completed' ? 'success' : 'info') }} fs-6">
                            @if ($order->status == 'pending')
                                Chờ xử lý
                            @elseif($order->status == 'processing')
                                Đang chuẩn bị hàng
                            @elseif($order->status == 'shipping')
                                Đang giao hàng
                            @elseif($order->status == 'completed')
                                Đã giao thành công
                            @elseif($order->status == 'cancelled')
                                Đã hủy
                            @else
                                {{ $order->status }}
                            @endif
                        </span>
                    </div>
                    <div class="card-body bg-light">
                        <div class="row">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <h6 class="fw-bold text-secondary mb-2">Thông tin người nhận:</h6>
                                <p class="mb-1"><strong>Họ tên:</strong> {{ $order->receiver_name }}</p>
                                <p class="mb-1"><strong>Điện thoại:</strong> {{ $order->receiver_phone }}</p>
                                <p class="mb-0"><strong>Địa chỉ:</strong> {{ $order->shipping_address }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold text-secondary mb-2">Thông tin thanh toán:</h6>
                                <p class="mb-1"><strong>Phương thức:</strong>
                                    {{ $order->payment_method == 'cod' ? 'Thanh toán khi nhận hàng (COD)' : 'Chuyển khoản / VNPay' }}
                                </p>
                                <p class="mb-0"><strong>Ngày đặt hàng:</strong>
                                    {{ $order->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white fw-bold py-3">
                        <i class="fa-solid fa-box-open text-secondary me-2"></i> Sản phẩm đã đặt
                    </div>
                    <div class="card-body p-0 table-responsive">
                        <table class="table table-bordered mb-0 align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th class="text-center" width="80">SL</th>
                                    <th class="text-end" width="150">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td class="p-3">
                                            <div class="d-flex align-items-center gap-3">
                                                <img src="{{ $item->product->image ? asset($item->product->image) : 'https://placehold.co/80x80' }}"
                                                    width="60" height="60" class="rounded border"
                                                    style="object-fit: cover;">
                                                <div>
                                                    <div class="fw-bold text-dark">
                                                        {{ $item->product_name ?? $item->product->name }}</div>

                                                    <div
                                                        class="small text-muted mt-1 bg-light d-inline-block px-2 py-1 rounded border">
                                                        <i class="fa-solid fa-shield-halved text-success me-1"></i>
                                                        Bảo hành: <strong
                                                            class="text-dark">{{ $item->product->warranty_months ?? 12 }}
                                                            tháng</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center fw-bold">{{ $item->quantity }}</td>
                                        <td class="text-end fw-bold text-dark">
                                            {{ number_format($item->price * $item->quantity, 0, ',', '.') }} ₫
                                        </td>
                                    </tr>
                                @endforeach

                                @if ($order->note)
                                    <tr>
                                        <td colspan="3" class="bg-light p-3">
                                            <span class="text-danger small fw-bold"><i
                                                    class="fa-solid fa-pen-to-square me-1"></i> Ghi chú / Dịch vụ
                                                thêm:</span>
                                            <span class="small fw-bold text-dark">{{ $order->note }}</span>
                                        </td>
                                    </tr>
                                @endif

                                <tr>
                                    <td colspan="2" class="text-end fw-bold py-3">Tổng thanh toán:</td>
                                    <td class="text-end text-danger fw-bold fs-4 py-3">
                                        {{ number_format($order->total_amount, 0, ',', '.') }} ₫
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('track.order') }}" class="btn btn-outline-primary px-4 fw-bold"
                        style="border-radius: 30px;">
                        <i class="fa-solid fa-arrow-left me-2"></i> Tra cứu đơn khác
                    </a>
                </div>

            </div>
        </div>
    </div>
@endsection
