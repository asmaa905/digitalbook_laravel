<?php

namespace App\Http\Controllers\Admin;

use App\Models\Review;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;

class AdminReviewController extends  BaseController

{
    /**
     * Display a listing of reviews with filters
     */
    public function index(Request $request)
    {
        $query = Review::with(['user', 'book'])
            ->latest();

        // Filter by rating
        if ($request->has('rating')) {
            $query->where('rating', $request->rating);
        }

        // Filter by book
        if ($request->has('book_id')) {
            $query->where('book_id', $request->book_id);
        }

        // Filter by user
        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $reviews = $query->paginate(20);
        $books = Book::orderBy('title')->get();
        $users = User::where('role', 'Reader')->orderBy('name')->get();

        return view('Admin.reviews.index', compact('reviews', 'books', 'users'));
    }


    /**
     * Display the specified review
     */
    public function show(Review $review)
    {
        return view('Admin.reviews.show', compact('review'));
    }


    /**
     * Remove the specified review
     */
    public function destroy(Review $review)
    {
        $book = $review->book;
        $review->delete();

        // Update book rating after deletion
        $this->updateBookRating($book);

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review deleted successfully!');
    }

    /**
     * Helper method to update book's average rating
     */
    private function updateBookRating(Book $book)
    {
        $averageRating = $book->reviews()->avg('rating');
        $book->update(['rating' => $averageRating]);
    }
}