<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;

class ProductController extends Controller
{
    // ===== API METHODS =====

    // List all products (API)
    public function index()
    {
        $products = Product::with('category', 'user')->paginate(10); // Paginate for better performance
        return ProductResource::collection($products);
    }

    // Show a single product (API)
    public function showApi($id)
    {
        $product = Product::with('category', 'user')->find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found.'], 404);
        }

        return new ProductResource($product);
    }

    // Store a new product (API)
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = $validator->validated();
        $data['user_id'] = Auth::id() ?? 1;

        $product = Product::create($data);

        return new ProductResource($product);
    }

    // Update an existing product (API)
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found.'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name'        => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'sometimes|numeric|min:0',
            'stock'       => 'sometimes|integer|min:0',
            'image'       => 'nullable|string',
            'user_id'     => 'sometimes|exists:users,id',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $product->update($validator->validated());

        return new ProductResource($product);
    }

    // Delete a product (API)
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found.'], 404);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully.']);
    }

    // ===== WEB METHODS =====

    // Show products by category (web view)
    public function showByCategory($categoryName)
    {
        $category = Category::where('name', $categoryName)->firstOrFail();
        $products = $category->products()->paginate(10);

        return view('products.by-category', compact('category', 'products'));
    }

    // Admin products management page (web view)
    public function adminProductsPage()
    {
        $products = Product::with('category')->paginate(20);
        return view('admin.products', compact('products'));
    }

    // Show single product page with reviews (web view)
    public function showView(Product $product)
    {
        $product->load('category');

        // Fetch reviews from MongoDB where product_id matches (string)
        $reviews = Review::where('product_id', (string) $product->id)->get();

       
        return view('products.show', compact('product', 'reviews'));
    }



}
