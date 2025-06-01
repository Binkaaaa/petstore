<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Admin: Paginated reviews view
    public function adminIndex()
    {
        $reviews = Review::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.reviews.index', compact('reviews'));
    }

    // API: List all reviews
    public function index()
    {
        return response()->json(Review::all());
    }

    // API: Get one review
    public function show($id)
    {
        $review = Review::find($id);
        if (!$review) {
            return response()->json(['error' => 'Review not found'], 404);
        }
        return response()->json($review);
    }

    // API: Store a new review
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|string', // Should match the Product model ID type
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        try {
            $review = Review::create([
                'product_id' => $request->product_id,
                'user_id'    => Auth::id(),  
                'rating' => $request->rating,
                'comment' => $request->comment ?? '',
            ]);

            return response()->json(['success' => true, 'review' => $review]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error saving review: ' . $e->getMessage()
            ], 500);
        }
    }

    // API: Update review
    public function update(Request $request, $id)
    {
        $review = Review::find($id);
        if (!$review) {
            return response()->json(['error' => 'Review not found'], 404);
        }

        $review->update($request->only(['rating', 'comment']));
        return response()->json(['success' => true, 'review' => $review]);
    }

    // API: Delete review
    public function destroy($id)
    {
        $review = Review::find($id);
        if (!$review) {
            return response()->json(['error' => 'Review not found'], 404);
        }

        $review->delete();
        return response()->json(['success' => true]);
    }
}