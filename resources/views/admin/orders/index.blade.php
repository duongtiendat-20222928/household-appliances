@extends('admin.layouts.admin')

@section('title', 'Quản lý Đơn hàng')

@section('content')
    <div class="card shadow border-0">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 fw-bold text-primary"><i class="fa-solid fa-clipboard-list me-2"></i>Danh sách Đơn hàng gần đây
            </h6>
        </div>
        <div class="card-body">

            @if (session('success'))
                <div class="alert alert-success"><i class="fa-solid fa-check me-2"></i>{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle border">
                    <thead class="table-light">
                        <tr>
                            <th>Mã ĐH</th>
                            <th>Khách hàng</th>
                            <th>Số điện thoại</th>
                            <th>Ngày đặt</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td class="fw-bold text-primary">#ORD-{{ $order->id }}</td>
                                <td>{{ $order->receiver_name }}</td>
                                <td>{{ $order->receiver_phone }}</td>
                                <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i') }}</td>
                                <td class="fw-bold text-danger">{{ number_format($order->total_amount, 0, ',', '.') }} ₫
                                </td>
                                <td>
                                    @if ($order->status == 'pending')
                                        <span class="badge bg-warning text-dark">Chờ xử lý</span>
                                    @elseif($order->status == 'shipping')
                                        <span class="badge bg-info text-dark">Đang giao hàng</span>
                                    @elseif($order->status == 'completed')
                                        <span class="badge bg-success">Đã hoàn thành</span>
                                    @else
                                        <span class="badge bg-danger">Đã hủy</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.orders.show', $order->id) }}"
                                        class="btn btn-sm btn-primary">Xem chi tiết</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
