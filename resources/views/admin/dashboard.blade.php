@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="container py-5">
        <h1 class="text-white mb-4">📊 Admin Dashboard</h1>
        <div class="row g-4">
            <div class="col-md-3">
                <div class="card p-4 text-center">
                    <h5>Total Pengguna</h5>
                    <h3 class="fw-bold">{{ $stats['total_users'] }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-4 text-center">
                    <h5>Total Buku</h5>
                    <h3 class="fw-bold">{{ $stats['total_books'] }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-4 text-center">
                    <h5>Total Kategori</h5>
                    <h3 class="fw-bold">{{ $stats['total_categories'] }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-4 text-center">
                    <h5>Total Bacaan</h5>
                    <h3 class="fw-bold">{{ $stats['total_readings'] }}</h3>
                </div>
            </div>
        </div>

        <h4 class="text-white mt-5">📥 Pengguna Baru</h4>
        <ul class="list-group mb-4">
            @foreach ($recentUsers as $user)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $user->name }} <span class="badge bg-primary">{{ $user->email }}</span>
                </li>
            @endforeach
        </ul>

        <h4 class="text-white">🔥 Buku Terpopuler</h4>
        <div class="row g-3">
            @foreach ($popularBooks as $book)
                <div class="col-md-2">
                    @include('components.book-card', ['book' => $book])
                </div>
            @endforeach
        </div>
    </div>
@endsection
