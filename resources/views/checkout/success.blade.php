@extends('layouts.app')

@section('title', 'Đặt hàng thành công')

@section('content')
    <div class="container mt-5 mb-5 text-center">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="bg-white p-5 rounded shadow-sm border">
                    <div class="mb-4">
                        <i class="fa-solid fa-circle-check text-success" style="font-size: 80px;"></i>
                    </div>

                    <h3 class="fw-bold text-success mb-3">ĐẶT HÀNG THÀNH CÔNG!</h3>
                    <p class="text-muted mb-4">
                        Cảm ơn bạn đã tin tưởng và mua sắm tại GiaDungShop. Đơn hàng của bạn đã được ghi nhận và đang chờ xử
                        lý. Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất.
                    </p>

                    <div class="d-flex justify-content-center gap-3 mt-4">
                        <a href="{{ route('home') }}" class="btn btn-outline-primary px-4 fw-bold">
                            <i class="fa-solid fa-house me-1"></i> Về trang chủ
                        </a>

                        @auth
                            <a href="{{ route('orders.index') }}" class="btn btn-danger px-4 fw-bold">
                                <i class="fa-solid fa-clipboard-list me-1"></i> Xem đơn hàng
                            </a>
                        @else
                            <a href="{{ route('track.order') }}" class="btn btn-danger px-4 fw-bold">
                                <i class="fa-solid fa-magnifying-glass-location me-1"></i> Tra cứu đơn hàng
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
