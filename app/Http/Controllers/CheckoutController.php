<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        // Kiểm tra xem khách đang đi từ nút Mua ngay hay từ Giỏ hàng sang
        if ($request->query('mode') == 'buy_now') {
            $cart = session()->get('buy_now_cart', []);
            $mode = 'buy_now';
        } else {
            $cart = session()->get('cart', []);
            $mode = 'cart';
        }

        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Chưa có sản phẩm nào để thanh toán!');
        }

        return view('checkout.index', compact('cart', 'mode'));
    }

    public function process(Request $request)
    {
        // 1. Xác định chế độ thanh toán
        $mode = $request->input('checkout_mode', 'cart');
        $cart = ($mode == 'buy_now') ? session()->get('buy_now_cart', []) : session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Không có sản phẩm nào để thanh toán!');
        }

        // 2. Tính Tạm tính
        $subtotal = 0;
        foreach ($cart as $details) {
            $subtotal += $details['price'] * $details['quantity'];
        }

        // 3. Tính tiền bảo hành và Ghi chú
        $warrantyFee = (int) $request->input('warranty_fee', 0);
        $totalAmount = $subtotal + $warrantyFee;

        $warrantyText = '';
        if ($warrantyFee == 500000) $warrantyText = ' [Gói bảo hành chọn thêm: Gói Vàng +500k]';
        if ($warrantyFee == 1500000) $warrantyText = ' [Gói bảo hành chọn thêm: Gói VIP +1.500k]';

        $finalNote = $request->note . $warrantyText;

        // 4. LƯU ĐƠN HÀNG (ORDERS)
        $order = new Order();
        $order->user_id = Auth::user()?->id;
        $order->receiver_name = $request->receiver_name;
        $order->receiver_phone = $request->receiver_phone;
        $order->receiver_email = $request->receiver_email;
        $order->shipping_address = $request->shipping_address;
        $order->note = $finalNote;
        $order->payment_method = $request->payment_method;
        $order->total_amount = $totalAmount;
        $order->status = 'pending';
        $order->save();

        // 5. LƯU CHI TIẾT & TRỪ KHO
        foreach ($cart as $id => $details) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $details['product_id'],
                'product_name' => $details['name'],
                'price' => $details['price'],
                'quantity' => $details['quantity'],
            ]);

            Product::where('id', $details['product_id'])->decrement('stock', $details['quantity']);
        }

        // 6. Xóa giỏ hàng
        if ($mode == 'buy_now') {
            session()->forget('buy_now_cart');
        } else {
            session()->forget('cart');
        }

        // --- ĐÃ THÊM: DÒNG QUAN TRỌNG NHẤT Ở ĐÂY ---
        // Lưu ID đơn hàng vào session để trang success biết đường mà hiển thị
        session()->put('new_order_id', $order->id);

        // 7. CHUYỂN HƯỚNG SANG TRANG THÀNH CÔNG
        return redirect()->route('checkout.success');
    }

    public function success()
    {
        // Lấy ID đơn hàng vừa đặt từ session
        $orderId = session('new_order_id');

        // Nếu không có ID (do khách tự gõ URL), đá về trang chủ
        if (!$orderId) {
            return redirect('/')->with('error', 'Không tìm thấy thông tin đơn hàng vừa đặt.');
        }

        // Lấy thông tin đơn hàng và các sản phẩm bên trong
        $order = Order::with('items.product')->find($orderId);

        if (!$order) {
            return redirect('/')->with('error', 'Đơn hàng không tồn tại.');
        }

        return view('checkout.success', compact('order'));
    }
    public function checkTracking(Request $request)
    {
        // 1. Ép kiểu an toàn dữ liệu từ Form
        $inputCode = (string) $request->input('order_code', '');
        $inputPhone = (string) $request->input('phone', '');

        // 2. Lấy đúng số ID đơn hàng
        $orderId = (int) preg_replace('/[^0-9]/', '', $inputCode);

        if ($orderId === 0) {
            return back()->with('error', 'Vui lòng nhập mã đơn hàng hợp lệ!');
        }

        $order = \App\Models\Order::with('items.product')->find($orderId);

        if (!$order) {
            return back()->with('error', 'Mã đơn hàng không tồn tại!');
        }

        // ==========================================
        // LOGIC 1: ĐƠN HÀNG CỦA THÀNH VIÊN (user_id có dữ liệu)
        // ==========================================
        if (!empty($order->user_id)) {
            // Khách vãng lai tra cứu -> Bắt đăng nhập
            if (!\Illuminate\Support\Facades\Auth::check()) {
                return redirect()->route('login')->with('error', 'Đơn hàng này thuộc về thành viên. Vui lòng đăng nhập để tra cứu!');
            }

            // Đã đăng nhập & đúng là chủ đơn -> Đá thẳng về trang lịch sử đơn hàng của thành viên
            if (\Illuminate\Support\Facades\Auth::id() == $order->user_id) {
                return redirect()->route('orders.show', $order->id);
            }

            // Đã đăng nhập nhưng là tài khoản người khác -> Chặn
            return back()->with('error', 'Bạn không có quyền xem thông tin đơn hàng của người khác!');
        }

        // ==========================================
        // LOGIC 2: ĐƠN HÀNG VÃNG LAI (user_id là rỗng)
        // ==========================================
        // Bắt buộc nhập đúng số điện thoại mới cho xem
        if (empty($inputPhone) || $order->receiver_phone !== $inputPhone) {
            return back()->with('error', 'Số điện thoại không khớp với thông tin đơn đặt hàng!');
        }

        // Vượt qua hết thì mới bung trang kết quả
        return view('track.result', compact('order'));
    }
}
