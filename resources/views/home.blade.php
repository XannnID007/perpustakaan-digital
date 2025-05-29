@extends('layouts.app')

@section('title', 'Digital Library - Perpustakaan Digital Terbaik')

@push('styles')
    <style>
        /* Hero Section */
        .hero-section {
            position: relative;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 75vh;
            padding-top: 120px;
            padding-bottom: 100px;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><rect width="100" height="100" fill="none"/><path d="M20,20 L80,80 M80,20 L20,80 M50,0 L50,100 M0,50 L100,50" stroke="rgba(255,255,255,0.05)" stroke-width="0.5"/></svg>');
            opacity: 0.6;
        }

        .hero-content {
            position: relative;
            z-index: 10;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 900;
            background: linear-gradient(to right, #ffffff, #e0e0e0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1.5rem;
            text-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .hero-text {
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2rem;
            max-width: 700px;
        }

        .hero-btn {
            padding: 15px 40px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .hero-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
        }

        .floating-element {
            position: absolute;
            animation: float 6s ease-in-out infinite;
        }

        .float-1 {
            top: 20%;
            right: 10%;
            font-size: 8rem;
            color: rgba(255, 255, 255, 0.1);
            animation-delay: 0s;
        }

        .float-2 {
            bottom: 15%;
            left: 8%;
            font-size: 6rem;
            color: rgba(255, 255, 255, 0.1);
            animation-delay: 2s;
        }

        .float-3 {
            top: 10%;
            left: 15%;
            font-size: 4rem;
            color: rgba(255, 255, 255, 0.1);
            animation-delay: 4s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(5deg);
            }
        }

        /* Search Bar */
        .search-container {
            position: relative;
            margin-top: -40px;
            z-index: 20;
        }

        .search-card {
            border-radius: 20px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 30px;
        }

        .search-input {
            height: 60px;
            border-radius: 50px;
            padding: 0 30px;
            font-size: 1.1rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            border-color: #667eea;
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.2);
        }

        .search-btn {
            position: absolute;
            right: 8px;
            top: 8px;
            height: 44px;
            min-width: 100px;
            border-radius: 50px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-weight: 600;
            z-index: 10;
            transition: all 0.3s ease;
        }

        .search-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }

        /* Features Section */
        .features-section {
            padding: 100px 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.02) 0%, rgba(255, 255, 255, 0.05) 100%);
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(45deg, #ffffff, #e0e0e0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 2rem;
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -10px;
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            border-radius: 2px;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 30px;
            height: 100%;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .feature-card:hover::before {
            opacity: 1;
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            font-size: 2rem;
            color: white;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.2);
        }

        .feature-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 15px;
            color: white;
        }

        .feature-text {
            color: rgba(255, 255, 255, 0.7);
            font-size: 1rem;
            line-height: 1.6;
        }

        /* Categories Section */
        .categories-section {
            padding: 100px 0;
        }

        .category-card {
            border-radius: 20px;
            overflow: hidden;
            position: relative;
            height: 200px;
            transition: all 0.3s ease;
        }

        .category-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        .category-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.1) 0%, rgba(0, 0, 0, 0.8) 100%);
            z-index: 1;
        }

        .category-content {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 20px;
            z-index: 2;
        }

        .category-title {
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .category-count {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
        }

        .category-icon {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(5px);
            color: white;
            font-size: 1.5rem;
            z-index: 2;
        }

        /* Featured Books Section */
        .featured-section {
            padding: 100px 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.02) 0%, rgba(255, 255, 255, 0.05) 100%);
        }

        .book-card {
            border-radius: 20px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            height: 100%;
        }

        .book-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        .book-cover {
            position: relative;
            height: 300px;
            overflow: hidden;
        }

        .book-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .book-card:hover .book-cover img {
            transform: scale(1.1);
        }

        .book-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            padding: 8px 15px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            z-index: 2;
        }

        .book-content {
            padding: 20px;
        }

        .book-title {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 5px;
            color: white;
        }

        .book-author {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 15px;
        }

        .book-rating {
            margin-bottom: 15px;
        }

        .book-rating .fas {
            color: #f6c23e;
        }

        .book-btn {
            width: 100%;
            padding: 12px;
            border-radius: 50px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
        }

        .book-btn:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        /* Testimonials Section */
        .testimonials-section {
            padding: 100px 0;
        }

        .testimonial-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 30px;
            height: 100%;
            transition: all 0.3s ease;
            position: relative;
        }

        .testimonial-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .testimonial-content {
            position: relative;
            padding-top: 30px;
        }

        .testimonial-content::before {
            content: '"';
            position: absolute;
            top: -20px;
            left: -10px;
            font-size: 5rem;
            font-family: 'Georgia', serif;
            color: rgba(255, 255, 255, 0.1);
            line-height: 1;
        }

        .testimonial-text {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 20px;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
        }

        .author-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 15px;
        }

        .author-name {
            font-size: 1.1rem;
            font-weight: 700;
            color: white;
            margin: 0;
        }

        .author-title {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.6);
        }

        /* Stats Section */
        .stats-section {
            padding: 80px 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.03) 0%, rgba(255, 255, 255, 0.06) 100%);
        }

        .stat-card {
            text-align: center;
            padding: 20px;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            background: linear-gradient(45deg, #ffffff, #e0e0e0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 10px;
        }

        .stat-label {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.7);
        }

        /* CTA Section */
        .cta-section {
            padding: 100px 0;
            position: relative;
            overflow: hidden;
        }

        .cta-content {
            position: relative;
            z-index: 10;
            background: rgba(102, 126, 234, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 30px;
            padding: 60px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.1);
        }

        .cta-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: white;
            margin-bottom: 20px;
        }

        .cta-text {
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 30px;
            max-width: 700px;
        }

        .cta-btn {
            padding: 15px 40px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            background: white;
            color: #667eea;
            border: none;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .cta-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        .shape {
            position: absolute;
            z-index: 0;
        }

        .shape-1 {
            top: -50px;
            right: -50px;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.3) 0%, rgba(118, 75, 162, 0.3) 100%);
            filter: blur(50px);
        }

        .shape-2 {
            bottom: -50px;
            left: -50px;
            width: 250px;
            height: 250px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(118, 75, 162, 0.3) 0%, rgba(102, 126, 234, 0.3) 100%);
            filter: blur(50px);
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .hero-text {
                font-size: 1rem;
            }

            .feature-card,
            .testimonial-card {
                margin-bottom: 30px;
            }

            .section-title {
                font-size: 2rem;
            }

            .cta-content {
                padding: 30px;
            }

            .cta-title {
                font-size: 2rem;
            }
        }
    </style>
@endpush

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="floating-element float-1">
            <i class="fas fa-book"></i>
        </div>
        <div class="floating-element float-2">
            <i class="fas fa-graduation-cap"></i>
        </div>
        <div class="floating-element float-3">
            <i class="fas fa-lightbulb"></i>
        </div>

        <div class="container hero-content">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="hero-title">Temukan Dunia Pengetahuan Digital</h1>
                    <p class="hero-text mx-auto">
                        Akses ribuan buku digital berkualitas tinggi kapan saja dan di mana saja.
                        Dapatkan rekomendasi buku sesuai minat dan preferensi unik Anda.
                    </p>
                    <div class="d-flex flex-wrap justify-content-center gap-3">
                        <a href="{{ route('books.index') }}" class="btn btn-light hero-btn">
                            <i class="fas fa-compass me-2"></i>Jelajahi Koleksi
                        </a>
                        @guest
                            <a href="{{ route('register') }}" class="btn btn-outline-light hero-btn">
                                <i class="fas fa-user-plus me-2"></i>Bergabung Sekarang
                            </a>
                        @else
                            <a href="{{ route('user.dashboard') }}" class="btn btn-outline-light hero-btn">
                                <i class="fas fa-user me-2"></i>Dashboard Saya
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Search Section -->
    <section class="search-container">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="search-card">
                        <form action="{{ route('books.index') }}" method="GET">
                            <div class="position-relative">
                                <input type="text" name="search" class="form-control search-input"
                                    placeholder="Cari judul buku, penulis, atau kata kunci..."
                                    value="{{ request('search') }}">
                                <button type="submit" class="btn search-btn">
                                    <i class="fas fa-search me-2"></i>Cari
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Fitur Unggulan</h2>
                <p class="text-white-50 mb-0">Mengapa harus menggunakan Digital Library?</p>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <h3 class="feature-title">Pencarian Cerdas</h3>
                        <p class="feature-text">
                            Temukan buku yang Anda cari dengan cepat menggunakan fitur pencarian kami yang intuitif dan
                            powerful.
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-magic"></i>
                        </div>
                        <h3 class="feature-title">Rekomendasi Personal</h3>
                        <p class="feature-text">
                            Dapatkan rekomendasi buku yang disesuaikan dengan minat dan preferensi membaca Anda.
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-bookmark"></i>
                        </div>
                        <h3 class="feature-title">Bookmark & Progress</h3>
                        <p class="feature-text">
                            Simpan progres membaca Anda dan lanjutkan kapan saja dari perangkat manapun.
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3 class="feature-title">Analisis Membaca</h3>
                        <p class="feature-text">
                            Pantau aktivitas membaca Anda dengan statistik dan wawasan yang komprehensif.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    @if (isset($categories) && $categories->count() > 0)
        <section class="categories-section">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="section-title">Jelajahi Berdasarkan Kategori</h2>
                    <p class="text-white-50 mb-0">Temukan buku sesuai dengan minat dan passion Anda</p>
                </div>

                <div class="row g-4">
                    @foreach ($categories->take(8) as $category)
                        <div class="col-md-6 col-lg-3">
                            <a href="{{ route('books.index', ['category' => $category->id]) }}"
                                class="text-decoration-none">
                                <div class="category-card" style="background-color: {{ $category->color }};">
                                    <div class="category-icon">
                                        <i class="{{ $category->icon }}"></i>
                                    </div>
                                    <div class="category-content">
                                        <h3 class="category-title">{{ $category->name }}</h3>
                                        <p class="category-count">{{ $category->books_count }} Buku</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-5">
                    <a href="{{ route('category.preferences') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-th-large me-2"></i>Lihat Semua Kategori
                    </a>
                </div>
            </div>
        </section>
    @endif

    <!-- Featured Books Section -->
    @if (isset($featuredBooks) && $featuredBooks->count() > 0)
        <section class="featured-section">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="section-title">Buku Pilihan Editor</h2>
                    <p class="text-white-50 mb-0">Koleksi terbaik yang direkomendasikan oleh tim kami</p>
                </div>

                <div class="row g-4">
                    @foreach ($featuredBooks as $book)
                        <div class="col-md-6 col-lg-4">
                            <div class="book-card">
                                <div class="book-cover">
                                    @if ($book->cover_image)
                                        <img src="{{ asset('storage/' . $book->cover_image) }}"
                                            alt="{{ $book->title }}">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center h-100"
                                            style="background: linear-gradient(45deg, {{ $book->category->color }}, #764ba2);">
                                            <i class="fas fa-book fa-3x text-white"></i>
                                        </div>
                                    @endif
                                    <span class="book-badge bg-warning text-dark">
                                        <i class="fas fa-crown me-1"></i>Pilihan Editor
                                    </span>
                                </div>
                                <div class="book-content">
                                    <span class="badge mb-2" style="background-color: {{ $book->category->color }};">
                                        {{ $book->category->name }}
                                    </span>
                                    <h3 class="book-title">{{ Str::limit($book->title, 40) }}</h3>
                                    <p class="book-author">{{ $book->author }}</p>

                                    <div class="book-rating">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= $book->rating ? '' : 'text-muted' }}"></i>
                                        @endfor
                                        <span class="ms-2 text-white-50">{{ number_format($book->rating, 1) }}</span>
                                    </div>

                                    <a href="{{ route('books.show', $book->slug) }}" class="btn book-btn">
                                        <i class="fas fa-book-open me-2"></i>Baca Sekarang
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-5">
                    <a href="{{ route('books.index') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-books me-2"></i>Lihat Semua Buku
                    </a>
                </div>
            </div>
        </section>
    @endif

    <!-- Testimonials Section -->
    <section class="testimonials-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Apa Kata Mereka</h2>
                <p class="text-white-50 mb-0">Testimonial dari pengguna Digital Library</p>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <p class="testimonial-text">
                                "Digital Library membuat saya lebih mudah mengakses berbagai buku berkualitas.
                                Fitur rekomendasi personalnya sangat akurat dan membantu saya menemukan buku-buku menarik."
                            </p>
                            <div class="testimonial-author">
                                <div class="author-avatar">
                                    <img src="https://randomuser.me/api/portraits/women/45.jpg" alt="Sarah Johnson"
                                        class="img-fluid">
                                </div>
                                <div>
                                    <h4 class="author-name">Sarah Johnson</h4>
                                    <p class="author-title">Mahasiswa</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <p class="testimonial-text">
                                "Sebagai seorang profesional yang sibuk, Digital Library membantu saya tetap membaca
                                di tengah jadwal yang padat. Fitur bookmark dan sinkronisasi sangat berguna!"
                            </p>
                            <div class="testimonial-author">
                                <div class="author-avatar">
                                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="David Chen"
                                        class="img-fluid">
                                </div>
                                <div>
                                    <h4 class="author-name">David Chen</h4>
                                    <p class="author-title">Software Engineer</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <p class="testimonial-text">
                                "Koleksi bukunya sangat lengkap dan berkualitas. Interface-nya juga intuitif dan
                                menyenangkan untuk digunakan. Salah satu platform membaca digital terbaik!"
                            </p>
                            <div class="testimonial-author">
                                <div class="author-avatar">
                                    <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Maya Patel"
                                        class="img-fluid">
                                </div>
                                <div>
                                    <h4 class="author-name">Maya Patel</h4>
                                    <p class="author-title">Guru</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="stat-card">
                        <h3 class="stat-number">{{ number_format($totalBooks ?? 1000) }}+</h3>
                        <p class="stat-label">Buku Digital</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="stat-card">
                        <h3 class="stat-number">{{ number_format($totalUsers ?? 500) }}+</h3>
                        <p class="stat-label">Pengguna Aktif</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="stat-card">
                        <h3 class="stat-number">{{ number_format($totalCategories ?? 20) }}+</h3>
                        <p class="stat-label">Kategori</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="stat-card">
                        <h3 class="stat-number">{{ number_format($totalDownloads ?? 5000) }}+</h3>
                        <p class="stat-label">Total Bacaan</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>

        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="cta-content text-center">
                        <h2 class="cta-title">Mulai Petualangan Literasi Anda</h2>
                        <p class="cta-text mx-auto">
                            Bergabunglah dengan ribuan pembaca lain dan temukan dunia pengetahuan yang tak terbatas.
                            Daftar sekarang untuk mendapatkan akses ke ribuan buku digital berkualitas tinggi.
                        </p>
                        @guest
                            <div class="d-flex flex-wrap justify-content-center gap-3">
                                <a href="{{ route('register') }}" class="cta-btn">
                                    <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                                </a>
                                <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">
                                    <i class="fas fa-sign-in-alt me-2"></i>Masuk
                                </a>
                            </div>
                        @else
                            <a href="{{ route('books.index') }}" class="cta-btn">
                                <i class="fas fa-book-open me-2"></i>Jelajahi Koleksi
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Animate stats on scroll
        const statsSection = document.querySelector('.stats-section');
        const statNumbers = document.querySelectorAll('.stat-number');
        let animated = false;

        function animateStats() {
            if (animated) return;

            const statsTop = statsSection.getBoundingClientRect().top;
            const windowHeight = window.innerHeight;

            if (statsTop < windowHeight * 0.75) {
                statNumbers.forEach(stat => {
                    const targetNumber = parseInt(stat.textContent.replace(/,|\+/g, ''));
                    let currentNumber = 0;
                    const duration = 2000;
                    const interval = 50;
                    const increment = targetNumber / (duration / interval);

                    const counter = setInterval(() => {
                        currentNumber += increment;
                        if (currentNumber >= targetNumber) {
                            currentNumber = targetNumber;
                            clearInterval(counter);
                        }
                        stat.textContent = Math.floor(currentNumber).toLocaleString() + '+';
                    }, interval);
                });

                animated = true;
                window.removeEventListener('scroll', animateStats);
            }
        }

        window.addEventListener('scroll', animateStats);
        window.addEventListener('load', animateStats);
    </script>
@endpush
