@extends('layouts.app')

@section('title', $book->title)

@section('content')
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-md-4">
                <img src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : asset('images/default-book.png') }}"
                    alt="{{ $book->title }}" class="img-fluid rounded shadow">
            </div>
            <div class="col-md-8 text-white">
                <h2 class="fw-bold">{{ $book->title }}</h2>
                <p class="mb-1"><strong>Penulis:</strong> {{ $book->author }}</p>
                <p><strong>Kategori:</strong> <span class="badge bg-light text-dark">{{ $book->category->name }}</span></p>
                <p><strong>Tahun:</strong> {{ $book->published_year }}</p>
                <p><strong>Halaman:</strong> {{ $book->pages }}</p>
                <p class="mt-3">{{ $book->description }}</p>

                <div class="d-flex gap-3 mt-4">
                    <a href="{{ route('books.read', $book->slug) }}" class="btn btn-primary">
                        📖 Baca Sekarang
                    </a>
                    @auth
                        <form action="{{ route('user.bookmark.toggle', $book->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-light">
                                @if ($book->isBookmarkedBy(Auth::user()))
                                    💾 Hapus Bookmark
                                @else
                                    📌 Bookmark
                                @endif
                            </button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>

        <hr class="my-5">

        <h4 class="text-white mb-4">📚 Buku Terkait</h4>
        <div class="row g-4">
            @foreach ($relatedBooks as $related)
                <div class="col-6 col-md-4 col-lg-2">
                    @include('components.book-card', ['book' => $related])
                </div>
            @endforeach
        </div>
    </div>
@endsection
