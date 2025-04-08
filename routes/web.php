<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\booksController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Publisher\SubscriptionController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\CategoryController;


// =============================
// ✅ Public Routes appear for login and non login users
// =============================
// Home page
Route::get('/', [HomeController::class, 'index'])->name('user.home');
// categories
Route::get('/categories', [CategoryController::class, 'index'])->name('user.categories.index');
Route::get('/categories/{id}', [BooksController::class, 'show'])->name('user.categories.show');
// books
Route::get('/audio-books', [BooksController::class, 'show_audio_books'])->name('user.books.audio');
Route::get('/e-books', [BooksController::class, 'show_ebooks'])->name('user.books.ebooks');
Route::get('/books/{id}', [BooksController::class, 'show'])->name('user.books.show');
// =============================
// ✅ Guest Routes appear for login and non login users
// =============================
Route::middleware('guest')->group(function () {

 
});
// =============================
// ✅ Auth Routes appear for login and non login users
// =============================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/security', [ProfileController::class, 'security'])->name('profile.security');
    // Route::get('/dashboard', [adminController::class, 'dashboard'])->name('dashboard');
});
// =============================
// ✅ Admin Routes appear for login and non login users
// =============================
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/dashboard',[adminController::class, 'dashboard'])->name('admin.dashboard');
});
// =============================
// ✅ Publisher Routes appear for login and non login users
// =============================
Route::middleware(['auth', 'role:Publisher'])->group(function () {
    // Subscription Routes
    Route::get('/subscription', [SubscriptionController::class, 'index'])->name('subscription.index');
    Route::post('/subscription/upgrade', [SubscriptionController::class, 'upgrade'])->name('subscription.upgrade');
    Route::post('/subscription/cancel', [SubscriptionController::class, 'cancel'])->name('subscription.cancel');
    // Book Routes
    Route::get('/books/create/{id}', [booksController::class, 'create'])->name('books.create');
    Route::post('/books/{id}', [booksController::class, 'store'])->name('books.store');
    Route::get('/my-published-books', [booksController::class, 'indexPublishedBooks'])->name('books.publisher.index');
});
// =============================
// ✅ Reader Routes appear for login and non login users
// =============================
Route::middleware(['auth', 'role:Reader'])->group(function () {
    Route::get('/readed-books', [booksController::class, 'indexReadedBooks'])->name('books.reader.index');
});

require __DIR__.'/auth.php';
