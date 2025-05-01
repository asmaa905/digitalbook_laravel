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
    // Get the category with its books, sorted by title
    $category = Category::with(['books' => function($query) {
        $query->orderBy('title')->with(['author', 'audioVersions']);
    }])->findOrFail($categoryId);

    // Get top-rated books in this category
    $topRatedBooks = $category->books()
        ->with(['author', 'audioVersions'])
        ->orderByDesc('rating')
        // ->where('rating','> 4')
        ->take(20)
        ->get();

    // Get featured books in this category
    $isFeasuredBooks = $category->books()
        ->where('is_published', 'accepted')
        ->where(function($query) {
             $query->where('is_featured', 1)
            ->orWhereHas('publisher', function($publisherQuery) {
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

    return view('user.categories.show', compact('category', 'isFeasuredBooks', 'topRatedBooks'));
}
    public function topBooksInCat($categoryId){
        // Get the category with its books, sorted by title
        $category = Category::with(['books' => function($query) {
            $query
            ->orderByDesc('rating')
            ->take(50)
            ->with(['author', 'audioVersions']);
        }])->findOrFail($categoryId);
    
    
        return view('user.Categories.topBooksInCat', compact('category',));

    }

}