<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Quản trị hệ thống')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: Arial, sans-serif;
        }

        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
            color: #fff;
        }

        .sidebar a {
            color: #c2c7d0;
            text-decoration: none;
            padding: 12px 20px;
            display: block;
            border-bottom: 1px solid #4f5962;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #007bff;
            color: #fff;
        }

        .main-content {
            padding: 20px;
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <div class="sidebar" style="width: 250px;">
            <div class="p-3 fs-5 fw-bold text-center border-bottom border-secondary">
                <i class="fa-solid fa-gear me-2"></i> ADMIN PANEL
            </div>
            <div class="mt-3">
                <a href="{{ route('admin.dashboard') }}"
                    class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-gauge-high me-2"></i> Bảng điều khiển
                </a>

                <a href="{{ route('admin.products.index') }}"
                    class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-box-open me-2"></i> Quản lý Sản Phẩm
                </a>

                <a href="{{ route('admin.orders.index') }}"
                    class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-clipboard-list me-2"></i> Quản lý Đơn hàng
                </a>

                <a href="{{ route('admin.customers.index') }}"
                    class="{{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-users me-2"></i> Quản lý Khách hàng
                </a>

                <a href="/" target="_blank">
                    <i class="fa-solid fa-house me-2"></i> Xem trang Web
                </a>

                <form action="{{ route('logout') }}" method="POST" class="mt-5">
                    @csrf
                    <button type="submit" class="btn btn-danger w-100 rounded-0">
                        <i class="fa-solid fa-right-from-bracket me-2"></i> Đăng xuất
                    </button>
                </form>
            </div>
        </div>
        <div class="flex-grow-1">
            <div class="bg-white p-3 shadow-sm d-flex justify-content-between align-items-center">
                <h5 class="m-0 fw-bold text-secondary" style="min-width: 200px;">@yield('title')</h5>

                @php
                    // Mặc định là tìm Sản phẩm
                    $searchRoute = route('admin.products.index');
                    $searchPlaceholder = 'Tìm tên hoặc ID sản phẩm...';
                    $showSearch = true;

                    if (request()->routeIs('admin.orders.*')) {
                        $searchRoute = route('admin.orders.index');
                        $searchPlaceholder = 'Tìm tên khách hoặc SĐT đặt hàng...';
                    } elseif (request()->routeIs('admin.customers.*')) {
                        $searchRoute = route('admin.customers.index');
                        $searchPlaceholder = 'Tìm tên hoặc email khách hàng...';
                    } elseif (request()->routeIs('admin.dashboard')) {
                        // Ẩn thanh tìm kiếm ở Dashboard cho gọn
                        $showSearch = false;
                    }
                @endphp

                @if ($showSearch)
                    <form action="{{ $searchRoute }}" method="GET" class="d-flex mx-3 flex-grow-1"
                        style="max-width: 400px;">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control border-primary"
                                placeholder="{{ $searchPlaceholder }}" value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit"><i
                                    class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </form>
                @else
                    <div class="d-flex mx-3 flex-grow-1"></div>
                @endif
                <div style="min-width: 200px;" class="text-end">
                    <span class="me-3">Xin chào, <strong
                            class="text-primary">{{ Auth::user()->name }}</strong></span>
                </div>
            </div>
            <div class="main-content">
                @yield('content')
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
