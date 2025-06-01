<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    //

public function index()
{
    $user = Auth::user();

    // What is in session cart?
    $sessionCart = session()->get('cart', []);
    logger('Session Cart:', $sessionCart);

    // What is in user cart items?
    $userCartItems = $user->cart->items ?? collect();
    logger('User Cart Items:', $userCartItems->toArray());

    // Choose your source (session or user cart)
    // For now, let's just use the session cart to make sure it's consistent with store()
    $cartItems = collect();

    if (!empty($sessionCart)) {
        foreach ($sessionCart as $productId => $item) {
            $product = \App\Models\Product::find($productId);
            if ($product) {
                $cartItems->push([
                    'product' => $product,
                    'quantity' => $item['qty'],
                ]);
            }
        }
    }

    return view('checkout.index', compact('cartItems'));
}


public function store(Request $request)
{
    $data = $request->validate([
        'order_type'       => 'required|in:pickup,delivery',
        'delivery_address' => 'required_if:order_type,delivery|string|max:255',
        'delivery_city'    => 'required_if:order_type,delivery|string|max:100',
        'delivery_postcode'=> 'required_if:order_type,delivery|string|max:20',
        'delivery_phone'   => 'required_if:order_type,delivery|string|max:20',
    ]);

    $sessionCart = session()->get('cart', []);
    $total = 0;

    foreach ($sessionCart as $productId => $item) {
        $product = \App\Models\Product::find($productId);
        if ($product) {
            $total += $product->price * $item['qty'];
        }
    }

    \App\Models\Order::create([
        'user_id'           => Auth::id(),
        'total_price'       => $total,
        'order_status'      => 'pending',
        'order_type'        => $data['order_type'],
        'delivery_address'  => $data['delivery_address'] ?? null,
        'delivery_city'     => $data['delivery_city'] ?? null,
        'delivery_postcode' => $data['delivery_postcode'] ?? null,
        'delivery_phone'    => $data['delivery_phone'] ?? null,
    ]);

    session()->forget('cart');

return redirect()->route('order.success')
    ->with('success', 'Your order has been placed successfully.')
    ->with('phone', '011 1234 5678');

}
}