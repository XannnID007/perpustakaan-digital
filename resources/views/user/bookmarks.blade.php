@extends('layouts.app')

@section('title', 'Bookmark Saya')

@section('content')
    <div class="container py-5">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h2 class="text-white fw-bold">
                <i class="fas fa-bookmark me-2"></i>Bookmark Saya
            </h2>
            <div class="d-flex gap-2">
                <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Kembali ke Dashboard
                </a>
                <a href="{{ route('books.index') }}" class="btn btn-primary">
                    <i class="fas fa-book me-1"></i>Jelajahi Buku
                </a>
            </div>
        </div>

        @if ($bookmarks->isEmpty())
            <div class="card shadow-lg border-0 rounded-lg overflow-hidden">
                <div class="card-body p-5 text-center">
                    <div class="empty-state">
                        <div class="empty-state-icon mb-4">
                            <i class="fas fa-bookmark text-muted"></i>
                        </div>
                        <h4>Belum Ada Bookmark</h4>
                        <p class="text-muted mb-4">
                            Anda belum menambahkan buku apapun ke bookmark. Tambahkan buku favorit Anda ke bookmark untuk
                            dibaca nanti.
                        </p>
                        <a href="{{ route('books.index') }}" class="btn btn-primary">
                            <i class="fas fa-search me-1"></i>Cari Buku
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-3">
                            <form method="GET" class="d-flex gap-2">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0">
                                        <i class="fas fa-search text-muted"></i>
                                    </span>
                                    <input type="text" name="search" class="form-control border-0 shadow-none"
                                        placeholder="Cari bookmark..." value="{{ request('search') }}">
                                </div>
                                <select name="category" class="form-select border-0 shadow-none" style="max-width: 200px;">
                                    <option value="">Semua Kategori</option>
                                    @foreach (\App\Models\Category::all() as $category)
                                        <option value="{{ $category->id }}"
                                            {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-primary">Filter</button>
                                @if (request('search') || request('category'))
                                    <a href="{{ route('user.bookmarks') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-1"></i>Reset
                                    </a>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                @foreach ($bookmarks as $bookmark)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-lg border-0 bookmark-card">
                            <div class="row g-0">
                                <div class="col-4">
                                    @if ($bookmark->book->cover_image)
                                        <img src="{{ asset('storage/' . $bookmark->book->cover_image) }}"
                                            class="img-fluid rounded-start h-100" alt="{{ $bookmark->book->title }}"
                                            style="object-fit: cover;">
                                    @else
                                        <div
                                            class="bg-light d-flex align-items-center justify-content-center h-100 rounded-start">
                                            <i class="fas fa-book fa-3x text-secondary"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-8">
                                    <div class="card-body d-flex flex-column h-100">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="badge"
                                                style="background-color: {{ $bookmark->book->category->color }};">
                                                {{ $bookmark->book->category->name }}
                                            </span>
                                            <form action="{{ route('user.bookmark.toggle', $bookmark->book) }}"
                                                method="POST" onsubmit="return confirm('Hapus dari bookmark?')">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>

                                        <h5 class="card-title fw-bold">{{ Str::limit($bookmark->book->title, 40) }}</h5>
                                        <p class="card-text text-muted small mb-1">{{ $bookmark->book->author }}</p>
                                        <p class="card-text small mb-3">
                                            <i class="fas fa-star text-warning me-1"></i>
                                            <span>{{ number_format($bookmark->book->rating, 1) }} / 5.0</span>
                                            <span class="mx-2">•</span>
                                            <i class="fas fa-eye text-muted me-1"></i>
                                            <span>{{ $bookmark->book->views }}</span>
                                        </p>

                                        <div class="bookmark-progress mb-3">
                                            <div class="d-flex justify-content-between align-items-center small mb-1">
                                                <span>Progres Baca</span>
                                                <span>{{ $bookmark->last_page }} / {{ $bookmark->book->pages }}</span>
                                            </div>
                                            <div class="progress" style="height: 5px;">
                                                <div class="progress-bar bg-success" role="progressbar"
                                                    style="width: {{ ($bookmark->last_page / $bookmark->book->pages) * 100 }}%">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-auto d-flex gap-2">
                                            <a href="{{ route('books.read', ['slug' => $bookmark->book->slug, 'page' => $bookmark->last_page]) }}"
                                                class="btn btn-sm btn-primary flex-grow-1">
                                                <i class="fas fa-book-reader me-1"></i>Lanjutkan
                                            </a>
                                            <a href="{{ route('books.show', $bookmark->book->slug) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-info-circle"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $bookmarks->links() }}
            </div>
        @endif
    </div>

    <style>
        .empty-state {
            padding: 40px 20px;
        }

        .empty-state-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: #f8f9fa;
            font-size: 2.5rem;
        }

        .bookmark-card {
            transition: all 0.3s ease;
        }

        .bookmark-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1) !important;
        }
    </style>
@endsection
