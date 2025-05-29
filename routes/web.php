<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home Route
Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth Routes (Login, Register, Password Reset, etc.)
Auth::routes();

// User Routes (Authentication Required)
Route::middleware(['auth'])->prefix('user')->group(function () {
    // User Dashboard
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');

    // User Bookmarks
    Route::get('/bookmarks', [UserController::class, 'bookmarks'])->name('user.bookmarks');

    // User Reading History
    Route::get('/reading-history', [UserController::class, 'readingHistory'])->name('user.reading-history');
});

// Book Bookmark Toggle
Route::middleware(['auth'])->post('/books/{book}/bookmark', [BookController::class, 'bookmark'])->name('user.bookmark.toggle');

// Admin Routes (Authentication & Admin Role Required)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin Books Management
    Route::resource('books', AdminBookController::class);

    // Admin Categories Management
    Route::resource('categories', AdminCategoryController::class);

    // Admin Users Management
    Route::resource('users', AdminUserController::class)->only(['index', 'show']);
    Route::post('users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggle-status');
});

// Public Book Routes
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/{slug}', [BookController::class, 'show'])->name('books.show');
Route::get('/books/{slug}/read', [BookController::class, 'read'])->name('books.read');
Route::get('/books/categories/{categories}', [BookController::class, 'byCategories'])->name('books.by-categories');

// Category Preferences
Route::get('/preferences', [HomeController::class, 'categoryPreferences'])->name('category.preferences');
Route::post('/preferences', [HomeController::class, 'savePreferences'])->name('save.preferences');

// Handle any /home redirects to the proper dashboard
Route::get('/home', function () {
    if (auth()->check()) {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard');
    }
    return redirect()->route('home');
});
