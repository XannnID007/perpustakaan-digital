<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Book;
use App\Models\Bookmark;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ReadingHistory;
use App\Services\KMeansService;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    protected $kmeansService;

    public function __construct(KMeansService $kmeansService)
    {
        $this->kmeansService = $kmeansService;
    }

    public function index(Request $request)
    {
        $query = Book::with('category');

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('author', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        $books = $query->orderBy('rating', 'desc')
            ->orderBy('views', 'desc')
            ->paginate(12);

        $categories = Category::withCount('books')->get();

        return view('books.index', compact('books', 'categories'));
    }

    public function show($slug)
    {
        $book = Book::where('slug', $slug)->with('category')->firstOrFail();

        // Increment views
        $book->incrementViews();

        // Update user preferences if logged in
        if (Auth::check()) {
            $this->kmeansService->updateUserPreferences(Auth::user(), $book, 'view');
        }

        // Get related books
        $relatedBooks = Book::where('category_id', $book->category_id)
            ->where('id', '!=', $book->id)
            ->orderBy('rating', 'desc')
            ->limit(4)
            ->get();

        $isBookmarked = false;
        $lastPage = 1;

        if (Auth::check()) {
            $bookmark = Bookmark::where('user_id', Auth::id())
                ->where('book_id', $book->id)
                ->first();

            $isBookmarked = !is_null($bookmark);
            if ($bookmark) {
                $lastPage = $bookmark->last_page;
            }
        }

        return view('books.show', compact('book', 'relatedBooks', 'isBookmarked', 'lastPage'));
    }

    public function read($slug, Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('info', 'Silakan login terlebih dahulu untuk membaca buku.');
        }

        $book = Book::where('slug', $slug)->firstOrFail();
        $user = Auth::user();
        $page = $request->get('page', 1);

        // Update reading history
        ReadingHistory::updateOrCreate(
            [
                'user_id' => $user->id,
                'book_id' => $book->id,
            ],
            [
                'last_page' => $page,
                'last_read_at' => now(),
                'total_reading_time' => DB::raw('total_reading_time + 1')
            ]
        );

        // Update user preferences
        $this->kmeansService->updateUserPreferences($user, $book, 'read');

        return view('books.read', compact('book', 'page'));
    }

    public function bookmark(Book $book)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Login required']);
        }

        $user = Auth::user();
        $bookmark = Bookmark::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->first();

        if ($bookmark) {
            $bookmark->delete();
            $isBookmarked = false;
            $message = 'Buku berhasil dihapus dari bookmark';
        } else {
            Bookmark::create([
                'user_id' => $user->id,
                'book_id' => $book->id,
            ]);
            $isBookmarked = true;
            $message = 'Buku berhasil ditambahkan ke bookmark';

            // Update user preferences
            $this->kmeansService->updateUserPreferences($user, $book, 'bookmark');
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'isBookmarked' => $isBookmarked
        ]);
    }

    public function byCategories($categories)
    {
        $categoryIds = explode(',', $categories);
        $books = Book::whereIn('category_id', $categoryIds)
            ->with('category')
            ->orderBy('rating', 'desc')
            ->orderBy('views', 'desc')
            ->paginate(12);

        $selectedCategories = Category::whereIn('id', $categoryIds)->get();

        return view('books.by-categories', compact('books', 'selectedCategories'));
    }
}
