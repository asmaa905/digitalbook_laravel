<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\booksController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/my-published-books', [booksController::class, 'indexPublishedBooks'])->name('books.publisher.index');
Route::get('/readed-books', [booksController::class, 'indexReadedBooks'])->name('books.reader.index');
// Route::get('/books/create/{id}', [booksController::class, 'create'])->name('books.create');

// Route::post('/books/{id}', [booksController::class, 'store'])->name('books.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


});

require __DIR__.'/auth.php';
