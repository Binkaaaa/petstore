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
   // Get the logged-in user
    $user = Auth::user();

    // Access the cart items through relationships (adjust as needed)
    $cartItems = $user->cart->items ?? [];

    // Pass cart items to the checkout view
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

        // Retrieve cart from session
        $sessionCart = session()->get('cart', []);

        // Calculate total price
        $total = 0;
        foreach ($sessionCart as $productId => $item) {
            $product = Product::find($productId);
            if ($product) {
                $total += $product->price * $item['qty'];
            }
        }

        // Create the order
        $order = Order::create([
            'user_id'           => Auth::id(),
            'total_price'       => $total,
            'order_status'      => 'pending',
            'order_type'        => $data['order_type'],
            'delivery_address'  => $data['delivery_address'] ?? null,
            'delivery_city'     => $data['delivery_city'] ?? null,
            'delivery_postcode' => $data['delivery_postcode'] ?? null,
            'delivery_phone'    => $data['delivery_phone'] ?? null,
        ]);

        // Clear cart
        session()->forget('cart');

        return redirect()->route('dashboard')
                         ->with('success', 'Your order has been placed successfully.');
    }
}