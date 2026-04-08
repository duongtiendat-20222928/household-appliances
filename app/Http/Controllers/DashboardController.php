<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $latestProducts = Product::with('category')->latest()->take(5)->get();

        return view('dashboard', compact('totalProducts', 'totalCategories', 'latestProducts'));
    }
}
