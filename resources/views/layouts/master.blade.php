<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản lý Sản Phẩm</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background: #333;
            color: #fff;
            padding: 15px;
            text-align: center;
        }

        nav {
            background: #eee;
            padding: 10px;
            text-align: center;
        }

        nav a {
            margin: 0 15px;
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }

        .container {
            padding: 20px;
            max-width: 1000px;
            margin: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .btn {
            padding: 5px 10px;
            text-decoration: none;
            background: #007bff;
            color: white;
            border-radius: 3px;
            border: none;
            cursor: pointer;
        }

        .btn-danger {
            background: #dc3545;
        }
    </style>
</head>

<body>
    <header>
        <h2>Hệ Thống Quản Lý Sản Phẩm</h2>
    </header>
    <nav>
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <a href="{{ route('products.index') }}">Danh sách Sản phẩm</a>
        <a href="{{ route('products.create') }}">Thêm Sản phẩm</a>
    </nav>
    <div class="container">
        <x-alert />

        @yield('content')
    </div>
</body>

</html>
