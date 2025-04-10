<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PublishHouseController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\ReviewController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    Route::resource('users', UserController::class)->except(['create', 'store']);
    Route::resource('categories', CategoryController::class);
    Route::resource('publish-houses', PublishHouseController::class);
    Route::resource('books', BookController::class);
    Route::get('reviews', [ReviewController::class, 'index'])->name('admin.reviews.index');
});