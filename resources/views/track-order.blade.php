@extends('layouts.app')

@section('title', 'Tra cứu đơn hàng')

@section('content')
    <div class="container mt-5 mb-5" style="max-width: 800px;">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white text-center py-4">
                <h4 class="fw-bold mb-0 text-primary"><i class="fa-solid fa-magnifying-glass-location me-2"></i>Tra cứu tình
                    trạng đơn hàng</h4>
                <p class="text-muted mt-2 mb-0 small">Dành cho khách hàng đặt mua không cần tài khoản</p>
            </div>
            <div class="card-body p-4 p-md-5">

                @if (session('error'))
                    <div class="alert alert-danger"><i class="fa-solid fa-circle-exclamation me-2"></i>{{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('track.order.submit') }}" method="POST" class="row g-3">
                    @csrf
                    <div class="col-md-5">
                        <label class="form-label fw-bold">Mã đơn hàng</label>
                        <input type="text" name="order_id" class="form-control" placeholder="VD: 15 hoặc #ORD-15"
                            value="{{ old('order_id') }}" required>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label fw-bold">Số điện thoại đặt hàng</label>
                        <input type="text" name="phone" class="form-control" placeholder="Nhập số điện thoại của bạn"
                            value="{{ old('phone') }}" required>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100 fw-bold">Kiểm tra</button>
                    </div>
                </form>

                <hr class="my-5">

                @if (isset($order))
                    <div class="alert alert-success"><i class="fa-solid fa-check-circle me-2"></i>Tìm thấy đơn hàng
                        <strong>#{{ $order->id }}</strong> của bạn!</div>

                    <div class="row mb-4">
                        <div class="col-sm-6">
                            <p class="mb-1 text-muted">Trạng thái hiện tại:</p>
                            @if ($order->status == 'pending')
                                <span class="badge bg-warning text-dark fs-6">Chờ xử lý</span>
                            @elseif($order->status == 'shipping')
                                <span class="badge bg-primary fs-6">Đang giao hàng</span>
                            @elseif($order->status == 'completed')
                                <span class="badge bg-success fs-6">Hoàn thành</span>
                            @else
                                <span class="badge bg-danger fs-6">Đã hủy</span>
                            @endif
                        </div>
                        <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">
                            <p class="mb-1 text-muted">Ngày đặt hàng:</p>
                            <h6 class="fw-bold">{{ $order->created_at->format('d/m/Y H:i') }}</h6>
                        </div>
                    </div>

                    <div class="border rounded p-3 bg-light mb-4">
                        <p class="mb-1"><strong>Người nhận:</strong> {{ $order->receiver_name }}</p>
                        <p class="mb-1"><strong>Điện thoại:</strong> {{ $order->receiver_phone }}</p>
                        <p class="mb-0"><strong>Địa chỉ:</strong> {{ $order->shipping_address }}</p>
                    </div>

                    <table class="table table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Sản phẩm</th>
                                <th class="text-center">SL</th>
                                <th class="text-end">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $item)
                                <tr>
                                    <td>{{ $item->product_name }}</td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end fw-bold">
                                        {{ number_format($item->price * $item->quantity, 0, ',', '.') }} ₫</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" class="text-end fw-bold">Tổng cộng:</td>
                                <td class="text-end text-danger fw-bold fs-5">
                                    {{ number_format($order->total_amount, 0, ',', '.') }} ₫</td>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="text-center mt-4">
                        <p class="text-muted small">Nếu cần thay đổi hoặc hủy đơn, vui lòng gọi Hotline: <strong>1900
                                xxxx</strong></p>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection
