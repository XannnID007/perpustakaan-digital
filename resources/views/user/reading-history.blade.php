@extends('layouts.app')

@section('title', 'Riwayat Bacaan')

@section('content')
    <div class="container py-5">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h2 class="text-white fw-bold">
                <i class="fas fa-history me-2"></i>Riwayat Bacaan Saya
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

        @if ($histories->isEmpty())
            <div class="card shadow-lg border-0 rounded-lg overflow-hidden">
                <div class="card-body p-5 text-center">
                    <div class="empty-state">
                        <div class="empty-state-icon mb-4">
                            <i class="fas fa-book-reader text-muted"></i>
                        </div>
                        <h4>Belum Ada Riwayat Bacaan</h4>
                        <p class="text-muted mb-4">
                            Anda belum membaca buku apapun. Mulai baca sekarang untuk melihat riwayat bacaan Anda di sini.
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
                                        placeholder="Cari riwayat bacaan..." value="{{ request('search') }}">
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
                                    <a href="{{ route('user.reading-history') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-1"></i>Reset
                                    </a>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reading Analytics -->
            <div class="card shadow-lg border-0 rounded-lg overflow-hidden mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-line me-2"></i>Analisis Bacaan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-3">
                            <div class="text-center">
                                <h6 class="text-muted mb-1">Total Waktu Baca</h6>
                                <h3 class="display-6 fw-bold">
                                    {{ $histories->sum('total_reading_time') }} <small class="fs-6">menit</small>
                                </h3>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h6 class="text-muted mb-1">Buku Dibaca</h6>
                                <h3 class="display-6 fw-bold">
                                    {{ $histories->count() }}
                                </h3>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h6 class="text-muted mb-1">Rata-rata/Buku</h6>
                                <h3 class="display-6 fw-bold">
                                    {{ $histories->count() > 0 ? round($histories->sum('total_reading_time') / $histories->count(), 1) : 0 }}
                                    <small class="fs-6">menit</small>
                                </h3>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h6 class="text-muted mb-1">Dibaca Terakhir</h6>
                                <h3 class="display-6 fw-bold">
                                    {{ $histories->max('last_read_at') ? $histories->sortByDesc('last_read_at')->first()->last_read_at->diffForHumans() : '-' }}
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                @foreach ($histories as $history)
                    <div class="col-lg-6">
                        <div class="card h-100 shadow-lg border-0 history-card">
                            <div class="row g-0">
                                <div class="col-4">
                                    @if ($history->book->cover_image)
                                        <img src="{{ asset('storage/' . $history->book->cover_image) }}"
                                            class="img-fluid rounded-start h-100" alt="{{ $history->book->title }}"
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
                                                style="background-color: {{ $history->book->category->color }};">
                                                {{ $history->book->category->name }}
                                            </span>
                                            <span class="badge bg-success">
                                                <i class="fas fa-clock me-1"></i>{{ $history->total_reading_time }} menit
                                            </span>
                                        </div>

                                        <h5 class="card-title fw-bold">{{ Str::limit($history->book->title, 40) }}</h5>
                                        <p class="card-text text-muted small mb-1">{{ $history->book->author }}</p>
                                        <p class="card-text small mb-1">
                                            <i class="fas fa-calendar-alt text-muted me-1"></i>
                                            <span>Terakhir dibaca:
                                                {{ $history->last_read_at->format('d M Y, H:i') }}</span>
                                        </p>
                                        <p class="card-text small mb-3">
                                            <i class="fas fa-hourglass-half text-muted me-1"></i>
                                            <span>{{ $history->last_read_at->diffForHumans() }}</span>
                                        </p>

                                        <div class="reading-progress mb-3">
                                            <div class="d-flex justify-content-between align-items-center small mb-1">
                                                <span>Progres Baca</span>
                                                <span>{{ $history->last_page }} / {{ $history->book->pages }}</span>
                                            </div>
                                            <div class="progress" style="height: 5px;">
                                                <div class="progress-bar bg-success" role="progressbar"
                                                    style="width: {{ ($history->last_page / $history->book->pages) * 100 }}%">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-auto d-flex gap-2">
                                            <a href="{{ route('books.read', ['slug' => $history->book->slug, 'page' => $history->last_page]) }}"
                                                class="btn btn-sm btn-primary flex-grow-1">
                                                <i class="fas fa-book-reader me-1"></i>Lanjutkan
                                            </a>
                                            <a href="{{ route('books.show', $history->book->slug) }}"
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
                {{ $histories->links() }}
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

        .history-card {
            transition: all 0.3s ease;
        }

        .history-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1) !important;
        }
    </style>
@endsection
