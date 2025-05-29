<?php
// routes/web.php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/category-preferences', [HomeController::class, 'categoryPreferences'])->name('category.preferences');
Route::post('/save-preferences', [HomeController::class, 'savePreferences'])->name('save.preferences');

// Books Routes
Route::prefix('books')->name('books.')->group(function () {
    Route::get('/', [BookController::class, 'index'])->name('index');
    Route::get('/categories/{categories}', [BookController::class, 'byCategories'])->name('by-categories');
    Route::get('/{slug}', [BookController::class, 'show'])->name('show');
    Route::get('/{slug}/read', [BookController::class, 'read'])->name('read')->middleware('auth');
    Route::post('/{book}/bookmark', [BookController::class, 'bookmark'])->name('bookmark')->middleware('auth');
});

// Authentication Routes
Auth::routes();

// User Dashboard Routes (Protected)
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/bookmarks', [UserController::class, 'bookmarks'])->name('bookmarks');
    Route::get('/reading-history', [UserController::class, 'readingHistory'])->name('reading-history');
});

// Admin Routes (Protected)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Books Management
    Route::resource('books', AdminBookController::class);

    // Categories Management
    Route::resource('categories', AdminCategoryController::class)->except(['show']);

    // Users Management
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
    Route::patch('/users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggle-status');
});
