@extends('layouts.app')

@section('title', 'Koleksi Buku - Digital Library')

@section('content')
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="page-header-content">
                        <h1 class="page-title">
                            <i class="fas fa-books me-3"></i>Koleksi Buku Digital
                        </h1>
                        <p class="page-subtitle">
                            Jelajahi ribuan buku digital berkualitas tinggi dari berbagai kategori dan genre
                        </p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="page-stats">
                        <div class="stat-item">
                            <div class="stat-number">{{ $books->total() }}</div>
                            <div class="stat-label">Total Buku</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Search & Filter Section -->
    <section class="search-filter-section">
        <div class="container">
            <div class="search-filter-card">
                <form method="GET" action="{{ route('books.index') }}" class="search-filter-form">
                    <div class="row g-3 align-items-end">
                        <div class="col-lg-6">
                            <label class="form-label">Cari Buku</label>
                            <div class="search-input-group">
                                <i class="fas fa-search search-icon"></i>
                                <input type="text" name="search" class="form-control search-input"
                                    placeholder="Masukkan judul buku, penulis, atau kata kunci..."
                                    value="{{ request('search') }}">
                                @if (request('search'))
                                    <button type="button" class="clear-search" onclick="clearSearch()">
                                        <i class="fas fa-times"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">Kategori</label>
                            <select name="category" class="form-select category-select">
                                <option value="">Semua Kategori</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ request('category') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }} ({{ $cat->books_count }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <div class="search-actions">
                                <button type="submit" class="btn btn-primary btn-search">
                                    <i class="fas fa-search me-2"></i>Cari
                                </button>
                                @if (request('search') || request('category'))
                                    <a href="{{ route('books.index') }}" class="btn btn-outline-secondary btn-reset">
                                        <i class="fas fa-refresh me-2"></i>Reset
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Books Grid Section -->
    <section class="books-grid-section">
        <div class="container">
            @if ($books->count() > 0)
                <!-- Results Info -->
                <div class="results-info">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <p class="results-text">
                                Menampilkan {{ $books->firstItem() }}-{{ $books->lastItem() }}
                                dari {{ $books->total() }} buku
                                @if (request('search'))
                                    untuk "<strong>{{ request('search') }}</strong>"
                                @endif
                                @if (request('category'))
                                    @php
                                        $selectedCategory = $categories->where('id', request('category'))->first();
                                    @endphp
                                    @if ($selectedCategory)
                                        dalam kategori "<strong>{{ $selectedCategory->name }}</strong>"
                                    @endif
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <div class="view-options">
                                <button class="view-btn active" data-view="grid" title="Grid View">
                                    <i class="fas fa-th"></i>
                                </button>
                                <button class="view-btn" data-view="list" title="List View">
                                    <i class="fas fa-list"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Books Grid -->
                <div class="books-grid" id="booksGrid">
                    @foreach ($books as $book)
                        <div class="book-item animate-fade-in-up">
                            <div class="book-card">
                                <div class="book-image-container">
                                    <a href="{{ route('books.show', $book->slug) }}">
                                        @if ($book->cover_image)
                                            <img src="{{ asset('storage/' . $book->cover_image) }}"
                                                alt="{{ $book->title }}" class="book-cover">
                                        @else
                                            <div class="book-placeholder">
                                                <i class="fas fa-book fa-3x"></i>
                                            </div>
                                        @endif
                                    </a>

                                    <!-- Book Actions Overlay -->
                                    <div class="book-actions-overlay">
                                        <div class="book-actions">
                                            <a href="{{ route('books.show', $book->slug) }}" class="btn btn-light btn-sm"
                                                title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @auth
                                                <button class="btn btn-light btn-sm bookmark-btn"
                                                    data-book-id="{{ $book->id }}"
                                                    data-bookmarked="{{ $book->isBookmarkedBy(Auth::user()) ? 'true' : 'false' }}"
                                                    title="{{ $book->isBookmarkedBy(Auth::user()) ? 'Hapus Bookmark' : 'Tambah Bookmark' }}">
                                                    <i
                                                        class="fas fa-bookmark {{ $book->isBookmarkedBy(Auth::user()) ? 'text-primary' : '' }}"></i>
                                                </button>
                                                <a href="{{ route('books.read', $book->slug) }}" class="btn btn-primary btn-sm"
                                                    title="Baca Sekarang">
                                                    <i class="fas fa-book-open"></i>
                                                </a>
                                            @else
                                                <a href="{{ route('login') }}" class="btn btn-primary btn-sm"
                                                    title="Login untuk Membaca">
                                                    <i class="fas fa-book-open"></i>
                                                </a>
                                            @endauth
                                        </div>
                                    </div>

                                    <!-- Book Badge -->
                                    @if ($book->is_featured)
                                        <div class="book-badge featured">
                                            <i class="fas fa-crown"></i>
                                        </div>
                                    @endif

                                    <!-- Book Stats -->
                                    <div class="book-stats-overlay">
                                        <div class="stat-item">
                                            <i class="fas fa-eye"></i>
                                            <span>{{ $book->views }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="book-content">
                                    <div class="book-category">
                                        <a href="{{ route('books.index', ['category' => $book->category->id]) }}"
                                            class="category-tag"
                                            style="background-color: {{ $book->category->color }}20; color: {{ $book->category->color }};">
                                            <i class="{{ $book->category->icon }} me-1"></i>
                                            {{ $book->category->name }}
                                        </a>
                                    </div>

                                    <h3 class="book-title">
                                        <a href="{{ route('books.show', $book->slug) }}">{{ $book->title }}</a>
                                    </h3>

                                    <p class="book-author">
                                        <i class="fas fa-user-edit me-1"></i>{{ $book->author }}
                                    </p>

                                    <div class="book-rating">
                                        <div class="stars">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $book->rating ? 'active' : '' }}"></i>
                                            @endfor
                                        </div>
                                        <span class="rating-value">{{ number_format($book->rating, 1) }}</span>
                                    </div>

                                    <p class="book-description">
                                        {{ Str::limit($book->description, 120) }}
                                    </p>

                                    <div class="book-meta">
                                        <div class="meta-item">
                                            <i class="fas fa-calendar-alt"></i>
                                            <span>{{ $book->published_year }}</span>
                                        </div>
                                        <div class="meta-item">
                                            <i class="fas fa-file-alt"></i>
                                            <span>{{ $book->pages }} hal</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="pagination-container">
                    {{ $books->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="empty-state">
                    <div class="empty-state-content">
                        <div class="empty-state-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <h3>Tidak Ada Buku Ditemukan</h3>
                        <p>
                            @if (request('search') || request('category'))
                                Maaf, tidak ada buku yang sesuai dengan kriteria pencarian Anda.
                                <br>Coba gunakan kata kunci yang berbeda atau ubah filter pencarian.
                            @else
                                Belum ada buku yang tersedia saat ini.
                            @endif
                        </p>
                        <div class="empty-state-actions">
                            @if (request('search') || request('category'))
                                <a href="{{ route('books.index') }}" class="btn btn-primary">
                                    <i class="fas fa-refresh me-2"></i>Lihat Semua Buku
                                </a>
                            @endif
                            <a href="{{ route('category.preferences') }}" class="btn btn-outline-primary">
                                <i class="fas fa-heart me-2"></i>Atur Preferensi
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('styles')
    <style>
        .page-header {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            padding: 6rem 0 4rem;
            margin-top: -100px;
            padding-top: 200px;
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="books-pattern" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23books-pattern)"/></svg>');
            animation: float 30s ease-in-out infinite;
        }

        .page-header-content {
            position: relative;
            z-index: 2;
        }

        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .page-subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 0;
        }

        .page-stats {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .stat-item {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            display: block;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 1.1rem;
            opacity: 0.8;
        }

        .search-filter-section {
            margin-top: -50px;
            position: relative;
            z-index: 10;
            padding-bottom: 3rem;
        }

        .search-filter-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .search-input-group {
            position: relative;
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-400);
            z-index: 2;
        }

        .search-input {
            padding-left: 3rem;
            padding-right: 3rem;
            border-radius: 50px;
            border: 2px solid var(--gray-200);
            transition: all 0.3s ease;
        }

        .search-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25);
        }

        .clear-search {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--gray-400);
            cursor: pointer;
            z-index: 2;
        }

        .category-select {
            border-radius: 50px;
            border: 2px solid var(--gray-200);
            transition: all 0.3s ease;
        }

        .category-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25);
        }

        .btn-search,
        .btn-reset {
            border-radius: 50px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
        }

        .books-grid-section {
            padding: 2rem 0 4rem;
        }

        .results-info {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--gray-200);
        }

        .results-text {
            margin: 0;
            color: var(--gray-600);
        }

        .view-options {
            display: flex;
            gap: 0.5rem;
            justify-content: flex-end;
        }

        .view-btn {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            border: 2px solid var(--gray-200);
            background: white;
            color: var(--gray-500);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .view-btn.active,
        .view-btn:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
            background: rgba(99, 102, 241, 0.1);
        }

        .books-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .book-item {
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 0.6s ease forwards;
        }

        .book-item:nth-child(1) {
            animation-delay: 0.1s;
        }

        .book-item:nth-child(2) {
            animation-delay: 0.2s;
        }

        .book-item:nth-child(3) {
            animation-delay: 0.3s;
        }

        .book-item:nth-child(4) {
            animation-delay: 0.4s;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .book-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s ease;
            height: 100%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--gray-200);
        }

        .book-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        .book-image-container {
            position: relative;
            height: 300px;
            overflow: hidden;
        }

        .book-cover {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.4s ease;
        }

        .book-card:hover .book-cover {
            transform: scale(1.05);
        }

        .book-placeholder {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--gray-100), var(--gray-200));
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray-400);
        }

        .book-actions-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: all 0.3s ease;
        }

        .book-card:hover .book-actions-overlay {
            opacity: 1;
        }

        .book-actions {
            display: flex;
            gap: 0.5rem;
        }

        .book-badge {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background: var(--warning-color);
            color: white;
            padding: 0.5rem;
            border-radius: 50%;
            font-size: 0.8rem;
            z-index: 3;
        }

        .book-stats-overlay {
            position: absolute;
            bottom: 1rem;
            right: 1rem;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 0.5rem 0.75rem;
            border-radius: 15px;
            font-size: 0.8rem;
            z-index: 3;
        }

        .book-content {
            padding: 1.5rem;
        }

        .book-category {
            margin-bottom: 1rem;
        }

        .category-tag {
            display: inline-block;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .category-tag:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            text-decoration: none;
        }

        .book-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            line-height: 1.3;
        }

        .book-title a {
            color: var(--gray-800);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .book-title a:hover {
            color: var(--primary-color);
        }

        .book-author {
            color: var(--gray-600);
            font-size: 0.9rem;
            margin-bottom: 0.75rem;
        }

        .book-rating {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .stars {
            display: flex;
            gap: 0.2rem;
        }

        .stars i {
            color: var(--gray-300);
            font-size: 0.9rem;
        }

        .stars i.active {
            color: var(--warning-color);
        }

        .rating-value {
            font-weight: 600;
            color: var(--gray-700);
            font-size: 0.9rem;
        }

        .book-description {
            color: var(--gray-600);
            font-size: 0.9rem;
            line-height: 1.5;
            margin-bottom: 1rem;
        }

        .book-meta {
            display: flex;
            gap: 1rem;
            font-size: 0.8rem;
            color: var(--gray-500);
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .empty-state {
            text-align: center;
            padding: 5rem 2rem;
        }

        .empty-state-icon {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--gray-100), var(--gray-200));
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            font-size: 3rem;
            color: var(--gray-400);
        }

        .empty-state h3 {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 1rem;
        }

        .empty-state p {
            color: var(--gray-600);
            margin-bottom: 2rem;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        .empty-state-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 3rem;
        }

        /* List View */
        .books-grid.list-view {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .books-grid.list-view .book-card {
            display: flex;
            height: 200px;
        }

        .books-grid.list-view .book-image-container {
            width: 150px;
            flex-shrink: 0;
        }

        .books-grid.list-view .book-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-title {
                font-size: 2.5rem;
            }

            .search-filter-card {
                padding: 1.5rem;
            }

            .search-actions {
                display: flex;
                flex-direction: column;
                gap: 0.5rem;
            }

            .btn-search,
            .btn-reset {
                width: 100%;
            }

            .books-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 1.5rem;
            }

            .results-info .row {
                flex-direction: column;
                gap: 1rem;
            }

            .view-options {
                justify-content: center;
            }

            .books-grid.list-view .book-card {
                flex-direction: column;
                height: auto;
            }

            .books-grid.list-view .book-image-container {
                width: 100%;
                height: 200px;
            }
        }

        @media (max-width: 576px) {
            .page-header {
                padding: 4rem 0 2rem;
                padding-top: 150px;
            }

            .books-grid {
                grid-template-columns: 1fr;
            }

            .empty-state {
                padding: 3rem 1rem;
            }

            .empty-state-actions {
                flex-direction: column;
                align-items: center;
            }

            .empty-state-actions .btn {
                width: 100%;
                max-width: 300px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // View toggle functionality
            $('.view-btn').on('click', function() {
                const view = $(this).data('view');

                $('.view-btn').removeClass('active');
                $(this).addClass('active');

                if (view === 'list') {
                    $('#booksGrid').addClass('list-view');
                } else {
                    $('#booksGrid').removeClass('list-view');
                }

                // Save preference to localStorage
                localStorage.setItem('booksView', view);
            });

            // Load saved view preference
            const savedView = localStorage.getItem('booksView');
            if (savedView) {
                $(`.view-btn[data-view="${savedView}"]`).click();
            }

            // Bookmark functionality
            $('.bookmark-btn').on('click', function() {
                const $btn = $(this);
                const bookId = $btn.data('book-id');
                const isBookmarked = $btn.data('bookmarked') === 'true';

                // Show loading state
                $btn.prop('disabled', true);
                const originalHtml = $btn.html();
                $btn.html('<i class="fas fa-spinner fa-spin"></i>');

                $.ajax({
                    url: `/books/${bookId}/bookmark`,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            // Update button state
                            $btn.data('bookmarked', response.isBookmarked ? 'true' : 'false');
                            $btn.attr('title', response.isBookmarked ? 'Hapus Bookmark' :
                                'Tambah Bookmark');

                            // Update icon
                            const iconClass = response.isBookmarked ?
                                'fas fa-bookmark text-primary' : 'fas fa-bookmark';
                            $btn.html(`<i class="${iconClass}"></i>`);

                            // Show toast notification
                            showToast(response.message, 'success');
                        } else {
                            $btn.html(originalHtml);
                            showToast('Terjadi kesalahan', 'error');
                        }
                    },
                    error: function() {
                        $btn.html(originalHtml);
                        showToast('Silakan login terlebih dahulu', 'warning');
                    },
                    complete: function() {
                        $btn.prop('disabled', false);
                    }
                });
            });

            // Clear search functionality
            window.clearSearch = function() {
                $('input[name="search"]').val('');
                $('.search-filter-form').submit();
            };

            // Advanced search toggle
            let advancedSearchVisible = false;
            $('#toggleAdvancedSearch').on('click', function() {
                advancedSearchVisible = !advancedSearchVisible;
                $('#advancedSearch').slideToggle();
                $(this).text(advancedSearchVisible ? 'Sembunyikan Filter Lanjutan' :
                    'Tampilkan Filter Lanjutan');
            });

            // Auto-submit search form on category change
            $('.category-select').on('change', function() {
                $('.search-filter-form').submit();
            });

            // Search input enhancements
            let searchTimeout;
            $('.search-input').on('input', function() {
                const $input = $(this);
                const $clearBtn = $('.clear-search');

                if ($input.val().length > 0) {
                    $clearBtn.show();
                } else {
                    $clearBtn.hide();
                }
            });

            // Initialize clear button visibility
            if ($('.search-input').val().length > 0) {
                $('.clear-search').show();
            }

            // Animate books on scroll
            const observer = new IntersectionObserver(
                (entries) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('animate-fade-in-up');
                        }
                    });
                }, {
                    threshold: 0.1
                }
            );

            // Observe all book items
            document.querySelectorAll('.book-item').forEach((item) => {
                observer.observe(item);
            });

            // Book card hover effects
            $('.book-card').on('mouseenter', function() {
                $(this).find('.book-cover').addClass('hover-scale');
            }).on('mouseleave', function() {
                $(this).find('.book-cover').removeClass('hover-scale');
            });

            // Lazy loading for book covers
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });

            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        });

        // Toast notification function
        function showToast(message, type = 'info') {
            const toastHtml = `
        <div class="toast align-items-center text-white bg-${type === 'success' ? 'success' : type === 'error' ? 'danger' : type === 'warning' ? 'warning' : 'info'} border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : type === 'warning' ? 'exclamation-triangle' : 'info-circle'} me-2"></i>
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    `;

            // Create toast container if it doesn't exist
            let toastContainer = document.querySelector('.toast-container');
            if (!toastContainer) {
                toastContainer = document.createElement('div');
                toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
                document.body.appendChild(toastContainer);
            }

            // Add toast to container
            const toastElement = document.createElement('div');
            toastElement.innerHTML = toastHtml;
            toastContainer.appendChild(toastElement.firstElementChild);

            // Initialize and show toast
            const toast = new bootstrap.Toast(toastContainer.lastElementChild, {
                autohide: true,
                delay: 3000
            });
            toast.show();

            // Remove toast element after it's hidden
            toastContainer.lastElementChild.addEventListener('hidden.bs.toast', function() {
                this.remove();
            });
        }

        // Add custom CSS for hover effects
        const style = document.createElement('style');
        style.textContent = `
    .hover-scale {
        transform: scale(1.05) !important;
    }
    
    .lazy {
        opacity: 0;
        transition: opacity 0.3s;
    }
    
    .lazy.loaded {
        opacity: 1;
    }
    
    .toast-container {
        z-index: 9999;
    }
    
    .book-card .book-actions .btn {
        backdrop-filter: blur(10px);
    }
    
    .search-input-group .clear-search {
        display: none;
    }
    
    .category-tag:hover {
        color: inherit !important;
    }
`;
        document.head.appendChild(style);
    </script>
@endpush
