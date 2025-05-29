@extends('layouts.admin')

@section('title', 'Tambah Buku')

@section('content')
    <div class="container py-5">
        <h2 class="text-white mb-4">➕ Tambah Buku Baru</h2>
        <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data" class="card p-4">
            @csrf
            <div class="mb-3">
                <label class="form-label">Judul</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Penulis</label>
                <input type="text" name="author" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control" rows="4" required></textarea>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Kategori</label>
                    <select name="category_id" class="form-select" required>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tahun Terbit</label>
                    <input type="number" name="published_year" class="form-control" min="1900"
                        max="{{ date('Y') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Jumlah Halaman</label>
                    <input type="number" name="pages" class="form-control" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">ISBN</label>
                <input type="text" name="isbn" class="form-control">
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Gambar Sampul</label>
                    <input type="file" name="cover_image" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">File PDF</label>
                    <input type="file" name="pdf_file" class="form-control" required>
                </div>
            </div>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured">
                <label class="form-check-label" for="is_featured">Tandai sebagai unggulan</label>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
@endsection
