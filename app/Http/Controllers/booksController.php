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
        $readBooks = Auth::user()->readedBooks()
            ->with(['author', 'category'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('books.reader.index', compact('readBooks'));
    }
    public function indexFavBooks()
    {
        // Ensure only readers can access this
        if (Auth::user()->role !== 'Reader') {
            abort(403, 'Unauthorized action.');
        }

        // Get books that the user has marked as read
        $favBooks = Auth::user()->favBooks()
            ->with(['author', 'category'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('books.reader.fav', compact('favBooks'));
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

        return view('publisher.books.index', compact('publishedBooks'));
    }

    public function show_audio_books()
    {
        // Get books that have at least one audio version (audio_link not null)
        $books = Book::whereHas('audioVersions', function($query) {
                $query->whereNotNull('audio_link');
            })
            ->where('is_published', 'accepted')

            ->with(['author', 'audioVersions'])
            ->orderBy('title')
            ->get();
    
        $topRatedBooks = Book::whereHas('audioVersions', function($query) {
                $query->whereNotNull('audio_link');
            })
            ->where('is_published', 'accepted')

            ->with(['author', 'audioVersions'])
            ->orderByDesc('rating')
            ->take(20)
            ->get();
    
        $isFeaturedBooks = Book::whereHas('audioVersions', function($query) {
                $query->whereNotNull('audio_link');
            })
            ->where('is_published', 'accepted')

            ->with(['author', 'audioVersions'])
            ->where(function($query) {
                // $query->where('is_featured', 1)
                $query->orWhereHas('publisher', function($publisherQuery) {
                        // Use the full subscription check here
                        $publisherQuery->whereHas('subscriptions', function($subQuery) {
                            $subQuery->where('status', 'confirm')
                                ->where(function($q) {
                                    $q->where('end_date', '>', now())
                                      ->orWhereNull('end_date');
                                });
                        });
                    });
            })
            ->take(20)
            ->get();
    
        $book_type = 'audio';
        
        return view('user.Books.index', compact('books', 'topRatedBooks', 'isFeaturedBooks', 'book_type'));
    }

    public function show_ebooks()
    {
        // Get books that have PDF link AND no audio versions
        $books = Book::whereNotNull('pdf_link')
            ->where('is_published', 'accepted')

            ->with(['author', 'audioVersions'])
            ->orderBy('title')
            ->get();
    
        $topRatedBooks = Book::whereNotNull('pdf_link')
            ->with(['author', 'audioVersions'])
            ->where('is_published', 'accepted')

            ->orderByDesc('rating')
            ->take(20)
            ->get();
    
            $isFeasuredBooks = Book::whereNotNull('pdf_link')
            ->where('is_published', 'accepted')
            ->where(function($query) {
                // $query->where('is_featured', 1)
                $query->orWhereHas('publisher', function($publisherQuery) {
                        // Use the full subscription check here
                        $publisherQuery->whereHas('subscriptions', function($subQuery) {
                            $subQuery->where('status', 'confirm')
                                ->where(function($q) {
                                    $q->where('end_date', '>', now())
                                      ->orWhereNull('end_date');
                                });
                        });
                    });
            })
            ->with(['author', 'audioVersions'])
            ->take(20)
            ->get();
    
        $book_type = 'ebook';
    
        return view('user.Books.index', compact('books', 'topRatedBooks', 'isFeasuredBooks', 'book_type'));
    }
    
    //show book with its review number  
    // audioversion of that book
    // rating of book
    //author
    //publisher of audio book created_by in audio_version
    // and publisher of book
    //catgory of book
    //language of book
    //book keywords

    //show books that is in the same category of book
    //and all books

    //show book rating and all review and comments if found
    public function show($bookId)
    {
        // Get the book with all related data
        $book = Book::with([
            'author',
            'category',
            'publishingHouse',
            'publisher', // The user who published the book
            'audioVersions' => function($query) {
                $query->with(['creator' => function($q) {
                    $q->select('id', 'name'); // Audio version creator (user)
                }]);
            },
            'reviews' => function($query) {
                $query->with(['user' => function($q) {
                    $q->select('id', 'name'); // Review author
                }])
                ->orderBy('created_at', 'desc');
            }
        ])->findOrFail($bookId);
    
        // Calculate review statistics
        $reviewCount = $book->reviews->count();
        $averageRating = $book->reviews->avg('rating') ?? $book->rating ?? 0;
    
        // Get related books (same category and language)
        $relatedBooks = Book::where('category_id', $book->category_id)
           ->where('is_published', 'accepted')
            ->where('id', '!=', $book->id)
            ->with(['author', 'category'])
            ->orderBy('rating', 'desc')
            ->take(8)
            ->get();
    
        // Get similar books (by same author and language)
        $authorBooks = Book::where('author_id', $book->author_id)
           ->where('is_published', 'accepted')

            ->where('id', '!=', $book->id)
            ->when($book->language, function($query, $language) {
                $query->where('language', $language); // Filter by same language if available
            })
            ->with(['author', 'category'])
            ->orderBy('rating', 'desc')
            ->take(4)
            ->get();
    
        // Get available formats
        $availableFormats = [];
        if ($book->pdf_link) {
            $availableFormats[] = 'E-book';
        }
        if ($book->audioVersions->count() > 0) {
            $availableFormats[] = 'Audiobook';
        }
    
        return view('user.books.show', compact(
            'book',
            'reviewCount',
            'averageRating',
            'relatedBooks',
            'authorBooks',
            'availableFormats'
        ));
    }
    public function markAsRead(Book $book)
    {
        if (auth()->user()->readedBooks()->where('book_id', $book->id)->exists()) {
            return back()->with('info', 'You have already marked this book as read');
        }
    
        auth()->user()->readedBooks()->attach($book->id, ['read_date' => now()->toDateString()]);
        
        return back()->with('success', 'Book marked as read');
    }
    public function toggleBookFav(Book $book)
    {
        $user = auth()->user();
        
        if ($user->favBooks()->where('book_id', $book->id)->exists()) {
            // Remove from favorites
            $user->favBooks()->detach($book->id);
            return back()->with('success', 'Book removed from favorites');
        }
        
        // Add to favorites
        $user->favBooks()->attach($book->id);
        return back()->with('success', 'Book added to favorites');
    }
}