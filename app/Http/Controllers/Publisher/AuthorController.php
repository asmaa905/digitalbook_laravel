<?php

namespace App\Http\Controllers\Publisher;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AuthorController extends BaseController
{
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

        return redirect()->route('publisher.books.create')
        ->with('success', 'Author Created successfully!');
    }

}