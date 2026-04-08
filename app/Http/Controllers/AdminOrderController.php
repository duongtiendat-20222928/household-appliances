<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class AdminOrderController extends Controller
{
    // 1. Hiển thị danh sách tất cả đơn hàng (Mới nhất xếp trên)
    public function index(Request $request)
    {
        $query = \App\Models\Order::orderBy('created_at', 'desc');

        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            // Tìm theo Tên người nhận hoặc Số điện thoại
            $query->where('receiver_name', 'like', '%' . $searchTerm . '%')
                ->orWhere('receiver_phone', 'like', '%' . $searchTerm . '%');
        }

        $orders = $query->get();
        return view('admin.orders.index', compact('orders'));
    }

    // 2. Xem chi tiết 1 đơn hàng (Kèm theo các món đồ khách mua)
    public function show($id)
    {
        // Lấy đơn hàng và load luôn danh sách sản phẩm bên trong nó (quan hệ 'items' - order_items)
        $order = Order::with('items')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    // 3. Chuyển đổi trạng thái đơn hàng (Ví dụ: Đang xử lý -> Đang giao)
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Đã cập nhật trạng thái đơn hàng thành công!');
    }
}
