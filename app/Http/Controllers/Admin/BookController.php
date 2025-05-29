<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index(Request $request)
    {
        $query = Book::with('category');

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('author', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        $books = $query->orderBy('created_at', 'desc')->paginate(15);
        $categories = Category::all();

        return view('admin.books.index', compact('books', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'published_year' => 'required|integer|min:1900|max:' . date('Y'),
            'pages' => 'required|integer|min:1',
            'isbn' => 'nullable|string|max:20',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'pdf_file' => 'required|file|mimes:pdf|max:50000',
            'is_featured' => 'boolean'
        ]);

        $book = new Book();
        $book->title = $request->title;
        $book->slug = Str::slug($request->title);
        $book->author = $request->author;
        $book->description = $request->description;
        $book->category_id = $request->category_id;
        $book->published_year = $request->published_year;
        $book->pages = $request->pages;
        $book->isbn = $request->isbn;
        $book->is_featured = $request->boolean('is_featured');

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('covers', 'public');
            $book->cover_image = $coverPath;
        }

        // Handle PDF file upload
        $pdfPath = $request->file('pdf_file')->store('books', 'public');
        $book->pdf_file = $pdfPath;

        $book->save();

        return redirect()->route('admin.books.index')
            ->with('success', 'Buku berhasil ditambahkan!');
    }

    public function show(Book $book)
    {
        return view('admin.books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        $categories = Category::all();
        return view('admin.books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'published_year' => 'required|integer|min:1900|max:' . date('Y'),
            'pages' => 'required|integer|min:1',
            'isbn' => 'nullable|string|max:20',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'pdf_file' => 'nullable|file|mimes:pdf|max:50000',
            'is_featured' => 'boolean'
        ]);

        $book->title = $request->title;
        $book->slug = Str::slug($request->title);
        $book->author = $request->author;
        $book->description = $request->description;
        $book->category_id = $request->category_id;
        $book->published_year = $request->published_year;
        $book->pages = $request->pages;
        $book->isbn = $request->isbn;
        $book->is_featured = $request->boolean('is_featured');

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            // Delete old cover
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }

            $coverPath = $request->file('cover_image')->store('covers', 'public');
            $book->cover_image = $coverPath;
        }

        // Handle PDF file upload
        if ($request->hasFile('pdf_file')) {
            // Delete old PDF
            if ($book->pdf_file) {
                Storage::disk('public')->delete($book->pdf_file);
            }

            $pdfPath = $request->file('pdf_file')->store('books', 'public');
            $book->pdf_file = $pdfPath;
        }

        $book->save();

        return redirect()->route('admin.books.index')
            ->with('success', 'Buku berhasil diperbarui!');
    }

    public function destroy(Book $book)
    {
        // Delete files
        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }
        if ($book->pdf_file) {
            Storage::disk('public')->delete($book->pdf_file);
        }

        $book->delete();

        return redirect()->route('admin.books.index')
            ->with('success', 'Buku berhasil dihapus!');
    }
}
