<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{
    /**
     * Admin: show paginated reviews.
     */
    public function adminIndex()
    {
        $reviews = Review::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * API: list all reviews.
     */
    public function index()
    {
        return response()->json(Review::all());
    }

    /**
     * API: show one review.
     */
    public function show($id)
    {
        $review = Review::find($id);
        if (! $review) {
            return response()->json(['error' => 'Review not found'], 404);
        }
        return response()->json($review);
    }

    /**
     * Store a new review for a given product.
     * Route: POST /products/{product}/reviews
     */
    public function store(Request $request, Product $product)
    {
        // 1) Confirm this is hit
        Log::info("ReviewController@store called for product {$product->id} by user ".Auth::id(), $request->all());

        // 2) Validate
        $validated = $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        // 3) Create
        $review = Review::create([
            'product_id' => (string) $product->id,
            'user_id'    => Auth::id(),
            'rating'     => $validated['rating'],
            'comment'    => $validated['comment'] ?? '',
        ]);

        // 4) Return JSON
        return response()->json(['success' => true, 'review' => $review], 201);
    }

    /**
     * API: update an existing review.
     */
    public function update(Request $request, $id)
    {
        $review = Review::find($id);
        if (! $review) {
            return response()->json(['error' => 'Review not found'], 404);
        }

        $validated = $request->validate([
            'rating'  => 'sometimes|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $review->update($validated);
        return response()->json(['success' => true, 'review' => $review]);
    }

    /**
     * API/Admin: delete a review.
     */
    public function destroy($id)
    {
        $review = Review::find($id);
        if ($review) {
            $review->delete();
            if (request()->wantsJson()) {
                return response()->json(['success' => true], 200);
            }
        }

        return redirect()
            ->route('admin.reviews.index')
            ->with('success', 'Review deleted successfully.');
    }
}
