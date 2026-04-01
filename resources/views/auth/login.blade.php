@extends('layouts.app')

@section('title', 'Đăng nhập - GiaDungShop')

@section('content')
    <div class="row justify-content-center mt-5 mb-5">
        <div class="col-md-5">
            <div class="card shadow border-0 rounded-3">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-meta"><i class="fa-solid fa-circle-user me-2"></i>ĐĂNG NHẬP</h3>
                        <p class="text-muted small">Vui lòng đăng nhập để quản lý đơn hàng</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger py-2 small">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('login.post') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Email của bạn <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                                placeholder="Ví dụ: nguyenvanA@gmail.com" required>
                        </div>
                        <div class="mb-4">
                            <div class="d-flex justify-content-between">
                                <label class="form-label fw-bold small">Mật khẩu <span class="text-danger">*</span></label>
                                <a href="#" class="text-decoration-none small text-meta">Quên mật khẩu?</a>
                            </div>
                            <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu"
                                required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 fw-bold py-2 text-uppercase">Đăng nhập</button>
                    </form>

                    <div class="text-center mt-4 pt-3 border-top small">
                        Chưa có tài khoản? <a href="{{ route('register') }}"
                            class="text-decoration-none text-danger fw-bold">Đăng ký ngay</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
