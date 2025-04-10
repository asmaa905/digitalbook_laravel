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
            'price' => 'required|numeric|min:0',
            'publish_date' => 'required|date',
            'pdf_link' => 'nullable|file|mimes:pdf,docx|max:20480', // 20MB max
            'publish_house_id' => 'nullable|exists:publishing_houses,id',
            'category_id' => 'required|exists:categories,id',
            'author_id' => 'nullable|exists:authors,id',
            'language' => 'required|string|max:10',
            'image' => 'nullable|image|max:2048',
            'is_featured' => 'boolean',
        ]);
        if ($request->hasFile('pdf_link')) {
            $validated['pdf_link'] = $request->file('pdf_link')->store('books/pdfs', 'public');
        }


        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('books/covers', 'public');
        }

        $validated['published_by'] = auth()->id();
        $validated['is_featured'] = $request->has('is_featured');

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
            'price' => 'required|numeric|min:0',
            'publish_date' => 'required|date',
            'pdf_link' => 'nullable|file|mimes:pdf,docx|max:20480', // 20MB max
            'publish_house_id' => 'nullable|exists:publishing_houses,id',
            'category_id' => 'required|exists:categories,id',
            'author_id' => 'nullable|exists:authors,id',
            'language' => 'required|string|max:10',
            'image' => 'nullable|image|max:2048',
            'is_featured' => 'boolean',
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

        $validated['is_featured'] = $request->has('is_featured');

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