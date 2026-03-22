<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        $featuredProducts = Product::take(4)->get();
        $categories = Category::all();
        $bestSellers = Product::orderBy('id', 'desc')->take(4)->get(); // just mock
        
        return view('pages.home', compact('featuredProducts', 'categories', 'bestSellers'));
    }

    public function shop(Request $request)
    {
        $query = Product::with('category');

        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        if ($request->has('sort')) {
            if ($request->sort == 'low_high') {
                $query->orderBy('price', 'asc');
            } elseif ($request->sort == 'high_low') {
                $query->orderBy('price', 'desc');
            } elseif ($request->sort == 'newest') {
                $query->latest();
            }
        } else {
            $query->latest();
        }

        $products = $query->paginate(12);
        $categories = Category::all();

        return view('pages.shop', compact('products', 'categories'));
    }

    public function product($slug)
    {
        $product = Product::with('reviews.user')->where('slug', $slug)->firstOrFail();
        return view('pages.product', compact('product'));
    }

    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }
}
