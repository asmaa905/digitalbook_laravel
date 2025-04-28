<?php

// app/Http/Controllers/ReviewController.php
namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['book', 'user'])->latest()->paginate(10);
        return view('admin.reviews.index', compact('reviews'));
    }
}