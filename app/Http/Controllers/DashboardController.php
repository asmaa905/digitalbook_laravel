<?php
// app/Http/Controllers/Admin/DashboardController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Book;
use App\Models\Category;
use App\Models\PublishHouse;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => User::where('role_id', '!=', 1)->count(),
            'books' => Book::count(),
            'categories' => Category::count(),
            'publishHouses' => PublishHouse::count(),
        ];
        
        return view('admin.dashboard', compact('stats'));
    }
}