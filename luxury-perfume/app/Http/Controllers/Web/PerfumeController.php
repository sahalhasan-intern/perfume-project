<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Perfume;
use Illuminate\Http\Request;

class PerfumeController extends Controller
{
    public function index(Request $request)
    {
        $query = Perfume::with('category')->latest();
        
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        $perfumes = $query->paginate(12)->withQueryString();
        $categories = Category::withCount('perfumes')->get();
        
        return view('perfumes.index', compact('perfumes', 'categories'));
    }

    public function show($id)
    {
        $perfume = Perfume::with('category')->findOrFail($id);
        return view('perfumes.show', compact('perfume'));
    }

    public function home()
    {
        $featuredPerfumes = Perfume::inRandomOrder()->take(3)->get();
        $categories = Category::withCount('perfumes')->get();
        
        return view('web.home', compact('featuredPerfumes', 'categories'));
    }
}
