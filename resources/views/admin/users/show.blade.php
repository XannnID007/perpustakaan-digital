@extends('layouts.admin')

@section('title', 'Detail Pengguna')

@section('content')
    <div class="container py-5">
        <h2 class="text-white mb-4">👤 Detail Pengguna</h2>
        <div class="card p-4 mb-4">
            <h5 class="fw-bold mb-2">{{ $user->name }}</h5>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Role:</strong> {{ $user->role }}</p>
            <p><strong>Total Bookmark:</strong> {{ $stats['total_bookmarks'] }}</p>
            <p><strong>Total Waktu Membaca:</strong> {{ $stats['total_reading_time'] }} menit</p>
            <p><strong>Jumlah Buku Dibaca:</strong> {{ $stats['books_read'] }}</p>
        </div>

        <h4 class="text-white">📌 Bookmark</h4>
        <div class="row g-3 mb-4">
            @foreach ($user->bookmarks as $b)
                <div class="col-md-2">
                    @include('components.book-card', ['book' => $b->book])
                </div>
            @endforeach
        </div>

        <h4 class="text-white">📚 Riwayat Bacaan</h4>
        <div class="row g-3 mb-4">
            @foreach ($user->readingHistories as $h)
                <div class="col-md-2">
                    @include('components.book-card', ['book' => $h->book])
                </div>
            @endforeach
        </div>

        <h4 class="text-white">❤️ Kategori Favorit</h4>
        <ul class="list-group">
            @foreach ($stats['favorite_categories'] as $pref)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $pref->category->name }}
                    <span class="badge bg-primary">Skor: {{ $pref->preference_score }}</span>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
