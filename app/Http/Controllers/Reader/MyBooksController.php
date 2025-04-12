<?php

namespace App\Http\Controllers\Reader;

use Illuminate\Http\Request;

class MyBooksController extends BaseController
{
    public function indexSavedBooks()
    {
        // Ensure only readers can access this
        if (Auth::user()->role !== 'Reader') {
            abort(403, 'Unauthorized action.');
        }

        // Get books that the user has marked as read
        $readBooks = Auth::user()->readedBooks()
            ->with(['author', 'categories'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('books.reader.index', compact('readBooks'));
    }
    public function storeSavedBooks()
    {
        // Ensure only readers can access this
        if (Auth::user()->role !== 'Reader') {
            abort(403, 'Unauthorized action.');
        }

        // Get books that the user has marked as read
        $readBooks = Auth::user()->readedBooks()
            ->with(['author', 'categories'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('books.reader.index', compact('readBooks'));
    }
    public function destorySavedBooks()
    {
        // Ensure only readers can access this
        if (Auth::user()->role !== 'Reader') {
            abort(403, 'Unauthorized action.');
        }

        // Get books that the user has marked as read
        $readBooks = Auth::user()->readedBooks()
            ->with(['author', 'categories'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('books.reader.index', compact('readBooks'));
    }
}
