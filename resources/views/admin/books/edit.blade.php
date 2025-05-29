@extends('layouts.app')

@section('title', 'Edit Buku')

@section('content')
    <div class="container py-5">
        <h2 class="text-white mb-4">✏️ Edit Buku: {{ $book->title }}</h2>
        <form action="{{ route('admin.books.update', $book) }}" method="POST" enctype="multipart/form-data" class="card p-4">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Judul</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $book->title) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Penulis</label>
                <input type="text" name="author" class="form-control" value="{{ old('author', $book->author) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control" rows="4" required>{{ old('description', $book->description) }}</textarea>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Kategori</label>
                    <select name="category_id" class="form-select" required>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $book->category_id == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tahun Terbit</label>
                    <input type="number" name="published_year" class="form-control" 
                           value="{{ old('published_year', $book->published_year) }}" 
                           min="1900" max="{{ date('Y') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Jumlah Halaman</label>
                    <input type="number" name="pages" class="form-control" 
                           value="{{ old('pages', $book->pages) }}" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">ISBN</label>
                <input type="text" name="isbn" class="form-control" value="{{ old('isbn', $book->isbn) }}">
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Gambar Sampul</label>
                    @if ($book->cover_image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Cover saat ini" 
                                 class="img-thumbnail" style="height: 150px;">
                            <p class="small text-muted">Cover saat ini</p>
                        </div>
                    @endif
                    <input type="file" name="cover_image" class="form-control">
                    <small class="text-muted">Biarkan kosong jika tidak ingin mengubah cover</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label">File PDF</label>
                    @if ($book->pdf_file)
                        <p class="small text-muted mb-2">
                            <a href="{{ asset('storage/' . $book->pdf_file) }}" target="_blank" class="text-decoration-none">
                                <i class="fas fa-file-pdf me-1"></i>Lihat PDF saat ini
                            </a>
                        </p>
                    @endif
                    <input type="file" name="pdf_file" class="form-control">
                    <small class="text-muted">Biarkan kosong jika tidak ingin mengubah file PDF</small>
                </div>
            </div>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" 
                       {{ $book->is_featured ? 'checked' : '' }}>
                <label class="form-check-label" for="is_featured">Tandai sebagai unggulan</label>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
                <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">❌ Batal</a>
            </div>
        </form>
    </div>
@endsection