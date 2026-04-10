<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        // 1. Kiểm tra tính hợp lệ của dữ liệu
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        // 2. Lưu vào CSDL (Tự động lấy ID của người đang đăng nhập)
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->back()->with('error', 'Vui lòng đăng nhập để đánh giá sản phẩm!');
        }

        Review::create([
            'product_id' => $request->product_id,
            'user_id' => $user->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => true // Để true là hiện luôn. Nếu sếp muốn duyệt thì đổi thành false
        ]);

        // 3. Quay lại trang cũ và báo thành công
        return redirect()->back()->with('success', 'Cảm ơn bạn đã gửi đánh giá sản phẩm!');
    }
}