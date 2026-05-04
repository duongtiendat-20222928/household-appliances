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

        <div class="col-md-3 mb-4">
            <div class="card text-white bg-info shadow h-100 border-0">
                <div class="card-body">
                    <h6 class="card-title text-uppercase mb-3"><i class="fa-solid fa-boxes-stacked me-2"></i> Sản phẩm đã
                        bán</h6>
                    <h3 class="card-text fw-bold">{{ number_format($totalProductsSold, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow border-0 mt-2">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-primary"><i class="fa-solid fa-chart-pie me-2"></i> Biểu đồ sản phẩm bán chạy &
                doanh thu</h6>
        </div>
        <div class="card-body">
            <canvas id="topProductsChart" height="160"></canvas>
        </div>
    </div>

    <div class="card shadow border-0 mt-2">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-primary"><i class="fa-solid fa-chart-line me-2"></i> Top 5 sản phẩm bán chạy</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">Sản phẩm</th>
                            <th>Số lượng đã bán</th>
                            <th>Doanh thu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topProducts as $product)
                            <tr>
                                <td class="ps-3 fw-bold">{{ $product->product_name }}</td>
                                <td>{{ number_format($product->total_sold, 0, ',', '.') }}</td>
                                <td class="fw-bold text-danger">{{ number_format($product->total_revenue, 0, ',', '.') }} ₫
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-muted">Chưa có sản phẩm nào được bán hoàn
                                    thành.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const topProductsLabels = @json($topProducts->pluck('product_name'));
        const topProductsQty = @json($topProducts->pluck('total_sold'));
        const topProductsRevenue = @json($topProducts->pluck('total_revenue'));

        const ctx = document.getElementById('topProductsChart');
        if (ctx) {
            new Chart(ctx, {
                data: {
                    labels: topProductsLabels,
                    datasets: [{
                        type: 'bar',
                        label: 'Số lượng đã bán',
                        data: topProductsQty,
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        yAxisID: 'y',
                    },
                    {
                        type: 'line',
                        label: 'Doanh thu (₫)',
                        data: topProductsRevenue,
                        tension: 0.4,
                        borderColor: 'rgba(220, 53, 69, 1)',
                        backgroundColor: 'rgba(220, 53, 69, 0.2)',
                        fill: true,
                        yAxisID: 'y1',
                    }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    scales: {
                        x: {
                            ticks: {
                                autoSkip: false,
                                maxRotation: 45,
                                minRotation: 0,
                            }
                        },
                        y: {
                            position: 'left',
                            title: {
                                display: true,
                                text: 'Số lượng'
                            },
                            beginAtZero: true
                        },
                        y1: {
                            position: 'right',
                            grid: {
                                drawOnChartArea: false,
                            },
                            title: {
                                display: true,
                                text: 'Doanh thu (₫)'
                            },
                            beginAtZero: true,
                            ticks: {
                                callback: function (value) {
                                    return new Intl.NumberFormat('vi-VN', {
                                        style: 'currency',
                                        currency: 'VND'
                                    }).format(value);
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    const label = context.dataset.label || '';
                                    const value = context.parsed.y;
                                    if (context.dataset.type === 'line') {
                                        return `${label}: ${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(value)}`;
                                    }
                                    return `${label}: ${new Intl.NumberFormat('vi-VN').format(value)}`;
                                }
                            }
                        }
                    }
                }
            });
        }
    </script>
@endsection