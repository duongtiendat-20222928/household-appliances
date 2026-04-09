<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Order;       // Thêm dòng này
use App\Models\OrderItem;   // Thêm dòng này
class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        // Kiểm tra xem khách đang đi từ nút Mua ngay hay từ Giỏ hàng sang
        if ($request->query('mode') == 'buy_now') {
            $cart = session()->get('buy_now_cart', []);
            $mode = 'buy_now'; // Truyền biến mode ra view để dùng lát nữa
        } else {
            $cart = session()->get('cart', []);
            $mode = 'cart';
        }

        // Nếu không có hàng mà cố tình vào thì đuổi về trang chủ
        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Chưa có sản phẩm nào để thanh toán!');
        }

        return view('checkout.index', compact('cart', 'mode'));
    }
    public function process(Request $request)
    {
        // 1. Xác định khách đang thanh toán Giỏ hàng thường hay thanh toán Mua ngay
        $mode = $request->input('checkout_mode', 'cart');
        $cart = ($mode == 'buy_now') ? session()->get('buy_now_cart', []) : session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Không có sản phẩm nào để thanh toán!');
        }

        // 2. Tính Tạm tính (Tiền sản phẩm)
        $subtotal = 0;
        foreach ($cart as $details) {
            $subtotal += $details['price'] * $details['quantity'];
        }

        // 3. Lấy Tiền bảo hành từ Form và tính TỔNG CỘNG CUỐI CÙNG
        $warrantyFee = (int) $request->input('warranty_fee', 0);
        $totalAmount = $subtotal + $warrantyFee;

        // Mẹo nhỏ: Lưu thông tin bảo hành vào Ghi chú luôn để Admin dễ đọc, 
        // khỏi mất công phải tạo thêm cột mới trong Database (CSDL).
        $warrantyText = '';
        if ($warrantyFee == 500000) $warrantyText = ' (Khách mua kèm: Gói Vàng +500k)';
        if ($warrantyFee == 1500000) $warrantyText = ' (Khách mua kèm: Gói VIP +1.500k)';

        $finalNote = $request->note . $warrantyText;

        // 4. LƯU VÀO BẢNG ĐƠN HÀNG (ORDERS)
        $order = new \App\Models\Order();
        $order->user_id = Auth::user()?->id; // Nếu có đăng nhập thì lưu ID, không thì null
        $order->receiver_name = $request->receiver_name;
        $order->receiver_phone = $request->receiver_phone;
        $order->receiver_email = $request->receiver_email;
        $order->shipping_address = $request->shipping_address;
        $order->note = $finalNote;           // Ghi chú đã kèm thông tin gói bảo hành
        $order->payment_method = $request->payment_method;
        $order->total_amount = $totalAmount; // TỔNG TIỀN ĐÃ CỘNG BẢO HÀNH
        $order->status = 'pending';          // Trạng thái chờ xử lý
        $order->save();

        // 5. LƯU CHI TIẾT SẢN PHẨM & TRỪ KHO
        foreach ($cart as $id => $details) {
            // Lưu vào bảng order_items
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $details['product_id'],
                'product_name' => $details['name'],
                'price' => $details['price'],
                'quantity' => $details['quantity'],
            ]);

            // Trừ số lượng tồn kho của sản phẩm
            \App\Models\Product::where('id', $details['product_id'])->decrement('stock', $details['quantity']);
        }

        // 6. XÓA GIỎ HÀNG TƯƠNG ỨNG SAU KHI MUA XONG
        if ($mode == 'buy_now') {
            session()->forget('buy_now_cart'); // Mua ngay xong thì xóa giỏ tạm
        } else {
            session()->forget('cart');         // Đặt giỏ hàng xong thì làm trống giỏ
        }

        // 7. HOÀN THÀNH
        return redirect()->route('checkout.success')->with('success', 'Chúc mừng bạn đã đặt hàng thành công!');
    }

    // HÀM MỚI: Hiển thị trang Cảm ơn
    public function success()
    {
        return view('checkout.success');
    }
}