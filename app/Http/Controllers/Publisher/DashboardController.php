<?php

namespace App\Http\Controllers\Publisher;

use App\Models\Book;
use App\Models\AudioVersion;

class DashboardController extends BaseController
{
    public function index()
    {
        $stats = [
            'total_books' => Book::where('published_by', auth()->id())->count(),
            'published_books' => Book::where('published_by', auth()->id())->where('is_published', 'accepted')->count(),
            'audio_versions' => AudioVersion::whereHas('book', function($q) {
                $q->where('published_by', auth()->id());
            })->count(),
        ];
        
        $recentBooks = Book::where('published_by', auth()->id())
            ->latest()
            ->take(5)
            ->get();
            
        $recentAudio = AudioVersion::whereHas('book', function($q) {
                $q->where('published_by', auth()->id());
            })
            ->latest()
            ->take(5)
            ->get();

        return $this->view('dashboard', compact('stats', 'recentBooks', 'recentAudio'));
    }
}