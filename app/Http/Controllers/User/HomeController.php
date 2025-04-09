<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller; // Add this line

use App\Models\Book;

use Illuminate\Http\Request;

class HomeController extends Controller
{
   

    public function index()
    {
        // Top 50 rated books
        $topRatedBooks = Book::with(['author', 'audioVersions'])
            ->orderByDesc('rating')
            ->take(20)
            ->get();
    
        // All books with required info
        $allBooks = Book::with(['author', 'audioVersions'])
            ->orderBy('title')
            ->get();
    
        $isFeasuredBooks = Book::with(['author', 'audioVersions'])
            ->where('is_featured', true)
            ->take(20)
            ->get();
        $planOptions = [
            'Free' => [
                'price' => 0,
                'features' => [
                    'Limited audiobook access',
                    'Basic listening features',
                    '1 device'
                ]
            ],
            'Premium' => [
                'price' => 9.99,
                'features' => [
                    'Unlimited audiobook access',
                    'Offline listening',
                    'Multiple devices',
                    'Exclusive content',
                    'No ads'
                ]
            ]
        ];
    
        return view('user.home', compact('topRatedBooks', 'allBooks','planOptions','isFeasuredBooks'));
    }
    
}
