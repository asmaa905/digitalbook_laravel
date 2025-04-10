<?php

namespace App\Http\Controllers\Admin;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminAuthorController extends BaseController
{
    public function index()
    {
        $authors = Author::withCount('books')
            ->latest()
            ->paginate(10);
            
        return $this->view('authors.index', compact('authors'));
    }

    public function create()
    {
        return $this->view('authors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('authors', 'public');
        }

        Author::create($validated);

        return redirect()->route('admin.authors.index')
            ->with('success', 'Author created successfully!');
    }

    public function show(Author $author)
    {
        $author->loadCount('books');
        
        return $this->view('authors.show', compact('author'));
    }

    public function edit(Author $author)
    {
        return $this->view('authors.create', compact('author'));
    }

    public function update(Request $request, Author $author)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($author->image) {
                Storage::disk('public')->delete($author->image);
            }
            $validated['image'] = $request->file('image')->store('authors', 'public');
        }

        $author->update($validated);

        return redirect()->route('admin.authors.index')
            ->with('success', 'Author updated successfully!');
    }

    public function destroy(Author $author)
    {
        // Delete image if exists
        if ($author->image) {
            Storage::disk('public')->delete($author->image);
        }
        
        $author->delete();

        return redirect()->route('admin.authors.index')
            ->with('success', 'Author deleted successfully!');
    }
}