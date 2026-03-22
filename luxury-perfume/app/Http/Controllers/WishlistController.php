<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Wishlist;
use App\Models\Product;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlistItems = Wishlist::with('product')
            ->where('user_id', auth()->id())
            ->get();

        return view('pages.wishlist', compact('wishlistItems'));
    }

    public function add($id)
    {
        $exists = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $id)
            ->first();

        if (!$exists) {
            Wishlist::create([
                'user_id' => auth()->id(),
                'product_id' => $id
            ]);
            return back()->with('success', 'Added to Wishlist!');
        }

        return back()->with('info', 'Already in Wishlist!');
    }

    public function remove($id)
    {
        Wishlist::where('user_id', auth()->id())
            ->where('product_id', $id)
            ->delete();

        return back()->with('success', 'Removed from Wishlist!');
    }

    public function toggle($id)
    {
        $exists = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $id)
            ->first();

        if ($exists) {
            $exists->delete();
            return response()->json(['status' => 'removed', 'message' => 'Removed from Wishlist']);
        } else {
            Wishlist::create([
                'user_id' => auth()->id(),
                'product_id' => $id
            ]);
            return response()->json(['status' => 'added', 'message' => 'Added to Wishlist']);
        }
    }

    public function dashboardIndex()
    {
        $wishlistItems = Wishlist::with('product')
            ->where('user_id', auth()->id())
            ->get();

        return view('user.wishlist', compact('wishlistItems'));
    }
}
