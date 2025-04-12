<?php

namespace App\Http\Controllers\Reader;

use App\Models\Book;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends BaseController
{
    // Store a new review
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        // Check if user already reviewed this book
        $existingReview = Review::where('user_id', Auth::id())
                                ->where('book_id', $request->book_id)
                                ->first();

        if ($existingReview) {
            return redirect()->back()->with('error', 'You have already reviewed this book.');
        }

        $review = Review::create([
            'user_id' => Auth::id(),
            'book_id' => $request->book_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        // Update book's average rating
        $this->updateBookRating($request->book_id);

        return redirect()->back()->with('success', 'Review added successfully!');
    }

    // Update an existing review
    public function update(Request $request, Review $review)
    {
        // $this->authorize('update', $review);

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        // Update book's average rating
        $this->updateBookRating($review->book_id);

        return redirect()->back()->with('success', 'Review updated successfully!');
    }

    // Delete a review
    public function destroy(Review $review)
    {
        // $this->authorize('delete', $review);
        
        $book_id = $review->book_id;
        $review->delete();

        // Update book's average rating
        $this->updateBookRating($book_id);

        return redirect()->back()->with('success', 'Review deleted successfully!');
    }

    // Helper method to update book's average rating
    private function updateBookRating($book_id)
    {
        $book = Book::findOrFail($book_id);
        $averageRating = Review::where('book_id', $book_id)->avg('rating');
        $book->update(['rating' => $averageRating]);
    }
}