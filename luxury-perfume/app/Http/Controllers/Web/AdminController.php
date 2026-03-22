<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Perfume;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{


    public function dashboard()
    {
        $totalSales = Order::where('status', 'delivered')->sum('total_amount');
        $totalOrders = Order::count();
        $totalPerfumes = Perfume::count();
        $totalUsers = User::where('role', 'customer')->count();

        $recentOrders = Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('totalSales', 'totalOrders', 'totalPerfumes', 'totalUsers', 'recentOrders'));
    }

    // Categories Methods
    public function categories()
    {
        $categories = Category::with('perfumes')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255', 'description' => 'nullable|string']);
        Category::create($request->all());
        return back()->with('success', 'Category added.');
    }

    public function updateCategory(Request $request, $id)
    {
        $request->validate(['name' => 'required|string|max:255', 'description' => 'nullable|string']);
        Category::findOrFail($id)->update($request->all());
        return back()->with('success', 'Category updated.');
    }

    public function destroyCategory($id)
    {
        Category::findOrFail($id)->delete();
        return back()->with('success', 'Category deleted.');
    }

    // Perfumes Methods
    public function perfumes()
    {
        $perfumes = Perfume::with('category')->latest()->paginate(10);
        $categories = Category::all();
        return view('admin.perfumes.index', compact('perfumes', 'categories'));
    }

    public function storePerfume(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/products'), $imageName);
            $data['image'] = 'images/products/' . $imageName;
        }

        Perfume::create($data);
        return back()->with('success', 'Product added.');
    }

    public function updatePerfume(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/products'), $imageName);
            $data['image'] = 'images/products/' . $imageName;
        }

        Perfume::findOrFail($id)->update($data);
        return back()->with('success', 'Product updated.');
    }

    public function destroyPerfume($id)
    {
        Perfume::findOrFail($id)->delete();
        return back()->with('success', 'Perfume deleted.');
    }

    // Orders Methods
    public function orders()
    {
        $orders = Order::with(['user', 'items.perfume'])->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:pending,processing,shipped,delivered,cancelled']);
        Order::findOrFail($id)->update(['status' => $request->status]);
        return back()->with('success', 'Order status updated.');
    }
}
