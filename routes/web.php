<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\booksController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SubscriptionController;
Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
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
