<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminCustomerController extends Controller
{
    // 1. Hiển thị danh sách khách hàng
    public function index(Request $request)
    {
        // Chỉ lấy user là khách hàng
        $query = \App\Models\User::where('role', 'customer')->orderBy('created_at', 'desc');

        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                // Tìm theo Tên hoặc Email
                $q->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('email', 'like', '%' . $searchTerm . '%');
            });
        }

        $customers = $query->get();
        return view('admin.customers.index', compact('customers'));
    }

    // 2. Xóa khách hàng (Nếu cần)
    public function destroy($id)
    {
        $customer = User::findOrFail($id);

        // Không cho phép xóa Admin để tránh tự "bóp" hệ thống
        if ($customer->role == 'admin') {
            return redirect()->back()->with('error', 'Không thể xóa tài khoản Quản trị viên!');
        }

        $customer->delete();
        return redirect()->route('admin.customers.index')->with('success', 'Đã xóa khách hàng thành công!');
    }
}
