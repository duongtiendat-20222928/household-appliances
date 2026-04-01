@extends('layouts.app')

@section('title', 'Đăng ký tài khoản - GiaDungShop')

@section('content')
    <div class="row justify-content-center mt-5 mb-5">
        <div class="col-md-5">
            <div class="card shadow border-0 rounded-3">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-danger"><i class="fa-solid fa-user-plus me-2"></i>ĐĂNG KÝ</h3>
                        <p class="text-muted small">Tạo tài khoản để nhận nhiều ưu đãi</p>
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

                    <form action="{{ route('register.post') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                placeholder="Nhập đầy đủ họ tên" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                                placeholder="Sử dụng email có thật" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold small">Mật khẩu <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" placeholder="Ít nhất 6 ký tự"
                                required minlength="6">
                        </div>
                        <button type="submit" class="btn btn-danger w-100 fw-bold py-2 text-uppercase">Tạo tài
                            khoản</button>
                    </form>

                    <div class="text-center mt-4 pt-3 border-top small">
                        Đã có tài khoản? <a href="{{ route('login') }}" class="text-decoration-none text-meta fw-bold">Đăng
                            nhập tại đây</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
