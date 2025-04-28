<?php

// app/Http/Controllers/CommentController.php
namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::with(['book', 'user'])->latest()->paginate(10);
        return view('admin.comments.index', compact('comments'));
    }
}