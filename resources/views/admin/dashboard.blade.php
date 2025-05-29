@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="container-fluid py-5">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="text-white fw-bold">
                        <i class="fas fa-tachometer-alt me-2"></i>Admin Dashboard
                    </h1>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.books.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle me-1"></i>Tambah Buku
                        </a>
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-success">
                            <i class="fas fa-folder-plus me-1"></i>Tambah Kategori
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik Cards -->
        <div class="row g-4 mb-5">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-gradient-primary text-white shadow-lg h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase mb-1 text-white-50">Total Pengguna</h6>
                                <h2 class="mb-0 display-4 fw-bold">{{ $stats['total_users'] }}</h2>
                                <div class="text-end mt-3">
                                    <a href="{{ route('admin.books.index') }}" class="btn btn-outline-info">
                                        Lihat Semua Buku
                                    </a>
                                </div>
                            </div>
                            <div class="icon-circle bg-white bg-opacity-25">
                                <i class="fas fa-users fa-2x text-white"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('admin.users.index') }}" class="text-white text-decoration-none small">
                                <span class="fw-bold">Lihat Detail</span>
                                <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card bg-gradient-success text-white shadow-lg h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase mb-1 text-white-50">Total Buku</h6>
                                <h2 class="mb-0 display-4 fw-bold">{{ $stats['total_books'] }}</h2>
                            </div>
                            <div class="icon-circle bg-white bg-opacity-25">
                                <i class="fas fa-book fa-2x text-white"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('admin.books.index') }}" class="text-white text-decoration-none small">
                                <span class="fw-bold">Lihat Detail</span>
                                <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card bg-gradient-info text-white shadow-lg h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase mb-1 text-white-50">Total Kategori</h6>
                                <h2 class="mb-0 display-4 fw-bold">{{ $stats['total_categories'] }}</h2>
                            </div>
                            <div class="icon-circle bg-white bg-opacity-25">
                                <i class="fas fa-folder fa-2x text-white"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('admin.categories.index') }}" class="text-white text-decoration-none small">
                                <span class="fw-bold">Lihat Detail</span>
                                <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card bg-gradient-warning text-white shadow-lg h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase mb-1 text-white-50">Total Bacaan</h6>
                                <h2 class="mb-0 display-4 fw-bold">{{ $stats['total_readings'] }}</h2>
                            </div>
                            <div class="icon-circle bg-white bg-opacity-25">
                                <i class="fas fa-book-reader fa-2x text-white"></i>
                            </div>
                        </div>
                        <div class="mt-3 text-white">
                            <span class="fw-bold">Rata-rata per pengguna: </span>
                            <span>{{ $stats['total_users'] > 0 ? round($stats['total_readings'] / $stats['total_users'], 1) : 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Pengguna Baru -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-user-plus me-2"></i>Pengguna Baru
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Bergabung</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($recentUsers as $user)
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->created_at->diffForHumans() }}</td>
                                            <td>
                                                <a href="{{ route('admin.users.show', $user) }}"
                                                    class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Belum ada pengguna baru</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="text-end mt-3">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary">
                                Lihat Semua Pengguna
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistik Bacaan -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-chart-line me-2"></i>Statistik Bacaan (7 Hari Terakhir)
                        </h5>
                    </div>
                    <div class="card-body">
                        <canvas id="readingChart" width="100%" height="220"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Buku Terpopuler -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-fire me-2"></i>Buku Terpopuler
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($popularBooks as $book)
                                <div class="col-md-4 col-lg-3 mb-4">
                                    <div class="card shadow-sm h-100">
                                        <div class="position-relative">
                                            @if ($book->cover_image)
                                                <img src="{{ asset('storage/' . $book->cover_image) }}"
                                                    class="card-img-top" alt="{{ $book->title }}"
                                                    style="height: 180px; object-fit: cover;">
                                            @else
                                                <div class="bg-light d-flex align-items-center justify-content-center"
                                                    style="height: 180px;">
                                                    <i class="fas fa-book fa-3x text-secondary"></i>
                                                </div>
                                            @endif
                                            <div class="position-absolute top-0 end-0 m-2">
                                                <span class="badge bg-primary rounded-pill">
                                                    <i class="fas fa-eye me-1"></i>{{ $book->views }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <h6 class="card-title text-truncate">{{ $book->title }}</h6>
                                            <p class="card-text small text-muted mb-0">{{ $book->author }}</p>
                                            <div class="d-flex justify-content-between align-items-center mt-2">
                                                <span class="badge"
                                                    style="background-color: {{ $book->category->color }};">
                                                    {{ $book->category->name }}
                                                </span>
                                                <div>
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i
                                                            class="fas fa-star {{ $i <= $book->rating ? 'text-warning' : 'text-muted' }} small"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-white">
                                            <a href="{{ route('admin.books.show', $book) }}"
                                                class="btn btn-sm btn-outline-primary w-100">
                                                Detail
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
