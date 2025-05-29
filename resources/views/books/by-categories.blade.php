@extends('layouts.app')

@section('title', 'Buku Berdasarkan Beberapa Kategori')

@section('content')
    <div class="container py-5">
        <div class="mb-5 text-center">
            <h2 class="text-white fw-bold">📂 Buku Berdasarkan Kategori</h2>
            <p class="text-light">
                Kategori:
                @foreach ($selectedCategories as $cat)
                    <span class="badge bg-light text-dark me-1">{{ $cat->name }}</span>
                @endforeach
            </p>
        </div>

        <div class="row g-4">
            @forelse ($books as $book)
                <div class="col-6 col-md-4 col-lg-2">
                    @include('components.book-card', ['book' => $book])
                </div>
            @empty
                <p class="text-light">Tidak ada buku ditemukan untuk kategori yang dipilih.</p>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $books->links() }}
        </div>
    </div>
@endsection
