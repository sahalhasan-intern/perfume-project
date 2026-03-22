<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(20);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'nullable|integer',
            'description' => 'nullable|string',
        ]);
        // Ensure stock is set to an integer (database may require non-null)
        $data['stock'] = isset($data['stock']) ? (int) $data['stock'] : 0;

        $data['slug'] = \Str::slug($data['name']) . '-' . now()->timestamp;
        Product::create($data);
        return redirect()->route('admin.products.index')->with('success', 'Product created');
    }
}
