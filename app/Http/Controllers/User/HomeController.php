<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller; // Add this line

use App\Models\Book;
use App\Models\Plan;

use Illuminate\Http\Request;

class HomeController extends Controller
{
   

    public function index()
    {
        // Top 50 rated books
        $topRatedBooks = Book::with(['author', 'audioVersions'])
            ->orderByDesc('rating')
            ->where('is_published', 'accepted')
            ->take(20)
            ->get();
        // All books with required info
        $allBooks = Book::with(['author', 'audioVersions'])
            ->orderBy('title')
            ->where('is_published', 'accepted')

            ->get();
    
        $isFeasuredBooks = Book::with(['author', 'audioVersions'])
            ->where('is_published', 'accepted')
            ->where(function($query) {
                // $query->where('is_featured', 1)
                $query->orWhereHas('publisher', function($publisherQuery) {
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
            ->take(20)
            ->get();
    
            
        $plans = Plan::all();
        $hasActiveSubscription = false;
        
        if (auth()->check()) { // Check if user is logged in
            $user = auth()->user();
            $hasActiveSubscription = $user->subscriptions()
                ->where('status', 'confirm')
                ->where(function($query) {
                    $query->where('end_date', '>', now())
                        ->orWhereNull('end_date');
                })
                ->exists();
        }
        
        
        return view('user.home', compact('topRatedBooks', 'allBooks', 'plans' ,
        'hasActiveSubscription', 'isFeasuredBooks'));
    }
    
}
