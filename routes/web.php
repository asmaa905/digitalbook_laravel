<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\booksController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Publisher\SubscriptionController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\CategoryController;
//========================
// reader controllers
//========================
use App\Http\Controllers\Reader\ReviewController;

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
use App\Http\Controllers\Admin\PlanController;
//=================================
// Admin Auth
//==================================
use App\Http\Controllers\Auth\AdminAuthController;
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

// Admin Login & Logout

Route::get('admin/register', [AdminAuthController::class, 'showRegistrationForm'])->name('admin.register.create');
Route::post('admin/register', [AdminAuthController::class, 'register'])->name('admin.register');

Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login.create');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

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
    // Users Resources
    Route::resource('users', \App\Http\Controllers\Admin\UsersController::class)
    ->names([
        'index' => 'users.index',
        'create' => 'users.create',
        'store' => 'users.store',
        'show' => 'users.show',
        'edit' => 'users.edit',
        'update' => 'users.update',
        'destroy' => 'users.destroy',
    ]);

    //plans and subscribtions and payments routes
    //plans
    Route::resource('plans', PlanController::class);
    Route::get('/subscriptions', [AdminDashboardController::class, 'subscriptions'])->name('subscriptions.index');
    Route::get('/payments', [AdminDashboardController::class, 'payments'])->name('payments.index');
});
// =============================
// ✅ Publisher Routes appear for login and non login users
// =============================
Route::middleware(['auth', 'role:Publisher'])->group(function () {
    //published books
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
        
        // Publisher subscription routes
        Route::prefix('subscriptions')->group(function() {
            Route::get('/plans', [SubscriptionController::class, 'plans'])->name('subscriptions.plans');
            Route::get('/', [SubscriptionController::class, 'index'])->name('subscriptions.index');
            Route::get('/payments', [SubscriptionController::class, 'payments'])->name('subscriptions.payments');
            Route::get('/payments/{payment}', [SubscriptionController::class, 'payment_show'])->name('subscriptions.payments.show');
            // Route::get('/payments/{payment}/download', [SubscriptionController::class, 'downloadPaymentDetails'])->name('payments.download');
            Route::get('/{subscription}', [SubscriptionController::class, 'show'])->name('subscriptions.show');           
            // Subscription routes
            Route::post('/subscribe/{plan}', [SubscriptionController::class, 'subscribe'])->name('subscriptions.subscribe');
            Route::post('/renew/{plan}', [SubscriptionController::class, 'renew'])->name('subscriptions.renew');
            
            // Payment callback routes
            Route::get('/payment/callback', [SubscriptionController::class, 'paymentCallback'])->name('subscriptions.payment.callback');
            Route::get('/payment/error', [SubscriptionController::class, 'paymentError'])->name('subscriptions.payment.error');
        });
    });

});

// =============================
// ✅ Reader Routes appear for login and non login users
// =============================
Route::middleware(['auth', 'role:Reader'])->group(function () {
    Route::get('/readed-books', [booksController::class, 'indexReadedBooks'])->name('books.reader.index');

    Route::post('/reviews', [ReviewController::class, 'store'])->name('user.review.store');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('user.review.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('user.review.destroy');

    Route::post('/books/{book}/mark-as-read', [BooksController::class, 'markAsRead'])->name('books.reader.markAsRead');

});

require __DIR__.'/auth.php';
