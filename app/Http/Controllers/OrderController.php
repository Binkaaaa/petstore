<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of all orders (admin view).
     */
    public function index()
    {
        // Eager-load related user
        $orders = Order::with('user')->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.orders.index', compact('orders'));
        
    }

    /**
     * Store a newly created order in storage.
     */
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

    /**
     * Display the specified order (admin view).
     */
    public function show($id)
    {
        $order = Order::with('user')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update the specified order in storage (e.g., status change).
     */
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $data = $request->validate([
            'order_status' => 'required|string|max:50',
            'delivery_status' => 'nullable|string|max:50',
        ]);
        $order->update($data);

        return redirect()->route('admin.orders.index')
                         ->with('success', 'Order updated successfully.');
    }

    public function destroy($id)
{
    $order = Order::find($id);

    if (!$order) {
        return redirect()->route('admin.orders.index')->with('error', 'Order not found.');
    }

    $order->delete();

    return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully.');
}
}
