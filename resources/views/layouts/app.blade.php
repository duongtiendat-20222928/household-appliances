<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'META.vn - Đồ Gia Dụng Chính Hãng')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        /* Hiệu ứng hover phóng to ảnh tin tức */
        .hover-zoom img {
            transition: transform 0.3s ease;
        }

        .hover-zoom:hover img {
            transform: scale(1.05);
        }

        .hover-zoom:hover p {
            color: #007bff;
        }

        /* ẨN TEXT "SHOWING..." CỦA PHÂN TRANG VÀ CĂN GIỮA NÚT BẤM */
        nav .d-sm-flex.align-items-sm-center>div:first-child {
            display: none !important;
        }

        nav .justify-content-sm-between {
            justify-content: center !important;
        }

        body {
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
            overflow-x: hidden;
        }

        .bg-meta {
            background-color: #007bff;
        }

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

        .product-card {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 1px solid transparent !important;
        }

        .product-card:hover {
            border-color: #007bff !important;
            box-shadow: 0 15px 30px rgba(0, 123, 255, 0.15);
            transform: translateY(-8px);
        }

        .sidebar-menu li a {
            color: #333;
            text-decoration: none;
            padding: 10px 15px;
            display: block;
            border-bottom: 1px dashed #eee;
            transition: all 0.3s ease;
            border-radius: 5px;
        }

        .sidebar-menu li a:hover {
            color: #007bff;
            background: #f8f9fa;
            padding-left: 25px;
            font-weight: bold;
        }

        .discount-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: linear-gradient(45deg, #d70018, #ff416c);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: bold;
            z-index: 2;
            box-shadow: 0 4px 10px rgba(215, 0, 24, 0.3);
            animation: pulse-red 2s infinite;
        }

        @keyframes pulse-red {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.08);
            }

            100% {
                transform: scale(1);
            }
        }

        .btn-gradient {
            background: linear-gradient(45deg, #007bff, #00c6ff);
            border: none;
            color: white;
            font-weight: bold;
            transition: 0.5s;
            background-size: 200% auto;
        }

        .btn-gradient:hover {
            background-position: right center;
            color: #fff;
            box-shadow: 0 5px 15px rgba(0, 198, 255, 0.4);
        }
    </style>
</head>

<body>
    <div class="bg-light py-1 border-bottom d-none d-lg-block">
        <div class="container-fluid px-4 px-xl-5 d-flex justify-content-between text-muted" style="font-size: 13px;">
            <span><i class="fa-solid fa-shield-check text-success"></i> Cam kết chính hãng 100%</span>
            <span>Hotline: <strong class="text-danger"><i class="fa-solid fa-phone-volume bx-tada"></i> 024 3568
                    6969</strong> (8h00 - 19h00)</span>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-meta py-3 shadow-sm">
        <div class="container-fluid px-4 px-xl-5 d-flex align-items-center">
            <a class="navbar-brand fw-bold fs-3 me-5" href="/">
                <i class="fa-solid fa-cart-shopping"></i> GiaDungShop
            </a>

            <form action="{{ route('search') }}" method="GET" class="d-flex flex-grow-1 mx-4"
                style="max-width: 800px;">
                <input name="keyword" class="form-control rounded-start border-0 shadow-none" type="search"
                    placeholder="Bạn tìm đồ gia dụng gì hôm nay?..." value="{{ request('keyword') }}" required>
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
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">

                            @if (Auth::user()->role === 'admin')
                                <li>
                                    <a class="dropdown-item py-2 fw-bold text-danger" href="{{ url('/admin') }}">
                                        <i class="fa-solid fa-gauge me-2"></i>Vào Trang Quản Trị
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                            @endif
                            <li><a class="dropdown-item py-2" href="{{ route('orders.index') }}"><i
                                        class="fa-solid fa-clipboard-list me-2 text-primary"></i>Đơn hàng của tôi</a></li>
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
                        <span
                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-2 border-primary">
                            {{ count((array) session('cart')) }}
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <main class="container-fluid px-4 px-xl-5 mt-4 mb-5">
        @yield('content')
    </main>

    <footer class="bg-white border-top pt-5 pb-3 mt-5">
        <div class="container-fluid px-4 px-xl-5 text-center">
            <p class="mb-1 fw-bold text-dark">CÔNG TY CỔ PHẦN GIA DỤNG SHOP (Mô phỏng META.vn)</p>
            <p class="text-muted small mb-3">Địa chỉ: 123 Đường Cầu Giấy, Hà Nội | Điện thoại: 024 3568 6969</p>
            <p class="small">
                <a href="#" class="text-muted me-3 text-decoration-none hover-primary">Chính sách bảo mật</a>
                <a href="#" class="text-muted me-3 text-decoration-none">Điều khoản sử dụng</a>
                <a href="#" class="text-muted text-decoration-none">Chính sách đổi trả</a>
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800, // Thời gian chạy animation (0.8s)
            once: true, // Chỉ chạy 1 lần khi cuộn tới
            offset: 50 // Cuộn cách phần tử 50px là bắt đầu chạy
        });
    </script>

    @yield('scripts')
</body>

</html>
