@extends('layouts.app')
@section('content')
    <div class="container mx-auto px-4 py-10">
        <h2 class="text-3xl font-bold mb-6 text-center text-gray-800">Pilih Kategori Buku Favoritmu</h2>
        <form action="{{ route('save.preferences') }}" method="POST" class="max-w-2xl mx-auto">
            @csrf
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                @foreach ($categories as $category)
                    <label class="flex items-center gap-2 border rounded-lg p-3 cursor-pointer hover:bg-blue-50">
                        <input type="checkbox" name="categories[]" value="{{ $category->id }}" class="form-checkbox">
                        <span class="text-gray-700">{{ $category->name }}</span>
                    </label>
                @endforeach
            </div>
            <div class="text-center">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Simpan
                    Preferensi</button>
            </div>
        </form>
    </div>
@endsection
