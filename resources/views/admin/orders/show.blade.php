@extends('admin.layouts.admin')

@section('title', 'Chi tiết Đơn hàng #ORD-' . $order->id)

@section('content')
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow border-0 mb-4">
                <div class="card-header bg-white fw-bold"><i class="fa-solid fa-user me-2"></i>Thông tin nhận hàng</div>
                <div class="card-body">
                    <p><strong>Người nhận:</strong> {{ $order->receiver_name }}</p>
                    <p><strong>Điện thoại:</strong> {{ $order->receiver_phone }}</p>
                    <p><strong>Địa chỉ:</strong> {{ $order->shipping_address }}</p>
                    <p><strong>Ghi chú:</strong> {{ $order->note ?? 'Không có' }}</p>
                </div>
            </div>

            <div class="card shadow border-0">
                <div class="card-header bg-white fw-bold"><i class="fa-solid fa-truck-fast me-2"></i>Cập nhật Trạng thái</div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success py-2">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <select name="status" class="form-select mb-3">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                            <option value="shipping" {{ $order->status == 'shipping' ? 'selected' : '' }}>Đang giao hàng
                            </option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Đã hoàn thành
                            </option>
                            <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Hủy đơn</option>
                        </select>
                        <button type="submit" class="btn btn-success w-100 fw-bold">Lưu trạng thái</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-header bg-white fw-bold"><i class="fa-solid fa-box-open me-2"></i>Sản phẩm đã đặt</div>
                <div class="card-body p-0">
                    <table class="table mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Sản phẩm</th>
                                <th class="text-center">Đơn giá</th>
                                <th class="text-center">Số lượng</th>
                                <th class="text-end pe-3">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $item)
                                <tr>
                                    <td class="ps-3 fw-bold">{{ $item->product_name }}</td>
                                    <td class="text-center">{{ number_format($item->price, 0, ',', '.') }} ₫</td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end pe-3 fw-bold">
                                        {{ number_format($item->price * $item->quantity, 0, ',', '.') }} ₫</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="3" class="text-end fw-bold">Tổng thanh toán:</td>
                                <td class="text-end pe-3 fw-bold text-danger fs-5">
                                    {{ number_format($order->total_amount, 0, ',', '.') }} ₫</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
