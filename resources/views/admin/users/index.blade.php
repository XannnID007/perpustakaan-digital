@extends('layouts.admin')

@section('title', 'Data Pengguna')

@section('content')
    <div class="container py-5">
        <h2 class="text-white mb-4">👥 Daftar Pengguna</h2>

        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Cari nama atau email..."
                    value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <button class="btn btn-outline-light">🔍 Cari</button>
            </div>
        </form>

        <div class="table-responsive card p-4">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr class="table-dark">
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Bookmark</th>
                        <th>Riwayat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->bookmarks_count }}</td>
                            <td>{{ $user->reading_histories_count }}</td>
                            <td>
                                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-info">👁️ Lihat</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $users->links() }}</div>
    </div>
@endsection
