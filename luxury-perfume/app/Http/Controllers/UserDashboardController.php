<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $categories = \App\Models\Category::all();

        // Group categories as requested
        $categoriesGrouped = [
            'Skin Treatment' => $categories->whereIn('slug', ['anti-aging', 'pigmentation', 'dark-spots', 'pimple-removal', 'scar-treatment', 'sun-protection']),
            'Product Type' => $categories->whereIn('slug', ['face-wash', 'moisturizer', 'serum', 'sunscreen', 'toner', 'night-cream', 'day-cream', 'eye-cream']),
            'Special' => $categories->whereIn('slug', ['men-skincare', 'women-skincare', 'organic-products', 'dermatologist-recommended', 'best-sellers', 'new-arrivals']),
        ];

        $selectedCategorySlug = $request->get('category');
        $selectedCategory = null;

        if ($selectedCategorySlug) {
            $selectedCategory = \App\Models\Category::where('slug', $selectedCategorySlug)->first();
        }

        $query = \App\Models\Product::with('category');

        if ($selectedCategory) {
            $query->where('category_id', $selectedCategory->id);
        }

        $products = $query->latest()->paginate(12);

        $orders = Order::where('user_id', Auth::id())->latest()->get();

        return view('user.dashboard', compact('categoriesGrouped', 'products', 'selectedCategory', 'orders'));
    }


    public function orders()
    {
        // Add pagination to match the orders.index view which uses $orders->links()
        $orders = Order::where('user_id', Auth::id())->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }
}
