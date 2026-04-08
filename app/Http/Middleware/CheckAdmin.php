<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Kiểm tra xem user đã đăng nhập chưa VÀ cột 'role' có phải là 'admin' không
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request); // Đúng là admin thì cho đi tiếp
        }

        // Nếu không phải admin, đuổi cổ về trang chủ và báo lỗi
        return redirect('/')->with('error', 'CẢNH BÁO: Bạn không có quyền truy cập khu vực Quản trị!');
    }
}
