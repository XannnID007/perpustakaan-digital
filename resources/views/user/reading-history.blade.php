@extends('layouts.app')

@section('title', 'Riwayat Bacaan')

@section('content')
    <div class="container py-5">
        <h2 class="text-white mb-4">📚 Riwayat Bacaan Saya</h2>
        <div class="row g-4">
            @forelse ($histories as $history)
                <div class="col-6 col-md-4 col-lg-2">
                    @include('components.book-card', ['book' => $history->book])
                </div>
            @empty
                <p class="text-light">Belum ada riwayat baca.</p>
            @endforelse
        </div>
        <div class="mt-4">{{ $histories->links() }}</div>
    </div>
@endsection
