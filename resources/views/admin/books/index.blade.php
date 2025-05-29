@extends('layouts.admin')

@section('title', 'Kelola Buku')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="text-white">📚 Daftar Buku</h2>
            <a href="{{ route('admin.books.create') }}" class="btn btn-primary">➕ Tambah Buku</a>
        </div>

        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Cari judul atau penulis..."
                    value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="category" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-outline-light">🔍 Cari</button>
            </div>
        </form>

        <div class="table-responsive card p-4">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr class="table-dark">
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Kategori</th>
                        <th>Tahun</th>
                        <th>Halaman</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($books as $book)
                        <tr>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->author }}</td>
                            <td>{{ $book->category->name }}</td>
                            <td>{{ $book->published_year }}</td>
                            <td>{{ $book->pages }}</td>
                            <td>
                                <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-sm btn-warning">✏️ Edit</a>
                                <form action="{{ route('admin.books.destroy', $book) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Yakin hapus buku ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">🗑️ Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">Tidak ada data buku</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $books->links() }}</div>
    </div>
@endsection
