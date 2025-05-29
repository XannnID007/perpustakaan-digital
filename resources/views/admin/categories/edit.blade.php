@extends('layouts.admin')

@section('title', 'Edit Kategori')

@section('content')
    <div class="container py-5">
        <h2 class="text-white mb-4">✏️ Edit Kategori: {{ $category->name }}</h2>
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="card p-4">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Nama Kategori</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control">{{ old('description', $category->description) }}</textarea>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Warna</label>
                    <div class="d-flex gap-2 align-items-center">
                        <input type="color" name="color" class="form-control form-control-color"
                            value="{{ old('color', $category->color) }}">
                        <span class="badge" style="background-color: {{ $category->color }};">Warna saat ini</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Ikon (Font Awesome)</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="{{ $category->icon }}"></i>
                        </span>
                        <input type="text" name="icon" class="form-control"
                            value="{{ old('icon', $category->icon) }}">
                    </div>
                    <small class="text-muted">Contoh: fas fa-book, fas fa-graduation-cap</small>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">❌ Batal</a>
            </div>
        </form>
    </div>
@endsection
