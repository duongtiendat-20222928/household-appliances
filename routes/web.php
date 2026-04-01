<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;

// 1. Route Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');
// Route Tìm kiếm sản phẩm
Route::get('/tim-kiem', [HomeController::class, 'search'])->name('search');
// 2. Route Chi tiết sản phẩm (Đây chính là cái đang bị thiếu gây ra lỗi)
Route::get('/san-pham/{slug}', [ProductController::class, 'show'])->name('product.show');

// 3. Các Route của Giỏ hàng
Route::get('/gio-hang', [CartController::class, 'index'])->name('cart.index');
Route::post('/gio-hang/them', [CartController::class, 'add'])->name('cart.add');
Route::get('/gio-hang/xoa/{id}', [CartController::class, 'remove'])->name('cart.remove');
// Route cập nhật số lượng (Tăng/Giảm)
Route::get('/gio-hang/cap-nhat/{id}', [CartController::class, 'update'])->name('cart.update');
// Route hiển thị trang nhập thông tin thanh toán
Route::get('/thanh-toan', [CheckoutController::class, 'index'])->name('checkout.index');
// --- CÁC ROUTE ĐĂNG NHẬP / ĐĂNG KÝ ---
Route::get('/dang-nhap', [AuthController::class, 'showLogin'])->name('login');
Route::post('/dang-nhap', [AuthController::class, 'login'])->name('login.post');

Route::get('/dang-ky', [AuthController::class, 'showRegister'])->name('register');
Route::post('/dang-ky', [AuthController::class, 'register'])->name('register.post');

Route::post('/dang-xuat', [AuthController::class, 'logout'])->name('logout');
// Gửi form thanh toán lên
Route::post('/thanh-toan', [CheckoutController::class, 'process'])->name('checkout.process');

// Trang thông báo thành công
Route::get('/dat-hang-thanh-cong', [CheckoutController::class, 'success'])->name('checkout.success');
// Nhóm Route yêu cầu Đăng nhập mới được vào
Route::middleware('auth')->group(function () {
    Route::get('/don-hang-cua-toi', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/don-hang-cua-toi/{id}', [OrderController::class, 'show'])->name('orders.show');
});
// Route Xem sản phẩm theo Danh mục
Route::get('/danh-muc/{id}', [App\Http\Controllers\HomeController::class, 'category'])->name('category.show');
