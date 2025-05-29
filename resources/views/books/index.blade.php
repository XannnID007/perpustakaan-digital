@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-white">📚 Semua Buku</h1>
            <form method="GET" class="d-flex" style="gap: 10px;">
                <input name="search" type="text" class="form-control search-box" placeholder="Cari judul atau penulis..."
                    value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">🔍 Cari</button>
            </form>
        </div>

        <div class="row g-4">
            @forelse ($books as $book)
                <div class="col-6 col-md-4 col-lg-2">
                    @include('components.book-card', ['book' => $book])
                </div>
            @empty
                <p class="text-light">Tidak ada buku ditemukan.</p>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $books->links() }}
        </div>
    </div>
@endsection
