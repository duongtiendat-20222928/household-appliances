@extends('layouts.app')

@section('title', 'Đơn hàng của tôi')

@section('content')
    <div class="container mt-4 mb-5">
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="bg-white p-3 rounded shadow-sm border">
                    <div class="d-flex align-items-center gap-3 mb-4 border-bottom pb-3">
                        <i class="fa-solid fa-circle-user text-secondary" style="font-size: 40px;"></i>
                        <div>
                            <p class="mb-0 text-muted small">Tài khoản của</p>
                            <strong class="text-dark">{{ Auth::user()->name }}</strong>
                        </div>
                    </div>
                    <ul class="list-unstyled mb-0 sidebar-menu">
                        <li><a href="#" class="text-dark fw-bold text-meta"><i
                                    class="fa-solid fa-clipboard-list me-2"></i> Đơn hàng của tôi</a></li>
                        <li><a href="#" class="text-dark"><i class="fa-regular fa-user me-2"></i> Thông tin tài
                                khoản</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-9">
                <div class="bg-white p-4 rounded shadow-sm border">
                    <h4 class="fw-bold border-bottom pb-3 mb-4">Đơn hàng của tôi</h4>

                    @if ($orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle border">
                                <thead class="table-light">
                                    <tr>
                                        <th>Mã ĐH</th>
                                        <th>Ngày đặt</th>
                                        <th>Tổng tiền</th>
                                        <th>Trạng thái</th>
                                        <th class="text-center">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td class="fw-bold">#{{ $order->id }}</td>
                                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                            <td class="text-danger fw-bold">
                                                {{ number_format($order->total_amount, 0, ',', '.') }} ₫</td>
                                            <td>
                                                @if ($order->status == 'pending')
                                                    <span class="badge bg-warning text-dark">Chờ xử lý</span>
                                                @elseif($order->status == 'shipping')
                                                    <span class="badge bg-primary">Đang giao</span>
                                                @elseif($order->status == 'completed')
                                                    <span class="badge bg-success">Hoàn thành</span>
                                                @elseif($order->status == 'cancelled')
                                                    <span class="badge bg-danger">Đã hủy</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ $order->status }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('orders.show', $order->id) }}"
                                                    class="btn btn-sm btn-outline-primary">Xem chi tiết</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fa-solid fa-box-open fs-1 text-muted mb-3 opacity-50"></i>
                            <p class="text-muted">Bạn chưa có đơn hàng nào.</p>
                            <a href="/" class="btn btn-primary">Tiếp tục mua sắm</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
