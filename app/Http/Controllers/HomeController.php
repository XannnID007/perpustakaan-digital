<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Services\KMeansService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    protected $kmeansService;

    public function __construct(KMeansService $kmeansService)
    {
        $this->kmeansService = $kmeansService;
    }

    public function index()
    {
        $categories = Category::withCount('books')->get();
        $featuredBooks = Book::where('is_featured', true)
            ->with('category')
            ->orderBy('rating', 'desc')
            ->limit(6)
            ->get();

        $popularBooks = Book::orderBy('views', 'desc')
            ->with('category')
            ->limit(8)
            ->get();

        $recommendations = [];
        if (Auth::check()) {
            $recommendations = $this->kmeansService->getRecommendations(Auth::user(), 6);
        }

        return view('home', compact('categories', 'featuredBooks', 'popularBooks', 'recommendations'));
    }

    public function categoryPreferences()
    {
        $categories = Category::all();
        return view('category-preferences', compact('categories'));
    }

    public function savePreferences(Request $request)
    {
        $request->validate([
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id'
        ]);

        if (Auth::check()) {
            $user = Auth::user();

            // Clear existing preferences
            $user->preferences()->delete();

            // Save new preferences
            foreach ($request->categories as $categoryId) {
                $user->preferences()->create([
                    'category_id' => $categoryId,
                    'preference_score' => 5 // Initial high score
                ]);
            }

            return redirect()->route('home')->with('success', 'Preferensi Anda telah disimpan!');
        }

        // Store in session for guests
        session(['guest_preferences' => $request->categories]);
        return redirect()->route('books.by-categories', ['categories' => implode(',', $request->categories)]);
    }
}
