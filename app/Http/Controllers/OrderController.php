<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // 1. Hiển thị danh sách tất cả đơn hàng của User
    public function index()
    {
        // Lấy đơn hàng của user đang đăng nhập, sắp xếp mới nhất lên đầu
        $orders = Order::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('orders.index', compact('orders'));
    }

    // 2. Xem chi tiết 1 đơn hàng cụ thể
    public function show($id)
    {
        // Tìm đơn hàng kèm theo chi tiết sản phẩm (items), đảm bảo đơn này phải của user đang đăng nhập
        $order = Order::with('items')->where('user_id', Auth::id())->findOrFail($id);
        return view('orders.show', compact('order'));
    }
}
