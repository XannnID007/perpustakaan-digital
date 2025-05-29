@extends('layouts.app')

@section('title', 'Dashboard Pengguna')

@section('content')
    <div class="container py-5">
        <div class="d-flex align-items-center justify-content-between mb-5">
            <h1 class="text-white fw-bold">
                <i class="fas fa-columns me-2"></i>Dashboard Saya
            </h1>
            <div class="d-flex gap-2">
                <a href="{{ route('books.index') }}" class="btn btn-primary">
                    <i class="fas fa-book me-1"></i>Jelajahi Buku
                </a>
                <a href="{{ route('category.preferences') }}" class="btn btn-outline-light">
                    <i class="fas fa-cog me-1"></i>Preferensi
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-5">
            <div class="col-lg-3 col-md-6">
                <div class="card bg-gradient h-100 shadow-lg card-stats">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-8">
                                <h6 class="text-uppercase text-muted mb-1">Bookmark</h6>
                                <h2 class="display-4 fw-bold mb-0">{{ $stats['total_bookmarks'] }}</h2>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon-shape bg-primary text-white">
                                    <i class="fas fa-bookmark"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mt-3 mb-0 text-muted">
                            <a href="{{ route('user.bookmarks') }}" class="text-decoration-none">
                                <span class="text-success me-1">Lihat semua</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card bg-gradient h-100 shadow-lg card-stats">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-8">
                                <h6 class="text-uppercase text-muted mb-1">Buku Dibaca</h6>
                                <h2 class="display-4 fw-bold mb-0">{{ $stats['total_reading_history'] }}</h2>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon-shape bg-success text-white">
                                    <i class="fas fa-book-reader"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mt-3 mb-0 text-muted">
                            <a href="{{ route('user.reading-history') }}" class="text-decoration-none">
                                <span class="text-success me-1">Lihat riwayat</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card bg-gradient h-100 shadow-lg card-stats">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-8">
                                <h6 class="text-uppercase text-muted mb-1">Waktu Baca</h6>
                                <h2 class="display-4 fw-bold mb-0">{{ $stats['total_reading_time'] }}</h2>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon-shape bg-warning text-white">
                                    <i class="fas fa-clock"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mt-3 mb-0 text-muted">
                            <span class="text-primary me-1">
                                <i class="fas fa-info-circle me-1"></i>Total menit
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card bg-gradient h-100 shadow-lg card-stats">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-8">
                                <h6 class="text-uppercase text-muted mb-1">Kategori</h6>
                                <h2 class="display-4 fw-bold mb-0">{{ $stats['categories_read'] }}</h2>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon-shape bg-info text-white">
                                    <i class="fas fa-th-large"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mt-3 mb-0 text-muted">
                            <a href="{{ route('category.preferences') }}" class="text-decoration-none">
                                <span class="text-success me-1">Ubah preferensi</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recommended Books Section -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card bg-white shadow-lg border-0 rounded-lg overflow-hidden">
                    <div class="card-header bg-primary text-white d-flex align-items-center">
                        <i class="fas fa-magic me-2"></i>
                        <h5 class="mb-0">Rekomendasi Untuk Anda</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            @if (isset($recommendations) && count($recommendations) > 0)
                                @foreach ($recommendations as $book)
                                    <div class="col-md-4 col-lg-3">
                                        <div class="card h-100 shadow-sm book-card">
                                            @if ($book->cover_image)
                                                <img src="{{ asset('storage/' . $book->cover_image) }}" class="card-img-top"
                                                    alt="{{ $book->title }}" style="height: 200px; object-fit: cover;">
                                            @else
                                                <div class="bg-light d-flex align-items-center justify-content-center"
                                                    style="height: 200px;">
                                                    <i class="fas fa-book fa-3x text-secondary"></i>
                                                </div>
                                            @endif
                                            <div class="card-body d-flex flex-column">
                                                <h6 class="card-title fw-bold mb-1">{{ Str::limit($book->title, 40) }}</h6>
                                                <p class="card-text small text-muted mb-2">{{ $book->author }}</p>
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <span class="badge"
                                                        style="background-color: {{ $book->category->color }};">
                                                        {{ $book->category->name }}
                                                    </span>
                                                    <div>
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <i
                                                                class="fas fa-star {{ $i <= $book->rating ? 'text-warning' : 'text-muted' }} small"></i>
                                                        @endfor
                                                    </div>
                                                </div>
                                                <div class="mt-auto">
                                                    <a href="{{ route('books.show', $book->slug) }}"
                                                        class="btn btn-sm btn-primary w-100">
                                                        <i class="fas fa-book-open me-1"></i>Baca
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-12 text-center py-5">
                                    <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                                    <h5>Belum ada rekomendasi untuk Anda</h5>
                                    <p class="text-muted">Mulai membaca buku untuk mendapatkan rekomendasi yang
                                        dipersonalisasi</p>
                                    <a href="{{ route('books.index') }}" class="btn btn-primary mt-2">
                                        Jelajahi Buku
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bookmarks and Recent Reading -->
        <div class="row">
            <!-- Bookmarks Section -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow-lg border-0 rounded-lg overflow-hidden h-100">
                    <div class="card-header bg-info text-white d-flex align-items-center justify-content-between">
                        <div>
                            <i class="fas fa-bookmark me-2"></i>
                            <h5 class="mb-0 d-inline">Bookmark Terbaru</h5>
                        </div>
                        <a href="{{ route('user.bookmarks') }}" class="btn btn-sm btn-light">
                            Lihat Semua
                        </a>
                    </div>
                    <div class="card-body p-0">
                        @if (count($bookmarks) > 0)
                            <div class="list-group list-group-flush">
                                @foreach ($bookmarks as $bookmark)
                                    <a href="{{ route('books.show', $bookmark->book->slug) }}"
                                        class="list-group-item list-group-item-action d-flex align-items-center p-3">
                                        <div class="flex-shrink-0 me-3">
                                            @if ($bookmark->book->cover_image)
                                                <img src="{{ asset('storage/' . $bookmark->book->cover_image) }}"
                                                    class="rounded" alt="{{ $bookmark->book->title }}" width="50"
                                                    height="60" style="object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                    style="width: 50px; height: 60px;">
                                                    <i class="fas fa-book text-secondary"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ Str::limit($bookmark->book->title, 30) }}</h6>
                                            <p class="small text-muted mb-0">{{ $bookmark->book->author }}</p>
                                            <div class="d-flex align-items-center">
                                                <span class="badge bg-secondary me-2">Halaman:
                                                    {{ $bookmark->last_page }}</span>
                                                <span class="badge"
                                                    style="background-color: {{ $bookmark->book->category->color }};">
                                                    {{ $bookmark->book->category->name }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ms-auto">
                                            <i class="fas fa-arrow-right text-muted"></i>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-bookmark fa-3x text-muted mb-3"></i>
                                <h5>Belum ada bookmark</h5>
                                <p class="text-muted">Tandai buku favorit Anda untuk dibaca nanti</p>
                                <a href="{{ route('books.index') }}" class="btn btn-info mt-2">
                                    Jelajahi Buku
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Recent Reading Section -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow-lg border-0 rounded-lg overflow-hidden h-100">
                    <div class="card-header bg-success text-white d-flex align-items-center justify-content-between">
                        <div>
                            <i class="fas fa-history me-2"></i>
                            <h5 class="mb-0 d-inline">Bacaan Terakhir</h5>
                        </div>
                        <a href="{{ route('user.reading-history') }}" class="btn btn-sm btn-light">
                            Lihat Semua
                        </a>
                    </div>
                    <div class="card-body p-0">
                        @if (count($recentReading) > 0)
                            <div class="list-group list-group-flush">
                                @foreach ($recentReading as $history)
                                    <a href="{{ route('books.read', ['slug' => $history->book->slug, 'page' => $history->last_page]) }}"
                                        class="list-group-item list-group-item-action d-flex align-items-center p-3">
                                        <div class="flex-shrink-0 me-3">
                                            @if ($history->book->cover_image)
                                                <img src="{{ asset('storage/' . $history->book->cover_image) }}"
                                                    class="rounded" alt="{{ $history->book->title }}" width="50"
                                                    height="60" style="object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                    style="width: 50px; height: 60px;">
                                                    <i class="fas fa-book text-secondary"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ Str::limit($history->book->title, 30) }}</h6>
                                            <p class="small text-muted mb-0">{{ $history->book->author }}</p>
                                            <div class="d-flex align-items-center">
                                                <span class="badge bg-secondary me-2">Halaman:
                                                    {{ $history->last_page }}</span>
                                                <span class="badge bg-primary me-2">
                                                    <i class="fas fa-clock me-1"></i>{{ $history->total_reading_time }}
                                                    menit
                                                </span>
                                                <small
                                                    class="text-muted">{{ $history->last_read_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                        <div class="ms-auto">
                                            <button class="btn btn-sm btn-success">
                                                <i class="fas fa-book-reader"></i>
                                            </button>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-history fa-3x text-muted mb-3"></i>
                                <h5>Belum ada riwayat bacaan</h5>
                                <p class="text-muted">Mulai membaca buku untuk melihat riwayat Anda di sini</p>
                                <a href="{{ route('books.index') }}" class="btn btn-success mt-2">
                                    Mulai Membaca
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card-stats {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-stats:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2) !important;
        }

        .bg-gradient {
            background: linear-gradient(45deg, #ffffff, #f8f9fa);
        }

        .icon-shape {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 3rem;
            height: 3rem;
            border-radius: 50%;
        }

        .book-card {
            transition: all 0.3s ease;
        }

        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
        }
    </style>
@endsection
