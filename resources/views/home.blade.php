@extends('layouts.app')

@section('title', 'Digital Library - Perpustakaan Digital Terbaik')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center min-vh-60">
                <div class="col-lg-6">
                    <div class="hero-content animate-fade-in-up">
                        <h1 class="hero-title">
                            Temukan Dunia <br>
                            <span class="text-gradient">Pengetahuan Digital</span>
                        </h1>
                        <p class="hero-subtitle">
                            Akses ribuan buku digital berkualitas tinggi kapan saja dan di mana saja.
                            Dapatkan rekomendasi buku sesuai minat dan preferensi unik Anda.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-image animate-fade-in-up">
                        <div class="floating-books">
                            <div class="book-float book-1">
                                <i class="fas fa-book"></i>
                            </div>
                            <div class="book-float book-2">
                                <i class="fas fa-book-open"></i>
                            </div>
                            <div class="book-float book-3">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Search Section -->
    <section class="search-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="search-card animate-fade-in-up">
                        <form action="{{ route('books.index') }}" method="GET">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control search-input"
                                    placeholder="Cari judul buku, penulis, atau kata kunci..."
                                    value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search me-2"></i>Cari Buku
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Mengapa Memilih Kami?</h2>
                <p class="section-subtitle">Fitur-fitur unggulan yang membuat pengalaman membaca Anda lebih menyenangkan</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card text-center animate-fade-in-up">
                        <div class="feature-icon mb-4">
                            <i class="fas fa-search text-primary"></i>
                        </div>
                        <h5 class="feature-title">Pencarian Cerdas</h5>
                        <p class="feature-description">
                            Temukan buku yang Anda cari dengan cepat menggunakan sistem pencarian yang intuitif dan akurat.
                        </p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="feature-card text-center animate-fade-in-up">
                        <div class="feature-icon mb-4">
                            <i class="fas fa-magic text-primary"></i>
                        </div>
                        <h5 class="feature-title">Rekomendasi Personal</h5>
                        <p class="feature-description">
                            Dapatkan rekomendasi buku yang disesuaikan dengan minat dan preferensi membaca Anda.
                        </p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="feature-card text-center animate-fade-in-up">
                        <div class="feature-icon mb-4">
                            <i class="fas fa-bookmark text-primary"></i>
                        </div>
                        <h5 class="feature-title">Bookmark & Progress</h5>
                        <p class="feature-description">
                            Simpan progres membaca Anda dan lanjutkan kapan saja dari perangkat manapun.
                        </p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="feature-card text-center animate-fade-in-up">
                        <div class="feature-icon mb-4">
                            <i class="fas fa-mobile-alt text-primary"></i>
                        </div>
                        <h5 class="feature-title">Akses Multi-Device</h5>
                        <p class="feature-description">
                            Nikmati pengalaman membaca yang konsisten di smartphone, tablet, atau komputer.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    @if (isset($categories) && $categories->count() > 0)
        <section class="py-5 bg-light">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="section-title">Jelajahi Berdasarkan Kategori</h2>
                    <p class="section-subtitle">Temukan buku sesuai dengan minat dan passion Anda</p>
                </div>

                <div class="row g-4">
                    @foreach ($categories->take(6) as $category)
                        <div class="col-lg-4 col-md-6">
                            <a href="{{ route('books.index', ['category' => $category->id]) }}"
                                class="text-decoration-none">
                                <div class="category-card animate-fade-in-up">
                                    <div class="category-icon" style="color: {{ $category->color }};">
                                        <i class="{{ $category->icon }}"></i>
                                    </div>
                                    <div class="category-content">
                                        <h5 class="category-name">{{ $category->name }}</h5>
                                        <p class="category-count">{{ $category->books_count }} Buku Tersedia</p>
                                        @if ($category->description)
                                            <p class="category-description">{{ Str::limit($category->description, 80) }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="category-arrow">
                                        <i class="fas fa-arrow-right"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-5">
                    <a href="{{ route('category.preferences') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-th-large me-2"></i>Lihat Semua Kategori
                    </a>
                </div>
            </div>
        </section>
    @endif

    <!-- Featured Books Section -->
    @if (isset($featuredBooks) && $featuredBooks->count() > 0)
        <section class="py-5">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="section-title">Buku Pilihan Editor</h2>
                    <p class="section-subtitle">Koleksi terbaik yang direkomendasikan oleh tim kami</p>
                </div>

                <div class="row g-4">
                    @foreach ($featuredBooks as $book)
                        <div class="col-lg-4 col-md-6">
                            <div class="book-card animate-fade-in-up">
                                <div class="book-image-container">
                                    @if ($book->cover_image)
                                        <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}"
                                            class="book-cover">
                                    @else
                                        <div class="book-placeholder">
                                            <i class="fas fa-book fa-3x text-muted"></i>
                                        </div>
                                    @endif
                                    <div class="book-overlay">
                                        <div class="book-actions">
                                            <a href="{{ route('books.show', $book->slug) }}"
                                                class="btn btn-light btn-sm">
                                                <i class="fas fa-eye me-1"></i>Detail
                                            </a>
                                            <a href="{{ route('books.read', $book->slug) }}"
                                                class="btn btn-primary btn-sm">
                                                <i class="fas fa-book-open me-1"></i>Baca
                                            </a>
                                        </div>
                                    </div>
                                    <div class="book-badge">
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-crown me-1"></i>Pilihan Editor
                                        </span>
                                    </div>
                                </div>
                                <div class="book-content">
                                    <div class="book-category">
                                        <span class="category-chip"
                                            style="background-color: {{ $book->category->color }}20; color: {{ $book->category->color }};">
                                            {{ $book->category->name }}
                                        </span>
                                    </div>
                                    <h5 class="book-title">{{ $book->title }}</h5>
                                    <p class="book-author">oleh {{ $book->author }}</p>
                                    <div class="book-rating">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i
                                                class="fas fa-star {{ $i <= $book->rating ? 'text-warning' : 'text-muted' }}"></i>
                                        @endfor
                                        <span class="rating-text">{{ number_format($book->rating, 1) }}</span>
                                    </div>
                                    <p class="book-description">{{ Str::limit($book->description, 100) }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-5">
                    <a href="{{ route('books.index') }}" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-books me-2"></i>Lihat Semua Buku
                    </a>
                </div>
            </div>
        </section>
    @endif

    <!-- Popular Books Section -->
    @if (isset($popularBooks) && $popularBooks->count() > 0)
        <section class="py-5 bg-light">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="section-title">Buku Terpopuler</h2>
                    <p class="section-subtitle">Buku yang paling banyak dibaca oleh pengguna kami</p>
                </div>

                <div class="row g-3">
                    @foreach ($popularBooks->take(8) as $book)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="popular-book-card animate-fade-in-up">
                                <a href="{{ route('books.show', $book->slug) }}" class="text-decoration-none">
                                    <div class="popular-book-image">
                                        @if ($book->cover_image)
                                            <img src="{{ asset('storage/' . $book->cover_image) }}"
                                                alt="{{ $book->title }}" class="img-fluid">
                                        @else
                                            <div class="book-placeholder-small">
                                                <i class="fas fa-book fa-2x text-muted"></i>
                                            </div>
                                        @endif
                                        <div class="popular-badge">
                                            <i class="fas fa-fire text-warning"></i>
                                        </div>
                                    </div>
                                    <div class="popular-book-info">
                                        <h6 class="book-title">{{ Str::limit($book->title, 40) }}</h6>
                                        <p class="book-author">{{ $book->author }}</p>
                                        <div class="book-stats">
                                            <span class="views">
                                                <i class="fas fa-eye me-1"></i>{{ $book->views }}
                                            </span>
                                            <span class="rating">
                                                <i
                                                    class="fas fa-star text-warning me-1"></i>{{ number_format($book->rating, 1) }}
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- CTA Section -->
    <section class="py-5">
        <div class="container">
            <div class="cta-card text-center animate-fade-in-up">
                <div class="cta-content">
                    <h2 class="cta-title">Mulai Petualangan Literasi Anda</h2>
                    <p class="cta-description">
                        Bergabunglah dengan ribuan pembaca lain dan temukan dunia pengetahuan yang tak terbatas.
                        Daftar sekarang untuk mendapatkan akses ke ribuan buku digital berkualitas tinggi.
                    </p>
                    @guest
                        <div class="cta-actions">
                            <a href="{{ route('register') }}" class="btn btn-primary btn-lg me-3">
                                <i class="fas fa-user-plus me-2"></i>Daftar Gratis
                            </a>
                            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i>Sudah Punya Akun?
                            </a>
                        </div>
                    @else
                        <div class="cta-actions">
                            <a href="{{ route('books.index') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-book-open me-2"></i>Jelajahi Koleksi Lengkap
                            </a>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </section>

@endsection

@push('styles')
    <style>
        .text-gradient {
            background: linear-gradient(135deg, #ec4899, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 1rem;
        }

        .section-subtitle {
            font-size: 1.1rem;
            color: var(--gray-600);
            max-width: 600px;
            margin: 0 auto;
        }

        .hero-actions {
            margin-top: 2.5rem;
        }

        .floating-books {
            position: relative;
            height: 400px;
        }

        .book-float {
            position: absolute;
            font-size: 3rem;
            color: rgba(255, 255, 255, 0.3);
            animation: bookFloat 6s ease-in-out infinite;
        }

        .book-1 {
            top: 20%;
            right: 20%;
            animation-delay: 0s;
        }

        .book-2 {
            bottom: 30%;
            left: 10%;
            animation-delay: 2s;
        }

        .book-3 {
            top: 10%;
            left: 30%;
            animation-delay: 4s;
        }

        @keyframes bookFloat {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(5deg);
            }
        }

        .feature-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            height: 100%;
            transition: all 0.3s ease;
            border: 1px solid var(--gray-200);
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(236, 72, 153, 0.1));
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            font-size: 2rem;
        }

        .feature-title {
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 1rem;
        }

        .feature-description {
            color: var(--gray-600);
            line-height: 1.6;
        }

        .category-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            height: 100%;
            transition: all 0.3s ease;
            border: 1px solid var(--gray-200);
            position: relative;
            overflow: hidden;
        }

        .category-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.05), rgba(236, 72, 153, 0.05));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .category-card:hover::before {
            opacity: 1;
        }

        .category-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            color: inherit;
        }

        .category-icon {
            font-size: 3rem;
            margin-bottom: 1.5rem;
            position: relative;
            z-index: 2;
        }

        .category-content {
            position: relative;
            z-index: 2;
        }

        .category-name {
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 0.5rem;
        }

        .category-count {
            color: var(--primary-color);
            font-weight: 500;
            margin-bottom: 1rem;
        }

        .category-description {
            color: var(--gray-600);
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }

        .category-arrow {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            color: var(--gray-400);
            transition: all 0.3s ease;
            z-index: 2;
        }

        .category-card:hover .category-arrow {
            color: var(--primary-color);
            transform: translateX(5px);
        }

        .book-image-container {
            position: relative;
            overflow: hidden;
            border-radius: 15px;
            margin-bottom: 1.5rem;
        }

        .book-cover {
            width: 100%;
            height: 300px;
            object-fit: cover;
            transition: all 0.4s ease;
        }

        .book-placeholder {
            width: 100%;
            height: 300px;
            background: var(--gray-100);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 15px;
        }

        .book-overlay {
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

        .book-card:hover .book-overlay {
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
            z-index: 3;
        }

        .book-content {
            padding: 0 0.5rem;
        }

        .book-category {
            margin-bottom: 1rem;
        }

        .book-title {
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }

        .book-author {
            color: var(--gray-600);
            font-size: 0.9rem;
            margin-bottom: 0.75rem;
        }

        .book-rating {
            margin-bottom: 1rem;
        }

        .rating-text {
            color: var(--gray-600);
            font-size: 0.9rem;
            margin-left: 0.5rem;
        }

        .book-description {
            color: var(--gray-600);
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .popular-book-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            transition: all 0.3s ease;
            border: 1px solid var(--gray-200);
            height: 100%;
        }

        .popular-book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .popular-book-image {
            position: relative;
            height: 200px;
            overflow: hidden;
        }

        .popular-book-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.3s ease;
        }

        .popular-book-card:hover .popular-book-image img {
            transform: scale(1.05);
        }

        .book-placeholder-small {
            width: 100%;
            height: 200px;
            background: var(--gray-100);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .popular-badge {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 15px;
            font-size: 0.8rem;
        }

        .popular-book-info {
            padding: 1rem;
        }

        .popular-book-info .book-title {
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
            color: var(--gray-800);
        }

        .popular-book-info .book-author {
            font-size: 0.8rem;
            color: var(--gray-600);
            margin-bottom: 0.75rem;
        }

        .book-stats {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.8rem;
        }

        .book-stats .views {
            color: var(--gray-500);
        }

        .book-stats .rating {
            color: var(--gray-700);
        }

        .cta-card {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            border-radius: 20px;
            padding: 4rem 2rem;
            position: relative;
            overflow: hidden;
        }

        .cta-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="cta-pattern" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23cta-pattern)"/></svg>');
            animation: float 25s ease-in-out infinite;
        }

        .cta-content {
            position: relative;
            z-index: 2;
        }

        .cta-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .cta-description {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .cta-actions .btn {
            margin: 0.5rem;
        }

        .cta-actions .btn-primary {
            background: white;
            color: var(--primary-color);
            border: none;
        }

        .cta-actions .btn-primary:hover {
            background: var(--gray-100);
            color: var(--primary-dark);
        }

        .cta-actions .btn-outline-primary {
            border-color: white;
            color: white;
        }

        .cta-actions .btn-outline-primary:hover {
            background: white;
            color: var(--primary-color);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .section-title {
                font-size: 2rem;
            }

            .cta-title {
                font-size: 2rem;
            }

            .feature-card,
            .category-card {
                margin-bottom: 2rem;
            }

            .book-cover {
                height: 250px;
            }

            .popular-book-image {
                height: 180px;
            }
        }

        @media (max-width: 576px) {
            .hero-actions .btn {
                display: block;
                width: 100%;
                margin-bottom: 1rem;
            }

            .cta-actions .btn {
                display: block;
                width: 100%;
                margin-bottom: 1rem;
            }

            .search-card {
                padding: 1.5rem;
            }

            .input-group .btn {
                min-width: 80px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // Animate elements on scroll
            const animateOnScroll = () => {
                $('.animate-fade-in-up').each(function() {
                    const elementTop = $(this).offset().top;
                    const elementBottom = elementTop + $(this).outerHeight();
                    const viewportTop = $(window).scrollTop();
                    const viewportBottom = viewportTop + $(window).height();

                    if (elementBottom > viewportTop && elementTop < viewportBottom) {
                        $(this).addClass('animate-fade-in-up');
                    }
                });
            };

            // Trigger animation on scroll
            $(window).on('scroll', animateOnScroll);
            animateOnScroll(); // Initial check

            // Enhanced search functionality
            $('.search-input').on('focus', function() {
                $(this).parent().parent().addClass('search-focused');
            }).on('blur', function() {
                $(this).parent().parent().removeClass('search-focused');
            });

            // Book card hover effects
            $('.book-card').hover(
                function() {
                    $(this).find('.book-cover').addClass('scale-effect');
                },
                function() {
                    $(this).find('.book-cover').removeClass('scale-effect');
                }
            );

            // Popular book click tracking
            $('.popular-book-card a').on('click', function() {
                // You can add analytics tracking here
                console.log('Popular book clicked:', $(this).find('.book-title').text());
            });

            // Smooth scroll for CTA buttons
            $('a[href^="#"]').on('click', function(event) {
                var target = $(this.getAttribute('href'));
                if (target.length) {
                    event.preventDefault();
                    $('html, body').stop().animate({
                        scrollTop: target.offset().top - 100
                    }, 600);
                }
            });

            // Dynamic stats counter (if you want to add this feature)
            const animateCounter = (element, target) => {
                let current = 0;
                const increment = target / 100;
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        current = target;
                        clearInterval(timer);
                    }
                    element.text(Math.floor(current));
                }, 20);
            };

            // Initialize counters when visible
            $('.stats-number').each(function() {
                const $this = $(this);
                const target = parseInt($this.text());
                if (target > 0) {
                    $this.text('0');
                    $(window).on('scroll', function() {
                        const elementTop = $this.offset().top;
                        const windowBottom = $(window).scrollTop() + $(window).height();

                        if (elementTop < windowBottom && !$this.hasClass('animated')) {
                            $this.addClass('animated');
                            animateCounter($this, target);
                        }
                    });
                }
            });
        });

        // Add CSS for scale effect
        const style = document.createElement('style');
        style.textContent = `
    .scale-effect {
        transform: scale(1.1) !important;
    }
    
    .search-focused {
        transform: scale(1.02);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15) !important;
    }
`;
        document.head.appendChild(style);
    </script>
@endpush
