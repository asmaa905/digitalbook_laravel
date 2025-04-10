<?php

// app/Http/Controllers/BookController.php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\PublishHouse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with(['category', 'publishHouse', 'publisher'])->latest()->paginate(10);
        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        $categories = Category::all();
        $publishHouses = PublishHouse::all();
        $publishers = User::where('role', 'publisher')->get();
        
        return view('admin.books.create', compact('categories', 'publishHouses', 'publishers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'publish_house_id' => 'required|exists:publish_houses,id',
            'user_id' => 'required|exists:users,id',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ebook_file' => 'nullable|file|mimes:pdf,epub',
            'audio_file' => 'nullable|file|mimes:mp3,wav',
        ]);

        // Upload cover image
        $validated['cover_image'] = $request->file('cover_image')->store('books/covers', 'public');
        
        // Upload ebook file if exists
        if ($request->hasFile('ebook_file')) {
            $validated['ebook_file'] = $request->file('ebook_file')->store('books/ebooks', 'public');
        }
        
        // Upload audio file if exists
        if ($request->hasFile('audio_file')) {
            $validated['audio_file'] = $request->file('audio_file')->store('books/audios', 'public');
        }
        
        Book::create($validated);
        
        return redirect()->route('admin.books.index')->with('success', 'Book created successfully');
    }

    public function show(Book $book)
    {
        return view('admin.books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        $categories = Category::all();
        $publishHouses = PublishHouse::all();
        $publishers = User::where('role', 'publisher')->get();
        
        return view('admin.books.edit', compact('book', 'categories', 'publishHouses', 'publishers'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'publish_house_id' => 'required|exists:publish_houses,id',
            'user_id' => 'required|exists:users,id',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ebook_file' => 'nullable|file|mimes:pdf,epub',
            'audio_file' => 'nullable|file|mimes:mp3,wav',
        ]);

        // Update cover image if provided
        if ($request->hasFile('cover_image')) {
            // Delete old cover image
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('books/covers', 'public');
        }
        
        // Update ebook file if provided
        if ($request->hasFile('ebook_file')) {
            // Delete old ebook file
            if ($book->ebook_file) {
                Storage::disk('public')->delete($book->ebook_file);
            }
            $validated['ebook_file'] = $request->file('ebook_file')->store('books/ebooks', 'public');
        }
        
        // Update audio file if provided
        if ($request->hasFile('audio_file')) {
            // Delete old audio file
            if ($book->audio_file) {
                Storage::disk('public')->delete($book->audio_file);
            }
            $validated['audio_file'] = $request->file('audio_file')->store('books/audios', 'public');
        }
        
        $book->update($validated);
        
        return redirect()->route('admin.books.index')->with('success', 'Book updated successfully');
    }

    public function destroy(Book $book)
    {
        // Delete files
        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }
        if ($book->ebook_file) {
            Storage::disk('public')->delete($book->ebook_file);
        }
        if ($book->audio_file) {
            Storage::disk('public')->delete($book->audio_file);
        }
        
        $book->delete();
        return redirect()->route('admin.books.index')->with('success', 'Book deleted successfully');
    }

    public function publish(Book $book)
    {
        $book->update([
            'is_published' => true,
            'published_date' => now(),
        ]);
        
        return redirect()->back()->with('success', 'Book published successfully');
    }
}
