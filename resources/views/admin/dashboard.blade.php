@extends('admin.layouts.admin')

@section('title', 'Bảng điều khiển (Dashboard)')

@section('content')
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card text-white bg-danger shadow h-100 border-0">
                <div class="card-body">
                    <h6 class="card-title text-uppercase mb-3"><i class="fa-solid fa-sack-dollar me-2"></i> Doanh thu</h6>
                    <h3 class="card-text fw-bold">{{ number_format($totalRevenue, 0, ',', '.') }} ₫</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card text-white bg-primary shadow h-100 border-0">
                <div class="card-body">
                    <h6 class="card-title text-uppercase mb-3"><i class="fa-solid fa-cart-shopping me-2"></i> Đơn hàng</h6>
                    <h3 class="card-text fw-bold">{{ $totalOrders }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card text-white bg-success shadow h-100 border-0">
                <div class="card-body">
                    <h6 class="card-title text-uppercase mb-3"><i class="fa-solid fa-box me-2"></i> Sản phẩm</h6>
                    <h3 class="card-text fw-bold">{{ $totalProducts }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card text-dark bg-warning shadow h-100 border-0">
                <div class="card-body">
                    <h6 class="card-title text-uppercase mb-3"><i class="fa-solid fa-users me-2"></i> Khách hàng</h6>
                    <h3 class="card-text fw-bold">{{ $totalCustomers }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow border-0 mt-2">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-primary"><i class="fa-solid fa-clock-rotate-left me-2"></i> 5 Đơn hàng gần nhất</h6>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">Xem tất cả đơn hàng</a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">Mã ĐH</th>
                            <th>Khách hàng</th>
                            <th>Thời gian</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                            <tr>
                                <td class="ps-3 fw-bold text-primary">#ORD-{{ $order->id }}</td>
                                <td>{{ $order->receiver_name }}</td>
                                <td>{{ \Carbon\Carbon::parse($order->created_at)->diffForHumans() }}</td>
                                <td class="fw-bold text-danger">{{ number_format($order->total_amount, 0, ',', '.') }} ₫
                                </td>
                                <td>
                                    @if ($order->status == 'pending')
                                        <span class="badge bg-warning text-dark">Chờ xử lý</span>
                                    @elseif($order->status == 'shipping')
                                        <span class="badge bg-info text-dark">Đang giao</span>
                                    @elseif($order->status == 'completed')
                                        <span class="badge bg-success">Hoàn thành</span>
                                    @else
                                        <span class="badge bg-secondary">Đã hủy</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">Chưa có đơn hàng nào phát sinh.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
