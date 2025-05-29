<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\ReadingHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        $user = Auth::user();

        $stats = [
            'total_bookmarks' => $user->bookmarks()->count(),
            'total_reading_history' => $user->readingHistories()->count(),
            'total_reading_time' => $user->readingHistories()->sum('total_reading_time'),
            'categories_read' => $user->readingHistories()
                ->join('books', 'reading_histories.book_id', '=', 'books.id')
                ->distinct('books.category_id')
                ->count()
        ];

        $bookmarks = $user->bookmarks()
            ->with('book.category')
            ->orderBy('updated_at', 'desc')
            ->limit(6)
            ->get();

        $recentReading = $user->readingHistories()
            ->with('book.category')
            ->orderBy('last_read_at', 'desc')
            ->limit(6)
            ->get();

        return view('user.dashboard', compact('stats', 'bookmarks', 'recentReading'));
    }

    public function bookmarks()
    {
        $bookmarks = Auth::user()->bookmarks()
            ->with('book.category')
            ->orderBy('updated_at', 'desc')
            ->paginate(12);

        return view('user.bookmarks', compact('bookmarks'));
    }

    public function readingHistory()
    {
        $histories = Auth::user()->readingHistories()
            ->with('book.category')
            ->orderBy('last_read_at', 'desc')
            ->paginate(12);

        return view('user.reading-history', compact('histories'));
    }
}
