<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\booksController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Publisher\SubscriptionController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\CategoryController;
//========================
// publisher controllers
//========================
use App\Http\Controllers\Publisher\DashboardController;
use App\Http\Controllers\Publisher\BookController;
use App\Http\Controllers\Publisher\AudioVersionController;
use App\Http\Controllers\Publisher\AuthorController;
use App\Http\Controllers\Publisher\PublishingHouseController;
use App\Http\Controllers\Publisher\PublisherCategoryController;
//=================================
// Admin controllers
//==================================
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminBookController;
use App\Http\Controllers\Admin\AdminAudioVersionController;
use App\Http\Controllers\Admin\AdminAuthorController;
use App\Http\Controllers\Admin\AdminPublishingHouseController;
use App\Http\Controllers\Admin\AdminCategoryController;
// =============================
// ✅ Public Routes appear for login and non login users
// =============================
Route::get('/', [HomeController::class, 'index'])->name('user.home');
Route::get('/categories', [CategoryController::class, 'index'])->name('user.categories.index');
Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('user.categories.show');
Route::get('/categories/top-books/{id}', [CategoryController::class, 'topBooksInCat'])->name('user.categories.topBooks');
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
});
// =============================
// ✅ Admin Routes appear for login and non login users
// =============================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:Admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Books Resource
    Route::resource('books', AdminBookController::class);
    
    // Audio Versions Resource
    Route::resource('audio-versions', AdminAudioVersionController::class);
    
    // Authors Resource
    Route::resource('authors', AdminAuthorController::class);
    
    // Publishing Houses Resource
    Route::resource('publishing-houses', AdminPublishingHouseController::class);
    
    // Categories Resource
    Route::resource('categories', AdminCategoryController::class);
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
    // Route::get('/books/create/{id}', [booksController::class, 'create'])->name('books.create');
    // Route::post('/books/{id}', [booksController::class, 'store'])->name('books.store');
    Route::get('/my-published-books', [booksController::class, 'indexPublishedBooks'])->name('books.publisher.index');


// Publisher Routes Group
Route::prefix('publisher')->name('publisher.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Books Resource
    Route::resource('books', BookController::class);
    
    // Audio Versions Resource
    Route::resource('audio-versions', AudioVersionController::class);
    Route::get('books/{book}/audio-versions', [AudioVersionController::class, 'indexAudioOfSingleBook'])->name('audio-versions.indexAudioOfSingleBook');
    
    // Authors Resource
    Route::resource('authors', AuthorController::class);
    
    // Publishing Houses Resource
    Route::resource('publishing-houses', PublishingHouseController::class);
    
    // Categories Resource
    Route::resource('categories', PublisherCategoryController::class);
});

});



// Home route that redirects based on role
// Route::get('/', function () {
//     if (auth()->check()) {
//         return auth()->user()->role === 'Publisher' 
//             ? redirect()->route('publisher.dashboard')
//             : (auth()->user()->role === 'Reader' ?
//               redirect()->route('books.reader.index')
//               : redirect()->route('admin.dashboard'));
//     }
//     return redirect()->route('login');
// });
// =============================
// ✅ Reader Routes appear for login and non login users
// =============================
Route::middleware(['auth', 'role:Reader'])->group(function () {
    Route::get('/readed-books', [booksController::class, 'indexReadedBooks'])->name('books.reader.index');
});

require __DIR__.'/auth.php';
