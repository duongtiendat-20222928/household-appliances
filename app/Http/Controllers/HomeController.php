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
}
