<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Book;
use App\Models\Category;
use App\Models\ReadingHistory;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'total_books' => Book::count(),
            'total_categories' => Category::count(),
            'total_readings' => ReadingHistory::count(),
        ];

        $recentUsers = User::where('role', 'user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $popularBooks = Book::orderBy('views', 'desc')
            ->with('category')
            ->limit(5)
            ->get();

        $readingStats = ReadingHistory::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'popularBooks', 'readingStats'));
    }
}
