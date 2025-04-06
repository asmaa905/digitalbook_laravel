<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BooksController extends Controller
{
    /**
     * Get all books read by the authenticated reader
     */
    public function indexReadedBooks()
    {
        // Ensure only readers can access this
        if (Auth::user()->role !== 'Reader') {
            abort(403, 'Unauthorized action.');
        }

        // Get books that the user has marked as read
        $readBooks = Auth::user()->readBooks()
            ->with(['author', 'categories'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('books.reader.index', compact('readBooks'));
    }

    /**
     * Get all books published by the authenticated publisher
     */
    public function indexPublishedBooks()
    {
        // Ensure only publishers can access this
        if (Auth::user()->role !== 'Publisher') {
            abort(403, 'Unauthorized action.');
        }

        // Get books published by this user
        $publishedBooks = Book::where('published_by', Auth::id())
            ->with(['author', 'categories'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('books.publisher.index', compact('publishedBooks'));
    }
}