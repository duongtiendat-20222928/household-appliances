@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng #' . $order->id)

@section('content')
    <div class="container mt-4 mb-5">
        <div class="bg-white p-4 rounded shadow-sm border">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
                <h4 class="fw-bold m-0">Chi tiết đơn hàng <span class="text-meta">#{{ $order->id }}</span></h4>
                <span class="badge {{ $order->status == 'pending' ? 'bg-warning text-dark' : 'bg-success' }} fs-6">
                    {{ $order->status == 'pending' ? 'Chờ xử lý' : $order->status }}
                </span>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <h6 class="fw-bold text-uppercase border-bottom pb-2">Thông tin người nhận</h6>
                    <p class="mb-1"><strong>Họ tên:</strong> {{ $order->receiver_name }}</p>
                    <p class="mb-1"><strong>Điện thoại:</strong> {{ $order->receiver_phone }}</p>
                    <p class="mb-1"><strong>Email:</strong> {{ $order->receiver_email ?? 'Không có' }}</p>
                    <p class="mb-1"><strong>Địa chỉ:</strong> {{ $order->shipping_address }}</p>
                    <p class="mb-0"><strong>Ghi chú:</strong> {{ $order->note ?? 'Không có' }}</p>
                </div>
                <div class="col-md-6 mt-4 mt-md-0">
                    <h6 class="fw-bold text-uppercase border-bottom pb-2">Thông tin thanh toán</h6>
                    <p class="mb-1"><strong>Phương thức:</strong>
                        {{ $order->payment_method == 'cod' ? 'Thanh toán khi nhận hàng (COD)' : $order->payment_method }}
                    </p>
                    <p class="mb-1"><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i:s') }}</p>
                </div>
            </div>

            <h6 class="fw-bold text-uppercase border-bottom pb-2 mb-3">Sản phẩm đã mua</h6>
            <div class="table-responsive">
                <table class="table border align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Tên sản phẩm</th>
                            <th class="text-center">Đơn giá</th>
                            <th class="text-center">Số lượng</th>
                            <th class="text-end">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $item)
                            <tr>
                                <td>{{ $item->product_name }}</td>
                                <td class="text-center">{{ number_format($item->price, 0, ',', '.') }} ₫</td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-end text-danger fw-bold">
                                    {{ number_format($item->price * $item->quantity, 0, ',', '.') }} ₫</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light fw-bold">
                        <tr>
                            <td colspan="3" class="text-end">Phí vận chuyển:</td>
                            <td class="text-end text-success">Miễn phí</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end fs-5">Tổng cộng:</td>
                            <td class="text-end text-danger fs-5">{{ number_format($order->total_amount, 0, ',', '.') }} ₫
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="mt-4 text-center">
                <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary px-4"><i
                        class="fa-solid fa-arrow-left me-2"></i> Quay lại danh sách</a>
            </div>
        </div>
    </div>
@endsection
