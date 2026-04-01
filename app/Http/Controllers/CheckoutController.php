<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Order;       // Thêm dòng này
use App\Models\OrderItem;   // Thêm dòng này
class CheckoutController extends Controller
{
    public function index()
    {
        // Lấy giỏ hàng ra
        $cart = session()->get('cart', []);

        // Nếu giỏ hàng trống thì đuổi về trang giỏ hàng
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('success', 'Giỏ hàng của bạn đang trống, hãy chọn sản phẩm trước nhé!');
        }

        // Nếu có đồ, mở trang điền thông tin
        return view('checkout.index', compact('cart'));
    }
    public function process(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) return redirect('/');

        // 1. Tính tổng tiền
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // 2. Lưu thông tin vào bảng orders
        $order = Order::create([
            'user_id' => Auth::id(), // Nếu là khách vãng lai, cái này sẽ tự động là null
            'receiver_name' => $request->receiver_name,
            'receiver_phone' => $request->receiver_phone,
            'receiver_email' => $request->receiver_email,
            'shipping_address' => $request->shipping_address,
            'note' => $request->note,
            'payment_method' => $request->payment_method,
            'total_amount' => $total,
            'status' => 'pending' // Trạng thái: Chờ xử lý
        ]);

        // 3. Lưu từng món đồ vào bảng order_items VÀ TRỪ TỒN KHO
        foreach ($cart as $id => $item) {
            // Nhét vào bảng chi tiết đơn hàng
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'], // Lấy đúng ID gốc của sản phẩm
                'product_name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
            ]);

            // TỰ ĐỘNG TRỪ TỒN KHO
            // Tìm đúng sản phẩm đó trong kho
            $product = \App\Models\Product::find($item['product_id']);
            if ($product) {
                // Lệnh decrement của Laravel sẽ tự động lấy số cũ trừ đi số lượng khách mua
                $product->decrement('stock', $item['quantity']);
            }
        }

        // 4. Xóa sạch giỏ hàng trong Session
        session()->forget('cart');

        // 5. Chuyển hướng sang trang Cảm ơn
        return redirect()->route('checkout.success')->with('success', 'Đặt hàng thành công!');
    }

    // HÀM MỚI: Hiển thị trang Cảm ơn
    public function success()
    {
        return view('checkout.success');
    }
}
