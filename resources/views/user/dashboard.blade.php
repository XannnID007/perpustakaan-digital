@extends('layouts.app')

@section('title', 'Dashboard Saya')

@section('content')
    <div class="container py-5">
        <h1 class="text-white mb-4">👤 Dashboard Pengguna</h1>
        <div class="row g-4">
            <div class="col-md-3">
                <div class="card p-4 text-center">
                    <h5>Total Bookmark</h5>
                    <h3 class="fw-bold">{{ $stats['total_bookmarks'] }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-4 text-center">
                    <h5>Riwayat Bacaan</h5>
                    <h3 class="fw-bold">{{ $stats['total_reading_history'] }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-4 text-center">
                    <h5>Total Waktu Baca</h5>
                    <h3 class="fw-bold">{{ $stats['total_reading_time'] }} menit</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-4 text-center">
                    <h5>Kategori Dibaca</h5>
                    <h3 class="fw-bold">{{ $stats['categories_read'] }}</h3>
                </div>
            </div>
        </div>

        <hr class="my-5">

        <h3 class="text-white mb-3">📌 Bookmark Terbaru</h3>
        <div class="row g-3">
            @forelse ($bookmarks as $bookmark)
                <div class="col-md-2">
                    @include('components.book-card', ['book' => $bookmark->book])
                </div>
            @empty
                <p class="text-light">Belum ada bookmark.</p>
            @endforelse
        </div>

        <h3 class="text-white mt-5 mb-3">⏳ Bacaan Terakhir</h3>
        <div class="row g-3">
            @forelse ($recentReading as $history)
                <div class="col-md-2">
                    @include('components.book-card', ['book' => $history->book])
                </div>
            @empty
                <p class="text-light">Belum ada riwayat baca.</p>
            @endforelse
        </div>
    </div>
@endsection
