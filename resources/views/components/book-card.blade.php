@props(['book'])
<div class="bg-white shadow rounded-xl overflow-hidden transition-transform transform hover:scale-105">
    <a href="{{ route('books.show', $book->slug) }}">
        <img src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : asset('images/default-cover.jpg') }}"
            alt="{{ $book->title }}" class="w-full h-60 object-cover">
        <div class="p-4">
            <h3 class="font-semibold text-gray-800 truncate">{{ $book->title }}</h3>
            <p class="text-sm text-gray-600 truncate">{{ $book->author }}</p>
            <span class="inline-block mt-2 text-xs px-2 py-1 rounded-full bg-blue-100 text-blue-600">
                {{ $book->category->name }}
            </span>
        </div>
    </a>
</div>
