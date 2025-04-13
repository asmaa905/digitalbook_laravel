<?php

namespace App\Http\Controllers\Publisher;

use App\Models\Category;
use Illuminate\Http\Request;

class PublisherCategoryController extends BaseController
{


    public function create()
    {
        return $this->view('categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
        ]);

        Category::create($validated);

        return redirect()->route('publisher.books.create')
        ->with('success', 'Category Created successfully!');
    }

}