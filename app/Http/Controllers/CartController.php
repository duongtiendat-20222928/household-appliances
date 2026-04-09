<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    // Hàm Thêm sản phẩm vào giỏ hàng
    public function add(Request $request)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ], [
            'quantity.min' => 'Lỗi: Số lượng mua ít nhất phải là 1!'
        ]);

        $product = \App\Models\Product::with('variants')->findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return redirect()->back()->withErrors(['error' => 'Rất tiếc! Sản phẩm này chỉ còn ' . $product->stock . ' chiếc.']);
        }

        $basePrice = $product->variants->first()->sale_price ?? $product->variants->first()->price ?? 0;

        // Tạo mảng thông tin sản phẩm chuẩn (Đã bỏ phần ghép tên Bảo hành)
        $item = [
            'name' => $product->name,
            'price' => $basePrice,
            'quantity' => $request->quantity,
            'image' => $product->image ? asset($product->image) : "https://placehold.co/400x400?text=" . urlencode($product->name),
            'product_id' => $product->id
        ];

        // 1. NẾU KHÁCH BẤM "MUA NGAY"
        if ($request->action == 'buy_now') {
            // Tạo một giỏ hàng "Tạm thời" chỉ chứa đúng món này và lưu vào session riêng
            session()->put('buy_now_cart', [$product->id => $item]);

            // Chuyển sang trang thanh toán kèm theo "tín hiệu" báo đây là đơn mua ngay
            return redirect()->route('checkout.index', ['mode' => 'buy_now']);
        }

        // 2. NẾU KHÁCH BẤM "THÊM VÀO GIỎ"
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $request->quantity;
        } else {
            $cart[$product->id] = $item;
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
    }
    // Hàm hiển thị trang Giỏ hàng
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }
    // Hàm xóa sản phẩm khỏi giỏ
    public function remove($id)
    {
        $cart = session()->get('cart');

        // Kiểm tra xem sản phẩm có trong giỏ không, có thì xóa
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart); // Lưu mảng mới ngược lại vào session
        }

        return redirect()->back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
    }
    // Hàm cập nhật số lượng
    public function update(Request $request, $id)
    {
        $cart = session()->get('cart');

        // Kiểm tra xem sản phẩm có trong giỏ không
        if (isset($cart[$id])) {
            // Lấy hành động từ URL (increase = tăng, decrease = giảm)
            if ($request->action == 'increase') {
                $cart[$id]['quantity']++;
            } elseif ($request->action == 'decrease') {
                $cart[$id]['quantity']--;

                // Nếu giảm về 0 thì tự động xóa luôn khỏi giỏ
                if ($cart[$id]['quantity'] <= 0) {
                    unset($cart[$id]);
                }
            }

            // Lưu lại giỏ hàng mới vào Session
            session()->put('cart', $cart);
        }

        // Quay lại trang giỏ hàng và không cần hiện thông báo rườm rà
        return redirect()->back();
    }
}
