@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
    <div class="container py-5">
        <h2 class="text-white mb-4">➕ Tambah Kategori Buku</h2>
        <form action="{{ route('admin.categories.store') }}" method="POST" class="card p-4">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama Kategori</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Warna</label>
                <input type="color" name="color" class="form-control form-control-color" value="#667eea">
            </div>
            <div class="mb-3">
                <label class="form-label">Ikon (Font Awesome)</label>
                <input type="text" name="icon" class="form-control" value="fas fa-book">
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
@endsection
