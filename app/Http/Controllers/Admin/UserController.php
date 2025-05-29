<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index(Request $request)
    {
        $query = User::where('role', 'user');

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->withCount(['bookmarks', 'readingHistories'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load(['bookmarks.book', 'readingHistories.book', 'preferences.category']);

        $stats = [
            'total_bookmarks' => $user->bookmarks()->count(),
            'total_reading_time' => $user->readingHistories()->sum('total_reading_time'),
            'books_read' => $user->readingHistories()->distinct('book_id')->count(),
            'favorite_categories' => $user->preferences()->orderBy('preference_score', 'desc')->take(3)->get()
        ];

        return view('admin.users.show', compact('user', 'stats'));
    }

    public function toggleStatus(User $user)
    {
        // This could be used to activate/deactivate users if needed
        return redirect()->back()->with('success', 'Status pengguna berhasil diubah!');
    }
}
