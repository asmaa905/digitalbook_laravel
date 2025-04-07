<?php

namespace App\Http\Controllers\user;
use App\Http\Controllers\Controller; // Add this line

use App\Models\Category;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Get all categories with their books
     */
    public function index()
    {
        // Eager load categories with their books
        $categories = Category::with(['books' => function($query) {
            $query->orderBy('title')->with(['author', 'audioVersions']);
        }])
        ->orderBy('name')
        ->get();
        
        return view('user.categories.index', compact('categories'));
    }
    
    /**
     * Get books for a specific category
     */
    public function show($categoryId)
    {
        $category = Category::with(['books' => function($query) {
            $query->orderBy('title')->with(['author', 'audioVersions']);
        }])
        ->findOrFail($categoryId);
        
        return view('user.categories.show', compact('category'));
    }

}