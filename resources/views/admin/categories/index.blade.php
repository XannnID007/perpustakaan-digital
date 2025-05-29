@extends('layouts.app')

@section('title', 'Kelola Kategori')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="text-white">📂 Daftar Kategori</h2>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">➕ Tambah Kategori</a>
        </div>

        <div class="table-responsive card p-4">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr class="table-dark">
                        <th>Nama</th>
                        <th>Jumlah Buku</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $cat)
                        <tr>
                            <td>{{ $cat->name }}</td>
                            <td>{{ $cat->books_count }}</td>
                            <td>
                                <a href="{{ route('admin.categories.edit', $cat) }}" class="btn btn-sm btn-warning">✏️
                                    Edit</a>
                                <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Yakin hapus kategori ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">🗑️ Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">Belum ada kategori.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $categories->links() }}</div>
    </div>
@endsection
