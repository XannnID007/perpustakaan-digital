@extends('layouts.app')

@section('title', 'Bookmark Saya')

@section('content')
    <div class="container py-5">
        <h2 class="text-white mb-4">📌 Bookmark Saya</h2>
        <div class="row g-4">
            @forelse ($bookmarks as $bookmark)
                <div class="col-6 col-md-4 col-lg-2">
                    @include('components.book-card', ['book' => $bookmark->book])
                </div>
            @empty
                <p class="text-light">Belum ada buku yang dibookmark.</p>
            @endforelse
        </div>
        <div class="mt-4">{{ $bookmarks->links() }}</div>
    </div>
@endsection
