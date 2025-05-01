<?php

namespace App\Http\Controllers\Admin;

use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use App\Models\PublishingHouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminBookController extends BaseController
{
    public function index()
    {
        $books = Book::with(['author', 'category', 'publishingHouse', 'audioVersions'])
        
            ->latest()
            ->paginate(10);
        return $this->view('books.index', compact('books'));
    }

    public function create()
    {
        $authors = Author::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        $publishingHouses = PublishingHouse::orderBy('name')->get();
        
        return $this->view('books.create', compact('authors', 'categories', 'publishingHouses'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'language' => 'required|string|max:10',
            'publish_house_id' => 'required|exists:publishing_houses,id',
            'is_published' => 'nullable|in:waiting,accepted,rejected',
            'image' => 'nullable|image|max:2048',
            'pdf_link' => 'nullable|file|mimes:pdf|max:65240',
            'publish_date' => 'nullable|date',
            'is_featured' => 'nullable|boolean', // Changed this line
            'author_id' => 'required|exists:authors,id',
        ]);

        if (empty($validated['publish_date'])) {//
            $validated['publish_date'] = now();
        }
    
        if ($request->hasFile('pdf_link')) {
            $validated['pdf_link'] = $request->file('pdf_link')->store('books/pdfs', 'public');
        }
    
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('books/covers', 'public');
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
    
        Book::create($validated);
    
        return redirect()->route('admin.books.index')
            ->with('success', 'Book created successfully!');
    }

    public function show(Book $book)
    {
        
        $book->load(['author', 'category', 'publishingHouse', 'audioVersions']);
        
        return $this->view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        
        $authors = Author::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        $publishingHouses = PublishingHouse::orderBy('name')->get();
        
        return $this->view('books.create', compact('book', 'authors', 'categories', 'publishingHouses'));
    }

    public function update(Request $request, Book $book)
    {
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'language' => 'required|string|max:10',
            'publish_house_id' => 'nullable|exists:publishing_houses,id',
            'is_published' => 'required|in:waiting,accepted,rejected',
            'image' => 'image|max:2048',
            'pdf_link' => 'file|mimes:pdf|max:65240',
            'publish_date' => 'required|date',
            'is_featured' => 'nullable|boolean', // Changed this line
            'author_id' => 'required|exists:authors,id',
        ]);


        if ($request->hasFile('pdf_link')) {
            if ($book->pdf_link) {
                Storage::disk('public')->delete($book->pdf_link);
            }

            $validated['pdf_link'] = $request->file('pdf_link')->store('books/pdfs', 'public');
        }


        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($book->image) {
                Storage::disk('public')->delete($book->image);
            }
            $validated['image'] = $request->file('image')->store('books/covers', 'public');
        }

        $validated['is_featured'] = $request->boolean('is_featured');

        if (empty($validated['is_featured'])) {
            $validated['is_featured'] = false;
        }
        
        // if (empty($validated['published_by'])) {
        //     $validated['published_by'] = auth()->id();
        // }
        $book->update($validated);

        return redirect()->route('admin.books.index')
            ->with('success', 'Book updated successfully!');
    }

    public function destroy(Book $book)
    {
        if ($book->pdf_link) {
            Storage::disk('public')->delete($book->pdf_link);
        }

        // Delete associated image if exists
        if ($book->image) {
            Storage::disk('public')->delete($book->image);
        }
        
        $book->delete();

        return redirect()->route('admin.books.index')
            ->with('success', 'Book deleted successfully!');
    }
}