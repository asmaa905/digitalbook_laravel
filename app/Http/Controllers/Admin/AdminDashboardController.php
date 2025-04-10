<?php

namespace App\Http\Controllers\Admin;

use App\Models\Book;
use App\Models\AudioVersion;

class AdminDashboardController extends BaseController
{
    public function index()
    {
        $stats = [
            'total_books' => Book::count(),
            'books_appear_in_home_page' => Book::where('is_published', 'accepted')->count(),
            'featured_books' => Book::where('is_featured', true)->count(),
            'audio_versions' => AudioVersion::count(),
            'ebooks' => Book::whereNotNull('pdf_link')->count(),
        ];
        
        $recentBooks = Book::latest()
            ->take(5)
            ->get();
            
        $recentAudio = AudioVersion::latest()
            ->take(5)
            ->get();

        return $this->view('dashboard', compact('stats', 'recentBooks', 'recentAudio'));
    }
}