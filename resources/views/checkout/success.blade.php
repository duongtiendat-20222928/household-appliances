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

                    <div class="d-flex justify-content-center gap-3">
                        <a href="/" class="btn btn-outline-primary fw-bold px-4">
                            <i class="fa-solid fa-house me-2"></i> Về trang chủ
                        </a>
                        <a href="#" class="btn btn-danger fw-bold px-4">
                            <i class="fa-solid fa-clipboard-list me-2"></i> Xem đơn hàng
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
