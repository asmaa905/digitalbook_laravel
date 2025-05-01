<?php

namespace App\Http\Controllers\Publisher;

use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use App\Models\PublishingHouse;
use App\Models\AudioVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends BaseController
{
    public function index()
    {
        $userId = auth()->id();
        
        $publishedBooks = Book::with(['author', 'category', 'publishingHouse', 'audioVersions','reviews'])
            ->where('published_by', $userId)
            ->where('is_published', 'accepted')
            ->latest()
            ->paginate(10);
    
   
    
        $waitingBooks = Book::with(['author', 'category', 'publishingHouse', 'audioVersions'])
            ->where('published_by', $userId)
            ->where('is_published', 'waiting')
            ->latest()
            ->paginate(10);
        
        $rejectedBooks = Book::with(['author', 'category', 'publishingHouse', 'audioVersions'])
            ->where('published_by', $userId)
            ->where('is_published', 'rejected')
            ->latest()
            ->paginate(10);
    
        $audioVersions = AudioVersion::with(['book', 'creator'])
            ->where('created_by', $userId)
            ->latest()
            ->paginate(10);
        return $this->view('books.index', compact('waitingBooks','audioVersions', 'publishedBooks', 'rejectedBooks'));
    }

    public function create()
    {
        // Check if publisher can create more books
        $user = auth()->user();
        $canCreateBook = $user->publishedBooks()->count() < 5 || $user->hasActiveSubscription;
        $canCreateAudio = $user->audioVersionsCreated()->count() < 5 || $user->hasActiveSubscription;
    
        if (!$canCreateBook) {
            return redirect()->route('publisher.books.index')
                ->with('error', 'You have reached your book limit. Please subscribe to publish more.');
        }
    
        $authors = Author::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        $publishingHouses = PublishingHouse::orderBy('name')->get();
        $type = 'create';
        
        return view('Publisher.books.create', compact(
            'authors', 
            'categories', 
            'publishingHouses',
            'type',
            'canCreateBook',
            'canCreateAudio'
        ));
    }
    
    public function store(Request $request)
    {
        // First check if user can create more books
        $user = auth()->user();
        $bookCount = $user->publishedBooks()->count();
        
        if ($bookCount >= 5 && !$user->hasActiveSubscription) {
            return redirect()->route('publisher.books.index')
                ->with('error', 'You have reached your book limit. Please subscribe to publish more.');
        }
    
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'language' => 'required|string|max:10',
            'publish_house_id' => 'nullable|exists:publishing_houses,id',
            'image' => 'required|image|max:2048', // 2MB max
            'pdf_link' => 'required|file|mimes:pdf|max:65240', // 10MB max for PDF
            'publish_date' => 'nullable|date',
            'is_featured' => 'nullable|boolean',
            'author_id' => 'required|exists:authors,id',
        ]);
    
        // Handle file uploads
        try {
            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('books/covers', 'public');
            }
    
            if ($request->hasFile('pdf_link')) {
                $validated['pdf_link'] = $request->file('pdf_link')->store('books/pdfs', 'public');
            }
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'File upload failed: ' . $e->getMessage());
        }
    
        // Set default values
        $validated['publish_date'] = $validated['publish_date'] ?? now();
        $validated['is_published'] = 'waiting'; // Default status
        $validated['published_by'] = $user->id;
        $validated['is_featured'] = $validated['is_featured'] ?? false;
        $validated['rating'] = 0; // Default rating
    
        // Create the book
        try {
            $book = Book::create($validated);
            
            return redirect()->route('publisher.books.index')
                ->with('success', 'Book created successfully! It will be published after review.');
        } catch (\Exception $e) {
            // Delete uploaded files if book creation fails
            if (isset($validated['image'])) {
                Storage::disk('public')->delete($validated['image']);
            }
            if (isset($validated['pdf_link'])) {
                Storage::disk('public')->delete($validated['pdf_link']);
            }
            
            return back()->withInput()
                ->with('error', 'Book creation failed: ' . $e->getMessage());
        }
    }

    public function show(Book $book)
    {
        // $this->authorize('view', $book);
        
        $book->load(['author', 'category', 'publishingHouse', 'audioVersions']);
        
        return $this->view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        // $this->authorize('update', $book);
        // Check if publisher can update more books
        $canCreateBook = true;
        $canCreateAudio = true;
       
        $authors = Author::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        $publishingHouses = PublishingHouse::orderBy('name')->get();
        $type = 'edit';
        
        return $this->view('books.create', compact('book', 'authors', 'categories', 'publishingHouses','type',
            'canCreateBook',
            'canCreateAudio'));
    }

    public function update(Request $request, Book $book)
    {
        // $this->authorize('update', $book);
        
        $validated = $request->validate([

            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'language' => 'required|string|max:10',
            'publish_house_id' => 'required|exists:publishing_houses,id',
            'image' => 'nullable|image|max:2048', //defualt null
            'pdf_link' => 'nullable|file|mimes:pdf|max:65240', // 10MB max for PDF //defualt null
            'publish_date' => 'nullable|date', //defualt now
            'is_featured' => 'nullable|boolean', //defualt false
            'author_id' => 'required|exists:authors,id', // //defualt null
            'is_published' => 'nullable|in:waiting,accepted,rejected',// //defualt waiting

        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($book->image) {
                Storage::disk('public')->delete($book->image);
            }
            $validated['image'] = $request->file('image')->store('books/covers', 'public');
        }

       
        if ($request->hasFile('pdf_link')) {
            // Delete old pdf_link if exists
            if ($book->pdf_link) {
                Storage::disk('public')->delete($book->pdf_link);
            }
            $validated['pdf_link'] = $request->file('pdf_link')->store('books/pdfs', 'public');
        }
 
        
        if (empty($validated['publish_date'])) {//
            $validated['publish_date'] = now();
        }

        if (empty($validated['is_published'])) {
            $validated['is_published'] = 'waiting';
        }
        if (empty($validated['published_by'])) {
            $validated['published_by'] = auth()->id();
        }
        if (empty($validated['is_featured'])) {
            $validated['is_featured'] = false;
        }

        $book->update($validated);

        return redirect()->route('publisher.books.index')
            ->with('success', 'Book updated successfully!');
    }

    public function destroy(Book $book)
    {        
        // Delete associated image if exists
        if ($book->image) {
            Storage::disk('public')->delete($book->image);
        }
        
        $book->delete();

        return redirect()->route('publisher.books.index')
            ->with('success', 'Book deleted successfully!');
    }
}