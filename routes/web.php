<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


// routes/web.php
Route::get('/', function () {
    return redirect()->route('login'); // Or your home route
});

// routes/web.php
Route::prefix('admin')->middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Users
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    
    // Categories
    Route::resource('categories', CategoryController::class)->except(['show']);
    
    // Publish Houses
    Route::resource('publish-houses', PublishHouseController::class)->except(['show']);
    
    // Books
    Route::resource('books', BookController::class);
    Route::post('/books/{book}/publish', [BookController::class, 'publish'])->name('admin.books.publish');
    
    // Reviews
    Route::get('/reviews', [ReviewController::class, 'index'])->name('admin.reviews.index');
    
    // Comments
    Route::get('/comments', [CommentController::class, 'index'])->name('admin.comments.index');
});

require __DIR__.'/auth.php';
