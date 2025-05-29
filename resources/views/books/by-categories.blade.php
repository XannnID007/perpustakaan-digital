@extends('layouts.app')

@section('title', 'Buku Berdasarkan Kategori - Digital Library')

@section('content')
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="page-header-content">
                        <div class="breadcrumb-nav">
                            <a href="{{ route('home') }}" class="breadcrumb-link">
                                <i class="fas fa-home me-1"></i>Beranda
                            </a>
                            <span class="breadcrumb-separator">/</span>
                            <a href="{{ route('books.index') }}" class="breadcrumb-link">
                                <i class="fas fa-book me-1"></i>Koleksi Buku
                            </a>
                            <span class="breadcrumb-separator">/</span>
                            <span class="breadcrumb-current">Kategori Terpilih</span>
                        </div>

                        <h1 class="page-title">
                            <i class="fas fa-filter me-3"></i>Buku Berdasarkan Kategori
                        </h1>

                        <p class="page-subtitle">
                            Menampilkan koleksi buku dari kategori yang Anda pilih.
                            Temukan buku-buku terbaik sesuai minat Anda.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="page-stats">
                        <div class="stat-card">
                            <div class="stat-number">{{ $books->total() }}</div>
                            <div class="stat-label">Total Buku Ditemukan</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Selected Categories Section -->
    <section class="selected-categories-section">
        <div class="container">
            <div class="selected-categories-card">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="categories-header">
                            <h3 class="categories-title">
                                <i class="fas fa-tags me-2"></i>Kategori Terpilih
                            </h3>
                            <p class="categories-subtitle">
                                {{ count($selectedCategories) }} kategori dipilih
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <div class="categories-actions">
                            <a href="{{ route('books.index') }}" class="btn btn-outline-primary btn-sm me-2">
                                <i class="fas fa-list me-1"></i>Semua Buku
                            </a>
                            <a href="{{ route('category.preferences') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-heart me-1"></i>Ubah Preferensi
                            </a>
                        </div>
                    </div>
                </div>

                <div class="categories-list">
                    @foreach ($selectedCategories as $category)
                        <div class="category-item">
                            <div class="category-icon" style="color: {{ $category->color }};">
                                <i class="{{ $category->icon }}"></i>
                            </div>
                            <div class="category-info">
                                <h5 class="category-name">{{ $category->name }}</h5>
                                @if ($category->description)
                                    <p class="category-description">{{ Str::limit($category->description, 80) }}</p>
                                @endif
                                <div class="category-stats">
                                    <span class="book-count">
                                        <i class="fas fa-book me-1"></i>
                                        {{ $category->books_count ?? 0 }} buku
                                    </span>
                                </div>
                            </div>
                            <div class="category-actions">
                                <a href="{{ route('books.index', ['category' => $category->id]) }}"
                                    class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-eye me-1"></i>Lihat Saja
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Books Results Section -->
    <section class="books-results-section">
        <div class="container">
            @if ($books->count() > 0)
                <!-- Results Header -->
                <div class="results-header">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="results-info">
                                <h4 class="results-title">Hasil Pencarian</h4>
                                <p class="results-text">
                                    Menampilkan {{ $books->firstItem() }}-{{ $books->lastItem() }}
                                    dari {{ $books->total() }} buku yang ditemukan
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="results-actions">
                                <div class="view-options">
                                    <button class="view-btn active" data-view="grid" title="Grid View">
                                        <i class="fas fa-th"></i>
                                    </button>
                                    <button class="view-btn" data-view="list" title="List View">
                                        <i class="fas fa-list"></i>
                                    </button>
                                </div>

                                <div class="sort-options">
                                    <select class="form-select" id="sortSelect">
                                        <option value="newest">Terbaru</option>
                                        <option value="popular">Terpopuler</option>
                                        <option value="rating">Rating Tertinggi</option>
                                        <option value="title">Judul A-Z</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Books Grid -->
                <div class="books-grid" id="booksGrid">
                    @foreach ($books as $book)
                        <div class="book-item animate-fade-in-up">
                            @include('components.book-card', ['book' => $book])
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="pagination-container">
                    {{ $books->links() }}
                </div>

                <!-- Related Actions -->
                <div class="related-actions">
                    <div class="action-cards">
                        <div class="action-card">
                            <div class="action-icon">
                                <i class="fas fa-heart"></i>
                            </div>
                            <div class="action-content">
                                <h5 class="action-title">Suka dengan hasil ini?</h5>
                                <p class="action-description">Simpan preferensi ini untuk rekomendasi yang lebih personal
                                </p>
                                <a href="{{ route('category.preferences') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-save me-1"></i>Simpan Preferensi
                                </a>
                            </div>
                        </div>

                        <div class="action-card">
                            <div class="action-icon">
                                <i class="fas fa-search"></i>
                            </div>
                            <div class="action-content">
                                <h5 class="action-title">Cari lebih spesifik?</h5>
                                <p class="action-description">Gunakan pencarian untuk hasil yang lebih tepat</p>
                                <a href="{{ route('books.index') }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-search me-1"></i>Pencarian Lanjutan
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div class="empty-state">
                    <div class="empty-state-content">
                        <div class="empty-state-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <h3 class="empty-state-title">Tidak Ada Buku Ditemukan</h3>
                        <p class="empty-state-description">
                            Maaf, tidak ada buku yang tersedia untuk kategori yang Anda pilih.
                            Coba pilih kategori lain atau jelajahi semua koleksi kami.
                        </p>
                        <div class="empty-state-actions">
                            <a href="{{ route('books.index') }}" class="btn btn-primary me-3">
                                <i class="fas fa-book me-2"></i>Lihat Semua Buku
                            </a>
                            <a href="{{ route('category.preferences') }}" class="btn btn-outline-primary">
                                <i class="fas fa-heart me-2"></i>Ubah Preferensi
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
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="filter-pattern" width="25" height="25" patternUnits="userSpaceOnUse"><circle cx="12.5" cy="12.5" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23filter-pattern)"/></svg>');
            animation: float 35s ease-in-out infinite;
        }

        .breadcrumb-nav {
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .breadcrumb-link {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .breadcrumb-link:hover {
            color: white;
        }

        .breadcrumb-separator {
            margin: 0 0.5rem;
            opacity: 0.6;
        }

        .breadcrumb-current {
            color: white;
            font-weight: 500;
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
            max-width: 600px;
        }

        .page-stats {
            position: relative;
            z-index: 2;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            display: block;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 1rem;
            opacity: 0.8;
        }

        .selected-categories-section {
            margin-top: -60px;
            position: relative;
            z-index: 10;
            padding-bottom: 3rem;
        }

        .selected-categories-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 25px;
            padding: 2.5rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .categories-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 0.25rem;
        }

        .categories-subtitle {
            color: var(--gray-600);
            margin: 0;
            font-size: 0.9rem;
        }

        .categories-actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .categories-list {
            margin-top: 2rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .category-item {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            border: 2px solid var(--gray-200);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .category-item:hover {
            border-color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .category-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            background: rgba(99, 102, 241, 0.1);
            flex-shrink: 0;
        }

        .category-info {
            flex-grow: 1;
        }

        .category-name {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 0.25rem;
        }

        .category-description {
            font-size: 0.9rem;
            color: var(--gray-600);
            margin-bottom: 0.5rem;
        }

        .category-stats {
            font-size: 0.8rem;
            color: var(--gray-500);
        }

        .category-actions {
            flex-shrink: 0;
        }

        .books-results-section {
            padding: 3rem 0 5rem;
        }

        .results-header {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--gray-200);
        }

        .results-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 0.5rem;
        }

        .results-text {
            color: var(--gray-600);
            margin: 0;
        }

        .results-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
            justify-content: flex-end;
            flex-wrap: wrap;
        }

        .view-options {
            display: flex;
            gap: 0.25rem;
            background: var(--gray-100);
            padding: 0.25rem;
            border-radius: 10px;
        }

        .view-btn {
            width: 40px;
            height: 40px;
            border: none;
            background: transparent;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            color: var(--gray-600);
        }

        .view-btn.active,
        .view-btn:hover {
            background: white;
            color: var(--primary-color);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .sort-options select {
            border-radius: 10px;
            border: 2px solid var(--gray-200);
            padding: 0.5rem 1rem;
            min-width: 150px;
        }

        .books-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .books-grid.list-view {
            grid-template-columns: 1fr;
            gap: 1.5rem;
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

        .pagination-container {
            display: flex;
            justify-content: center;
            margin-bottom: 3rem;
        }

        .related-actions {
            margin-top: 3rem;
        }

        .action-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .action-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--gray-200);
            transition: all 0.3s ease;
        }

        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .action-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .action-content {
            flex-grow: 1;
        }

        .action-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 0.5rem;
        }

        .action-description {
            color: var(--gray-600);
            font-size: 0.9rem;
            margin-bottom: 1rem;
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

        .empty-state-title {
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 1rem;
        }

        .empty-state-description {
            color: var(--gray-600);
            font-size: 1.1rem;
            margin-bottom: 2rem;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
        }

        .empty-state-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-title {
                font-size: 2.5rem;
            }

            .categories-list {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .category-item {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .results-actions {
                justify-content: center;
                margin-top: 1rem;
            }

            .books-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 1.5rem;
            }

            .action-card {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
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

        @media (max-width: 576px) {
            .page-header {
                padding: 4rem 0 2rem;
                padding-top: 150px;
            }

            .selected-categories-card {
                padding: 1.5rem;
                margin: 0 1rem;
            }

            .categories-actions {
                justify-content: center;
                margin-top: 1rem;
            }

            .books-grid {
                grid-template-columns: 1fr;
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

                // Save preference
                localStorage.setItem('categoriesBooksView', view);
            });

            // Load saved view preference
            const savedView = localStorage.getItem('categoriesBooksView');
            if (savedView) {
                $(`.view-btn[data-view="${savedView}"]`).click();
            }

            // Sort functionality
            $('#sortSelect').on('change', function() {
                const sortBy = $(this).val();
                const currentUrl = new URL(window.location);
                currentUrl.searchParams.set('sort', sortBy);
                window.location.href = currentUrl.toString();
            });

            // Animate elements on scroll
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-fade-in-up');
                    }
                });
            }, {
                threshold: 0.1
            });

            // Observe book items
            document.querySelectorAll('.book-item').forEach((item) => {
                observer.observe(item);
            });

            // Category item interactions
            $('.category-item').on('mouseenter', function() {
                $(this).find('.category-icon').css('transform', 'scale(1.1)');
            }).on('mouseleave', function() {
                $(this).find('.category-icon').css('transform', 'scale(1)');
            });

            // Smooth scroll for anchor links
            $('a[href^="#"]').on('click', function(e) {
                const target = $(this.getAttribute('href'));
                if (target.length) {
                    e.preventDefault();
                    $('html, body').animate({
                        scrollTop: target.offset().top - 100
                    }, 600);
                }
            });
        });
    </script>
@endpush
