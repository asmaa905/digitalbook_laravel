<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\booksController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Publisher\SubscriptionController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\CategoryController;

// Route::get('/', function () {
//     return view('user.home');
// });



Route::get('/dashboard', function () {
    if (Auth::check()) {
        return match (Auth::user()->role) {
            'Reader' => redirect()->route('user.home'),
            'Publisher' => redirect()->route('user.home'),
            'Admin' => redirect()->route('admin.dashboard'),
            default => redirect('/login'),
        };
    }
    return redirect('/login'); // If not logged in, redirect to login
})->name('dashboard');

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    //home page
    Route::get('/', [HomeController::class, 'index'])->name('user.home');

    //categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('user.categories.index');
    Route::get('/categories/{id}', [BooksController::class, 'show'])->name('user.categories.show');


    // books
    Route::get('/audio-books', [BooksController::class, 'show_audio_books'])->name('user.books.audio');
    Route::get('/e-books', [BooksController::class, 'show_ebooks'])->name('user.books.ebooks');
    Route::get('/books/{id}', [BooksController::class, 'show'])->name('user.books.show');


});

// Route::get('/books/create/{id}', [booksController::class, 'create'])->name('books.create');

// Route::post('/books/{id}', [booksController::class, 'store'])->name('books.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/profile/security', [ProfileController::class, 'security'])->name('profile.security');
    // Subscription Routes

    Route::get('/subscription', [SubscriptionController::class, 'index'])->name('subscription.index');
    Route::post('/subscription/upgrade', [SubscriptionController::class, 'upgrade'])->name('subscription.upgrade');
    Route::post('/subscription/cancel', [SubscriptionController::class, 'cancel'])->name('subscription.cancel');

    //publisher page
    Route::get('/my-published-books', [booksController::class, 'indexPublishedBooks'])->name('books.publisher.index');
    //reader pages
    Route::get('/readed-books', [booksController::class, 'indexReadedBooks'])->name('books.reader.index');
    // admin pages
    Route::get('/admin/dashboard', [adminController::class, 'indexReadedBooks'])->name('admin.dashboard');



});

require __DIR__.'/auth.php';
