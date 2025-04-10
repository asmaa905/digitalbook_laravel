<?php

// app/Http/Controllers/AdminController.php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Review;
use App\Models\Comment;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalBooks = Book::count();
        $totalUsers = User::count();
        $totalReviews = Review::count();
        $recentBooks = Book::latest()->take(5)->get();
        
        return view('admin.dashboard', compact('totalBooks', 'totalUsers', 'totalReviews', 'recentBooks'));
    }
}
