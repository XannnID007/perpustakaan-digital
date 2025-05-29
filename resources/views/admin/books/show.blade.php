@extends('layouts.admin')

@section('title', 'Detail Buku')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-white">📚 Detail Buku</h2>
            <div>
                <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-1"></i>Edit
                </a>
                <a href="{{ route('admin.books.index') }}" class="btn btn-secondary ms-2">
                    <i class="fas fa-arrow-left me-1"></i>Kembali
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card p-3 mb-4">
                    @if ($book->cover_image)
                        <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}"
                            class="img-fluid rounded mb-3">
                    @else
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-center p-5 mb-3"
                            style="height: 300px;">
                            <i class="fas fa-book fa-5x text-white"></i>
                        </div>
                    @endif

                    <div class="d-grid gap-2">
                        @if ($book->pdf_file)
                            <a href="{{ asset('storage/' . $book->pdf_file) }}" target="_blank" class="btn btn-primary">
                                <i class="fas fa-file-pdf me-1"></i>Lihat PDF
                            </a>
                        @endif
                        <a href="{{ route('books.show', $book->slug) }}" target="_blank" class="btn btn-info">
                            <i class="fas fa-eye me-1"></i>Lihat di Frontend
                        </a>
                    </div>
                </div>

                <div class="card p-3">
                    <h5 class="card-title">Statistik</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Jumlah View:</span>
                            <span class="badge bg-primary rounded-pill">{{ $book->views }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Rating:</span>
                            <span>
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $book->rating ? 'text-warning' : 'text-muted' }}"></i>
                                @endfor
                                ({{ number_format($book->rating, 1) }})
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Jumlah Bookmark:</span>
                            <span class="badge bg-info rounded-pill">{{ $book->bookmarks()->count() }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Riwayat Baca:</span>
                            <span class="badge bg-success rounded-pill">{{ $book->readingHistories()->count() }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card p-4">
                    <h3 class="card-title">{{ $book->title }}</h3>
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <span class="badge bg-primary">{{ $book->category->name }}</span>
                        @if ($book->is_featured)
                            <span class="badge bg-warning text-dark">
                                <i class="fas fa-star me-1"></i>Unggulan
                            </span>
                        @endif
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p><strong>Penulis:</strong> {{ $book->author }}</p>
                            <p><strong>Tahun Terbit:</strong> {{ $book->published_year }}</p>
                            <p><strong>Jumlah Halaman:</strong> {{ $book->pages }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>ISBN:</strong> {{ $book->isbn ?: 'Tidak ada' }}</p>
                            <p><strong>Slug:</strong> {{ $book->slug }}</p>
                            <p><strong>Tanggal Dibuat:</strong> {{ $book->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5>Deskripsi</h5>
                        <p>{{ $book->description }}</p>
                    </div>

                    <div>
                        <form action="{{ route('admin.books.destroy', $book) }}" method="POST"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini? Tindakan ini tidak dapat dibatalkan.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash-alt me-1"></i>Hapus Buku
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
