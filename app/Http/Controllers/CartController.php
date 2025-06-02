<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    /**
     * Display the cart contents.
     */
    public function index(Request $request)
    {
        // Assuming you store cart in session as [ product_id => ['qty' => x], ... ]
        $sessionCart = $request->session()->get('cart', []);

        // Load the Product models for each item
        $cartItems = collect($sessionCart)
            ->map(function($item, $productId) {
                $product = Product::find($productId);
                return $product
                    ? [
                        'product'  => $product,
                        'quantity' => $item['qty'],
                        'subtotal' => $product->price * $item['qty'],
                      ]
                    : null;
            })
            ->filter(); // remove any nulls

        // Calculate total
        $total = $cartItems->sum('subtotal');

        return view('cart.index', compact('cartItems', 'total'));
    }

    /**
     * Add a product to cart.
     */
    public function add(Request $request, Product $product)
    {
        $qty = $request->input('quantity', 1);

        $cart = $request->session()->get('cart', []);
        $cart[$product->id]['qty'] = ($cart[$product->id]['qty'] ?? 0) + $qty;
        $request->session()->put('cart', $cart);

        return redirect()->route('cart.index')
                         ->with('success', 'Product added to cart.');
    }
    public function remove(Request $request, Product $product)
    {
        $cart = $request->session()->get('cart', []);

        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            $request->session()->put('cart', $cart);
        }

        return redirect()
            ->route('cart.index')
            ->with('success', "{$product->name} removed from cart.");
    }
    
}
