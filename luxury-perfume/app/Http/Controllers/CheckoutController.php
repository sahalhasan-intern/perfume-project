<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        if (session()->has('buy_now')) {
            $cart = session()->get('buy_now');
        } else {
            $cart = session()->get('cart', []);
            if(empty($cart)) {
                return redirect()->route('shop');
            }
        }
        return view('pages.checkout', compact('cart'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'phone' => 'required|string',
        ]);

        $isBuyNow = session()->has('buy_now');
        $cart = $isBuyNow ? session()->get('buy_now') : session()->get('cart', []);
        
        if(empty($cart)) {
            return redirect()->route('shop');
        }

        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'total' => $total,
            'shipping_address' => $request->shipping_address,
            'phone' => $request->phone,
            'status' => 'Order Placed'
        ]);

        foreach($cart as $id => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);
        }

        if ($isBuyNow) {
            session()->forget('buy_now');
        } else {
            session()->forget('cart');
        }

        return redirect()->route('dashboard')->with('success', 'Order placed successfully!');
    }

    public function buyNow($id)
    {
        $product = Product::findOrFail($id);

        $buyNowItem = [
            $product->id => [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->sale_price ?? $product->price,
                "image" => $product->image,
                "slug" => $product->slug
            ]
        ];

        session()->put('buy_now', $buyNowItem);

        return redirect()->route('checkout.index');
    }
}
