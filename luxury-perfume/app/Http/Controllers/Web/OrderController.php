<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{


    public function index()
    {
        $orders = Order::with('items.perfume')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
            
        return view('orders.index', compact('orders'));
    }

    public function checkout(Request $request)
    {
        $cartItems = Cart::with('perfume')->where('user_id', Auth::id())->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $total = $cartItems->sum(function($item) {
            return $item->perfume->price * $item->quantity;
        });

        DB::beginTransaction();

        try {
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $total,
                'status' => 'pending',
                'payment_method' => 'cash_on_delivery', // Default for now
            ]);

            foreach ($cartItems as $item) {
                // Check stock
                if ($item->perfume->stock < $item->quantity) {
                    throw new \Exception("Product {$item->perfume->name} is out of stock.");
                }

                // Decrease stock
                $item->perfume->decrement('stock', $item->quantity);

                // Create Order Item
                OrderItem::create([
                    'order_id' => $order->id,
                    'perfume_id' => $item->perfume_id,
                    'quantity' => $item->quantity,
                    'price' => $item->perfume->price,
                ]);
            }

            // Clear Cart
            Cart::where('user_id', Auth::id())->delete();

            DB::commit();

            return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')->with('error', $e->getMessage());
        }
    }
}
