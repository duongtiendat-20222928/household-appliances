<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class AdminController extends Controller
{
    // Hiển thị Bảng điều khiển (Dashboard)
    public function index()
    {
        // 1. Các con số thống kê cơ bản
        $totalOrders = \App\Models\Order::count();
        $totalProducts = \App\Models\Product::count();
        $totalCustomers = \App\Models\User::where('role', 'customer')->count();

        // 2. Tính Tổng doanh thu (Chỉ cộng dồn cột total_amount của các đơn có status = 'completed')
        $totalRevenue = \App\Models\Order::where('status', 'completed')->sum('total_amount');

        // 3. Lấy 5 đơn hàng mới nhất để hiện nhanh ra bảng
        $recentOrders = \App\Models\Order::orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalOrders',
            'totalProducts',
            'totalCustomers',
            'totalRevenue',
            'recentOrders'
        ));
    }
}
