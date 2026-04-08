<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class AdminProductController extends Controller
{
    // 1. Hiển thị danh sách sản phẩm
    public function index(Request $request)
    {
        $query = \App\Models\Product::with('category')->orderBy('created_at', 'desc');

        // Nếu có nhập từ khóa tìm kiếm
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where('name', 'like', '%' . $searchTerm . '%')
                ->orWhere('id', $searchTerm); // Tìm theo cả mã ID
        }

        $products = $query->get();
        return view('admin.products.index', compact('products'));
    }
    // 2. Hiển thị Form Thêm sản phẩm
    public function create()
    {
        // Lấy danh sách Danh mục và Thương hiệu để đổ vào thẻ <select>
        $categories = \App\Models\Category::all();
        $brands = \App\Models\Brand::all();

        return view('admin.products.create', compact('categories', 'brands'));
    }

    // 3. Xử lý lưu sản phẩm và Upload ảnh
    public function store(Request $request)
    {
        // Kiểm tra dữ liệu đầu vào
        $request->validate([
            'name' => 'required|max:255',
            'category_id' => 'required',
            'brand_id' => 'required',
            'price' => 'required|numeric|min:0',             // min:0 bắt buộc không được âm
            'sale_price' => 'nullable|numeric|min:0',        // min:0 bắt buộc không được âm
            'stock' => 'required|integer|min:0',             // Kho ít nhất là 0
            'warranty_months' => 'required|integer|min:0',   // Bảo hành ít nhất là 0
            'image_upload' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // 1. XỬ LÝ UPLOAD ẢNH (Nếu có chọn ảnh)
        $imagePath = null;
        if ($request->hasFile('image_upload')) {
            $image = $request->file('image_upload');
            // Đặt tên ảnh mới tránh trùng lặp (vd: 1681234567_tulanh.jpg)
            $imageName = time() . '_' . $image->getClientOriginalName();
            // Lưu thẳng vào thư mục public/images/products mà bạn đã tạo hôm trước
            $image->move(public_path('images/products'), $imageName);
            $imagePath = 'images/products/' . $imageName;
        }

        // 2. LƯU VÀO BẢNG products
        $product = \App\Models\Product::create([
            'name' => $request->name,
            // Tự động tạo link slug từ tên SP (VD: Tủ lạnh -> tu-lanh)
            'slug' => \Illuminate\Support\Str::slug($request->name) . '-' . time(),
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'stock' => $request->stock ?? 0,
            'warranty_months' => $request->warranty_months ?? 12,
            'image' => $imagePath, // Lưu đường dẫn ảnh vừa upload
            'status' => 'published'
        ]);

        // 3. LƯU GIÁ TIỀN VÀO BẢNG product_variants
        \Illuminate\Support\Facades\DB::table('product_variants')->insert([
            'product_id' => $product->id,
            'sku' => 'SP-' . time(),
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'stock_quantity' => $request->stock ?? 0,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Đã thêm sản phẩm thành công!');
    }
    // 4. Xử lý Xóa sản phẩm
    public function destroy($id)
    {
        $product = \App\Models\Product::findOrFail($id);

        // Mẹo dọn rác: Nếu sản phẩm có ảnh lưu trong máy, ta xóa luôn file ảnh đó cho nhẹ ổ cứng
        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }

        // Xóa dữ liệu trong Database
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Đã bay màu sản phẩm thành công!');
    }
    // 5. Hiển thị Form Sửa sản phẩm
    public function edit($id)
    {
        // Lấy sản phẩm cần sửa kèm theo giá tiền của nó
        $product = \App\Models\Product::with('variants')->findOrFail($id);
        $categories = \App\Models\Category::all();
        $brands = \App\Models\Brand::all();

        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    // 6. Xử lý lưu thông tin đã sửa
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'category_id' => 'required',
            'brand_id' => 'required',
            'price' => 'required|numeric|min:0',             // min:0 bắt buộc không được âm
            'sale_price' => 'nullable|numeric|min:0',        // min:0 bắt buộc không được âm
            'stock' => 'required|integer|min:0',             // Kho ít nhất là 0
            'warranty_months' => 'required|integer|min:0',   // Bảo hành ít nhất là 0
            'image_upload' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $product = \App\Models\Product::findOrFail($id);

        // 1. XỬ LÝ ẢNH (Nếu sếp chọn upload ảnh MỚI)
        if ($request->hasFile('image_upload')) {
            // Xóa ảnh cũ đi cho nhẹ máy
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }
            // Lưu ảnh mới
            $image = $request->file('image_upload');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/products'), $imageName);
            $product->image = 'images/products/' . $imageName; // Cập nhật đường dẫn mới
        }

        // 2. CẬP NHẬT THÔNG TIN BẢNG products
        $product->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'stock' => $request->stock,
            'warranty_months' => $request->warranty_months,
            // Lưu ý: Thường người ta không cho đổi 'slug' để tránh lỗi link cũ của Google
        ]);

        // 3. CẬP NHẬT GIÁ BẢNG product_variants
        \Illuminate\Support\Facades\DB::table('product_variants')
            ->where('product_id', $id)
            ->update([
                'price' => $request->price,
                'sale_price' => $request->sale_price,
                'stock_quantity' => $request->stock,
                'updated_at' => now()
            ]);

        return redirect()->route('admin.products.index')->with('success', 'Đã cập nhật thông tin sản phẩm thành công!');
    }
}
