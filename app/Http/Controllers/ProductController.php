<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function show($slug)
    {
        // Tìm sản phẩm theo đường dẫn (slug), lấy kèm danh mục và biến thể
        $product = Product::with(['category', 'variants'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return view('products.show', compact('product'));
    }
}
