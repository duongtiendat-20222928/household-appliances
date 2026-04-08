<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Phải gọi Model Product vào để dùng

class HomeController extends Controller
{
    public function index()
    {
        $categories = \App\Models\Category::all();

        $products = \App\Models\Product::with(['category', 'variants'])
            ->where('status', 'published')
            ->get();

        // Truyền cả $products và $categories sang view
        return view('home', compact('products', 'categories'));
    }
    // Hàm xử lý Tìm kiếm
    public function search(Request $request)
    {
        // Lấy từ khóa khách hàng gõ vào
        $keyword = $request->input('keyword');

        // Tìm sản phẩm có tên chứa từ khóa (Dùng LIKE %từ_khóa%)
        $products = Product::with(['category', 'variants'])
            ->where('name', 'LIKE', "%{$keyword}%")
            ->where('status', 'published')
            ->get();

        // Vẫn lấy danh mục để hiển thị ở cột trái
        $categories = \App\Models\Category::all();

        // Trả về trang hiển thị kết quả tìm kiếm
        return view('search', compact('products', 'categories', 'keyword'));
    }
    // Hàm hiển thị sản phẩm theo Danh mục
    public function category($id)
    {
        // 1. Tìm danh mục hiện tại đang được bấm vào
        $currentCategory = \App\Models\Category::findOrFail($id);

        // 2. Lấy các sản phẩm thuộc danh mục này
        $products = \App\Models\Product::with(['category', 'variants'])
            ->where('category_id', $id)
            ->where('status', 'published')
            ->get();

        // 3. Vẫn lấy toàn bộ danh mục để hiển thị lại cái Menu bên trái
        $categories = \App\Models\Category::all();

        return view('category', compact('products', 'categories', 'currentCategory'));
    }
    // Xử lý Khách hàng tự hủy đơn
    public function cancelOrder($id)
    {
        $order = \App\Models\Order::findOrFail($id);

        // 1. BẢO MẬT: Đảm bảo khách chỉ được phép hủy đơn của chính mình
        // (Bỏ qua dòng này nếu hệ thống của bạn cho phép khách vãng lai không cần đăng nhập cũng xem được đơn)
        if (\Illuminate\Support\Facades\Auth::check() && $order->user_id != \Illuminate\Support\Facades\Auth::id()) {
            return redirect()->back()->with('error', 'CẢNH BÁO: Bạn không có quyền thao tác trên đơn hàng này!');
        }

        // 2. LOGIC: Chỉ cho phép hủy khi đơn đang ở trạng thái 'pending' (Chờ xử lý)
        if ($order->status == 'pending') {

            // Đổi trạng thái thành Đã hủy
            $order->status = 'canceled';
            $order->save();

            // MẸO NÂNG CAO (Tuỳ chọn): Trả lại số lượng tồn kho cho sản phẩm

            foreach ($order->items as $item) {
                \Illuminate\Support\Facades\DB::table('product_variants')
                    ->where('product_id', $item->product_id)
                    ->increment('stock_quantity', $item->quantity);

                \App\Models\Product::where('id', $item->product_id)->increment('stock', $item->quantity);
            }


            return redirect()->back()->with('success', 'Bạn đã hủy đơn hàng thành công!');
        }

        // Nếu đơn đã đóng gói hoặc đang giao thì báo lỗi
        return redirect()->back()->with('error', 'Đơn hàng này đã được xử lý, bạn không thể tự hủy. Vui lòng liên hệ Hotline!');
    }
    // 1. Hiển thị form tra cứu
    public function trackOrderForm()
    {
        return view('track-order');
    }

    // 2. Xử lý tìm đơn hàng
    public function trackOrderSubmit(Request $request)
    {
        // Yêu cầu nhập đủ 2 thông tin
        $request->validate([
            'order_id' => 'required',
            'phone' => 'required'
        ], [
            'order_id.required' => 'Vui lòng nhập mã đơn hàng',
            'phone.required' => 'Vui lòng nhập số điện thoại đặt hàng'
        ]);

        // Lọc bỏ ký tự thừa (Ví dụ khách lỡ nhập #ORD-15 thay vì 15)
        $orderId = preg_replace('/[^0-9]/', '', $request->order_id);

        // Tìm đơn hàng khớp cả ID và Số điện thoại
        $order = \App\Models\Order::with('items')
            ->where('id', $orderId)
            ->where('receiver_phone', $request->phone)
            ->first();

        if (!$order) {
            return back()->with('error', 'Không tìm thấy đơn hàng! Vui lòng kiểm tra lại Mã đơn và Số điện thoại.')->withInput();
        }

        // Nếu tìm thấy, trả về trang tra cứu kèm thông tin đơn
        return view('track-order', compact('order'));
    }
}
