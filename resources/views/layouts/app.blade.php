<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'META.vn - Đồ Gia Dụng Chính Hãng')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* CSS tùy chỉnh thêm cho giống Meta.vn */
        body {
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }

        .bg-meta {
            background-color: #007bff;
        }

        /* Màu xanh chủ đạo của Meta */
        .text-meta {
            color: #007bff;
        }

        .price-red {
            color: #d70018;
            font-weight: bold;
        }

        .price-old {
            text-decoration: line-through;
            color: #999;
            font-size: 0.9rem;
        }

        .discount-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: #d70018;
            color: white;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: bold;
            z-index: 2;
        }

        .product-card:hover {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
            transition: 0.3s;
        }

        .sidebar-menu li a {
            color: #333;
            text-decoration: none;
            padding: 8px 0;
            display: block;
            border-bottom: 1px dashed #eee;
        }

        .sidebar-menu li a:hover {
            color: #007bff;
        }
    </style>
</head>

<body>

    <div class="bg-light py-1 border-bottom d-none d-lg-block">
        <div class="container d-flex justify-content-between text-muted" style="font-size: 13px;">
            <span>Cam kết chính hãng 100%</span>
            <span>Hotline: <strong class="text-danger">024 3568 6969</strong> (8h00 - 19h00)</span>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-meta py-3">
        <div class="container d-flex align-items-center">
            <a class="navbar-brand fw-bold fs-3 me-5" href="/">
                <i class="fa-solid fa-cart-shopping"></i> GiaDungShop
            </a>

            <form action="{{ route('search') }}" method="GET" class="d-flex flex-grow-1 mx-4">
                <input name="keyword" class="form-control rounded-start" type="search"
                    placeholder="Bạn tìm đồ gia dụng gì hôm nay?..." aria-label="Search"
                    value="{{ request('keyword') }}" required>
                <button class="btn btn-warning rounded-end px-4 fw-bold" type="submit">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>

            <ul class="navbar-nav ms-auto d-flex flex-row gap-4">

                <li class="nav-item">
                    <a class="nav-link text-white text-center" href="{{ route('track.order') }}">
                        <i class="fa-solid fa-truck-fast fs-4 d-block"></i> Tra cứu
                    </a>
                </li>
                <li class="nav-item dropdown me-2">
                    @guest
                        <a class="nav-link text-white text-center" href="{{ route('login') }}">
                            <i class="fa-regular fa-user fs-4 d-block"></i> Đăng nhập
                        </a>
                    @else
                        <a class="nav-link text-white text-center dropdown-toggle" href="#" id="userMenu"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-user-check fs-4 d-block"></i> Chào, {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" aria-labelledby="userMenu">
                            <li><a class="dropdown-item py-2" href="{{ route('orders.index') }}"><i
                                        class="fa-solid fa-clipboard-list me-2"></i>Đơn hàng của tôi</a></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger fw-bold py-2">
                                        <i class="fa-solid fa-right-from-bracket me-2"></i>Đăng xuất
                                    </button>
                                </form>
                            </li>
                        </ul>
                    @endguest
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white text-center position-relative" href="{{ route('cart.index') }}">
                        <i class="fa-solid fa-cart-shopping fs-4 d-block"></i> Giỏ hàng
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ count((array) session('cart')) }}
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <main class="container mt-4 mb-5">
        @yield('content')
    </main>

    <footer class="bg-white border-top pt-5 pb-3">
        <div class="container text-center">
            <p class="mb-1 fw-bold">CÔNG TY CỔ PHẦN GIA DỤNG SHOP (Mô phỏng META.vn)</p>
            <<<<<<< HEAD <p class="text-muted small mb-3">Địa chỉ: 123 Đường Cầu Giấy, Hà Nội | Điện thoại: 024 3568
                6969</p>

                <p class="small">
                    <a href="{{ route('track.order') }}" class="text-decoration-none fw-bold text-primary">
                        <i class="fa-solid fa-truck-fast me-1"></i> Tra cứu tình trạng đơn hàng
                    </a>
                </p>
                =======
                <p class="text-muted small">Địa chỉ: 123 Đường Cầu Giấy, Hà Nội | Điện thoại: 024 3568 6969</p>
                >>>>>>> 3580e560e1b73b25380ceed7a84d942bc8d8b768
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
