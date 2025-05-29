@extends('layouts.app')

@section('title', 'Baca Buku')

@section('content')
    <div class="container py-5">
        <h2 class="text-white mb-3">📖 {{ $book->title }} oleh {{ $book->author }}</h2>
        <div class="ratio ratio-16x9 bg-white rounded shadow overflow-hidden">
            <iframe src="{{ asset('storage/' . $book->pdf_file) }}#page={{ $page }}" width="100%"
                height="100%"></iframe>
        </div>
        <div class="text-end mt-3">
            <a href="{{ route('books.show', $book->slug) }}" class="btn btn-secondary">⬅ Kembali ke Detail Buku</a>
        </div>
    </div>
@endsection
