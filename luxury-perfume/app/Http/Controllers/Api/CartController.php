<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Product;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cartItems = $request->user()->cartItems()->with('product')->get();
        return response()->json([
            'cart_items' => $cartItems
        ]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'integer|min:1'
        ]);

        $user = $request->user();
        $productId = $request->product_id;
        $quantity = $request->quantity ?? 1;

        $cartItem = $user->cartItems()->where('product_id', $productId)->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            $cartItem = $user->cartItems()->create([
                'product_id' => $productId,
                'quantity' => $quantity
            ]);
        }

        return response()->json([
            'message' => 'Product added to cart',
            'cart_item' => $cartItem
        ]);
    }

    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:cart_items,product_id'
        ]);

        $user = $request->user();
        $user->cartItems()->where('product_id', $request->product_id)->delete();

        return response()->json([
            'message' => 'Product removed from cart'
        ]);
    }
}
