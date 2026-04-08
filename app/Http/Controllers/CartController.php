<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    // Hàm Thêm sản phẩm vào giỏ hàng
    public function add(Request $request)
    {
        // 1. Lấy thông tin sản phẩm từ CSDL
        $product = \App\Models\Product::with('variants')->findOrFail($request->product_id);

        // Lấy giá bán (ưu tiên giá khuyến mãi nếu có)
        $basePrice = $product->variants->first()->sale_price ?? $product->variants->first()->price ?? 0;

        // 2. Xử lý giá Gói Bảo Hành
        $warrantyFee = (int) $request->warranty_fee;
        $finalPrice = $basePrice + $warrantyFee; // Tiền SP + Tiền Bảo Hành

        // Đặt tên gói bảo hành để hiển thị
        $warrantyText = '';
        if ($warrantyFee == 500000) $warrantyText = ' (Gói Vàng: +1 năm)';
        if ($warrantyFee == 800000) $warrantyText = ' (Gói Kim Cương: +2 năm)';
        if ($warrantyFee == 1500000) $warrantyText = ' (Gói VIP: 1 đổi 1)';

        $cart = session()->get('cart', []);

        // 3. Tạo một ID đặc biệt cho Giỏ hàng. 
        // Ví dụ: cùng là Tủ Lạnh, nhưng ông mua Gói Vàng phải khác dòng với ông mua Gói VIP
        $cartKey = $product->id . '_' . $warrantyFee;

        // Nếu sản phẩm (kèm đúng gói bảo hành đó) đã có trong giỏ, thì cộng dồn số lượng
        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $request->quantity;
        } else {
            $request->validate([
                'quantity' => 'required|integer|min:1'
            ], [
                'quantity.min' => 'Lỗi: Số lượng mua ít nhất phải là 1!'
            ]);
            // 1. Lấy thông tin sản phẩm từ CSDL
            $product = \App\Models\Product::with('variants')->findOrFail($request->product_id);

            // --- ĐOẠN CODE KIỂM TRA TỒN KHO MỚI THÊM ---
            if ($product->stock < $request->quantity) {
                // Nếu kho ít hơn số lượng khách muốn mua thì báo lỗi và đuổi về
                return redirect()->back()->withErrors(['error' => 'Rất tiếc! Sản phẩm này chỉ còn ' . $product->stock . ' chiếc trong kho.']);
            } // Nếu chưa có thì tạo dòng mới
            $cart[$cartKey] = [
                'name' => $product->name . $warrantyText, // Ghép tên gói bảo hành vào đuôi tên SP
                'price' => $finalPrice,                   // Giá đã cộng tiền bảo hành
                'quantity' => $request->quantity,
                'image' => "https://placehold.co/400x400?text=" . urlencode($product->name),
                'product_id' => $product->id              // Lưu lại ID gốc để trừ kho sau này
            ];
        }

        // Lưu lại vào Session
        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Đã thêm sản phẩm và gói bảo hành vào giỏ!');
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
