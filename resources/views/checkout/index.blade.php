@extends('layouts.app')

@section('title', 'Thanh toán đơn hàng')

@section('content')
    <div class="container mt-4">
        <h3 class="fw-bold border-bottom pb-2 mb-4">Tiến hành thanh toán</h3>

        <div class="row">
            <div class="col-md-7 mb-4">
                <div class="bg-white p-4 rounded shadow-sm border">
                    <h5 class="fw-bold mb-3">Thông tin giao hàng</h5>

                    @guest
                        <div class="alert alert-info small">
                            Bạn đang mua hàng với tư cách Khách. Bạn có thể điền thông tin bên dưới hoặc <a href="#"
                                class="fw-bold">Đăng nhập</a> để tự động điền.
                        </div>
                    @endguest

                    <form action="#" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Họ và tên người nhận <span class="text-danger">*</span></label>
                            <input type="text" name="receiver_name" class="form-control" placeholder="Nhập họ và tên"
                                value="{{ auth()->check() ? auth()->user()->name : '' }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                                <input type="text" name="receiver_phone" class="form-control"
                                    placeholder="Nhập số điện thoại"
                                    value="{{ auth()->check() ? auth()->user()->phone ?? '' : '' }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="receiver_email" class="form-control"
                                    placeholder="Để gửi hóa đơn (không bắt buộc)"
                                    value="{{ auth()->check() ? auth()->user()->email : '' }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Địa chỉ nhận hàng chi tiết <span class="text-danger">*</span></label>
                            <input type="text" name="shipping_address" class="form-control"
                                placeholder="Số nhà, tên đường, phường/xã, quận/huyện..."
                                value="{{ auth()->check() ? auth()->user()->address ?? '' : '' }}" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Ghi chú đơn hàng</label>
                            <textarea name="note" class="form-control" rows="3" placeholder="Giao trong giờ hành chính, gói quà..."></textarea>
                        </div>

                        <h5 class="fw-bold mb-3">Phương thức thanh toán</h5>
                        <div class="border rounded p-3 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="cod"
                                    value="cod" checked>
                                <label class="form-check-label fw-bold" for="cod">
                                    Thanh toán khi nhận hàng (COD)
                                </label>
                            </div>
                        </div>
                        <div class="border rounded p-3 mb-4 text-muted bg-light">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="vnpay"
                                    value="vnpay" disabled>
                                <label class="form-check-label" for="vnpay">
                                    Chuyển khoản VNPay (Sẽ tích hợp sau)
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-danger btn-lg w-100 fw-bold text-uppercase">Xác nhận đặt
                            hàng</button>
                    </form>
                </div>
            </div>

            <div class="col-md-5">
                <div class="bg-light p-4 rounded shadow-sm border">
                    <h5 class="fw-bold mb-3 border-bottom pb-2">Tóm tắt đơn hàng</h5>

                    <ul class="list-group list-group-flush mb-3">
                        @php $total = 0; @endphp
                        @foreach ($cart as $details)
                            @php $total += $details['price'] * $details['quantity']; @endphp
                            <li
                                class="list-group-item bg-transparent px-0 d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ $details['image'] }}" width="50" class="border rounded">
                                    <div>
                                        <h6 class="mb-0 small fw-bold"
                                            style="max-width: 180px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            {{ $details['name'] }}</h6>
                                        <small class="text-muted">SL: {{ $details['quantity'] }}</small>
                                    </div>
                                </div>
                                <span
                                    class="text-danger fw-bold small">{{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}
                                    ₫</span>
                            </li>
                        @endforeach
                    </ul>

                    <div class="d-flex justify-content-between mb-2 small">
                        <span class="text-muted">Tạm tính:</span>
                        <span class="fw-bold">{{ number_format($total, 0, ',', '.') }} ₫</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 border-bottom pb-3 small">
                        <span class="text-muted">Phí vận chuyển:</span>
                        <span class="fw-bold text-success">Miễn phí</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold fs-5">Tổng cộng:</span>
                        <span class="fw-bold text-danger fs-4">{{ number_format($total, 0, ',', '.') }} ₫</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
