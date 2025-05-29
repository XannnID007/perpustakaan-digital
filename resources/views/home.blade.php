@extends('layouts.app')

@section('title', 'Beranda - Digital Library')

@push('styles')
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --warning-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            --hover-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .hero-section {
            background: var(--primary-gradient);
            min-height: 70vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            opacity: 0.3;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            background: linear-gradient(45deg, #fff, #f8f9fa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .btn-hero {
            padding: 15px 30px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-hero:hover::before {
            left: 100%;
        }

        .btn-hero:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .floating-icon {
            position: absolute;
            right: 10%;
            top: 20%;
            font-size: 12rem;
            color: rgba(255, 255, 255, 0.1);
            animation: float 6s ease-in-out infinite;
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

        .search-section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            margin-top: -50px;
            position: relative;
            z-index: 10;
            box-shadow: var(--card-shadow);
        }

        .search-input {
            border: none;
            border-radius: 50px;
            padding: 20px 60px 20px 25px;
            font-size: 1.1rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .search-input:focus {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .search-btn {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: var(--primary-gradient);
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            color: white;
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }

        .search-btn:hover {
            transform: translateY(-50%) scale(1.1);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 50px;
            height: 4px;
            background: var(--secondary-gradient);
            border-radius: 2px;
        }

        .category-card {
            border: none;
            border-radius: 20px;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: var(--card-shadow);
            overflow: hidden;
            position: relative;
        }

        .category-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gradient);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .category-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--hover-shadow);
        }

        .category-card:hover::before {
            transform: scaleX(1);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            margin-bottom: 1rem;
            position: relative;
            overflow: hidden;
        }

        .feature-icon::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: inherit;
            border-radius: 50%;
            transform: scale(0);
            transition: transform 0.3s ease;
        }

        .category-card:hover .feature-icon::before {
            transform: scale(1.2);
        }

        .book-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s ease;
            background: white;
            box-shadow: var(--card-shadow);
            position: relative;
        }

        .book-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .book-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--hover-shadow);
        }

        .book-card:hover::before {
            opacity: 1;
        }

        .book-cover {
            width: 100%;
            height: 250px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .book-card:hover .book-cover {
            transform: scale(1.05);
        }

        .badge-custom {
            background: var(--secondary-gradient);
            border: none;
            border-radius: 20px;
            padding: 8px 15px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .category-chip {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .rating .fa-star {
            transition: all 0.2s ease;
        }

        .rating:hover .fa-star {
            transform: scale(1.2);
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.5s;
        }

        .stat-card:hover::before {
            left: 100%;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            background: linear-gradient(45deg, #fff, #f8f9fa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .section-bg-alternate {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
            backdrop-filter: blur(20px);
        }

        .btn-outline-elegant {
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            background: transparent;
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-outline-elegant:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
            color: white;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .floating-icon {
                font-size: 8rem;
                right: 5%;
            }

            .section-title {
                font-size: 2rem;
            }
        }
    </style>
@endpush

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="floating-icon">
            <i class="fas fa-book-open"></i>
        </div>
        <div class="container hero-content">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="hero-title">
                        Jelajahi Dunia Pengetahuan
                    </h1>
                    <p class="hero-subtitle">
                        Temukan ribuan buku digital berkualitas tinggi. Dapatkan rekomendasi personal yang disesuaikan
                        dengan minat dan preferensi unik Anda.
                    </p>
                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        <a href="{{ route('books.index') }}" class="btn btn-light btn-hero">
                            <i class="fas fa-compass me-2"></i>Mulai Jelajahi
                        </a>
                        @guest
                            <a href="{{ route('category.preferences') }}" class="btn btn-outline-elegant btn-hero">
                                <i class="fas fa-heart me-2"></i>Atur Preferensi
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Search Section -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="search-section p-4">
                        <form action="{{ route('books.index') }}" method="GET" class="position-relative">
                            <input type="text" name="search" class="form-control search-input"
                                placeholder="Cari judul buku, penulis, genre, atau kata kunci..."
                                value="{{ request('search') }}">
                            <button type="submit" class="search-btn">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    @if ($categories->count() > 0)
        <section class="py-5">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="section-title text-white">Kategori Pilihan</h2>
                    <p class="text-white-50 fs-5">Temukan buku sesuai minat dan passion Anda</p>
                </div>

                <div class="row g-4">
                    @foreach ($categories as $category)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <a href="{{ route('books.index', ['category' => $category->id]) }}"
                                class="text-decoration-none">
                                <div class="card category-card h-100 text-center">
                                    <div class="card-body p-4">
                                        <div class="feature-icon mx-auto"
                                            style="background: {{ $category->color ?? 'var(--primary-gradient)' }};">
                                            <i class="{{ $category->icon ?? 'fas fa-book' }}"></i>
                                        </div>
                                        <h5 class="card-title fw-bold mb-2">{{ $category->name }}</h5>
                                        <p class="card-text text-muted mb-2">
                                            <i class="fas fa-book-open me-1"></i>{{ $category->books_count }} Buku
                                        </p>
                                        @if ($category->description)
                                            <p class="card-text small text-muted">
                                                {{ Str::limit($category->description, 60) }}</p>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-5">
                    <a href="{{ route('category.preferences') }}" class="btn btn-outline-elegant btn-lg">
                        <i class="fas fa-sliders-h me-2"></i>Personalisasi Preferensi
                    </a>
                </div>
            </div>
        </section>
    @endif

    <!-- Recommendations Section -->
    @auth
        @if ($recommendations->count() > 0)
            <section class="py-5 section-bg-alternate">
                <div class="container">
                    <div class="text-center mb-5">
                        <h2 class="section-title text-white">
                            <i class="fas fa-magic me-3"></i>Rekomendasi Khusus
                        </h2>
                        <p class="text-white-50 fs-5">Dipilih berdasarkan aktivitas dan preferensi baca Anda</p>
                    </div>

                    <div class="row g-4">
                        @foreach ($recommendations as $book)
                            <div class="col-lg-4 col-md-6">
                                <div class="card book-card h-100">
                                    <div class="position-relative overflow-hidden">
                                        @if ($book->cover_image)
                                            <img src="{{ Storage::url($book->cover_image) }}" class="book-cover"
                                                alt="{{ $book->title }}">
                                        @else
                                            <div class="book-cover d-flex align-items-center justify-content-center"
                                                style="background: var(--primary-gradient);">
                                                <i class="fas fa-book text-white" style="font-size: 4rem;"></i>
                                            </div>
                                        @endif
                                        <div class="position-absolute top-0 end-0 m-3">
                                            <span class="badge badge-custom">
                                                <i class="fas fa-star me-1"></i>Rekomendasi
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="category-chip"
                                                style="background-color: {{ $book->category->color }}20; color: {{ $book->category->color }};">
                                                {{ $book->category->name }}
                                            </span>
                                            <div class="text-muted small">
                                                <i class="fas fa-eye me-1"></i>{{ number_format($book->views) }}
                                            </div>
                                        </div>
                                        <h5 class="card-title fw-bold mb-3">
                                            <a href="{{ route('books.show', $book->slug) }}"
                                                class="text-decoration-none text-dark">
                                                {{ Str::limit($book->title, 45) }}
                                            </a>
                                        </h5>
                                        <p class="card-text text-muted mb-2">
                                            <i class="fas fa-user me-2"></i>{{ $book->author }}
                                        </p>
                                        <p class="card-text small mb-3">{{ Str::limit($book->description, 90) }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="rating">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i
                                                        class="fas fa-star {{ $i <= $book->rating ? 'text-warning' : 'text-muted' }}"></i>
                                                @endfor
                                                <small class="text-muted ms-2">({{ number_format($book->rating, 1) }})</small>
                                            </div>
                                            <a href="{{ route('books.show', $book->slug) }}"
                                                class="btn btn-primary btn-sm rounded-pill px-3">
                                                <i class="fas fa-book-reader me-1"></i>Baca
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    @endauth

    <!-- Featured Books Section -->
    @if ($featuredBooks->count() > 0)
        <section class="py-5">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="section-title text-white">
                        <i class="fas fa-crown me-3"></i>Buku Pilihan Editor
                    </h2>
                    <p class="text-white-50 fs-5">Koleksi terbaik yang dipilih khusus untuk Anda</p>
                </div>

                <div class="row g-4">
                    @foreach ($featuredBooks as $book)
                        <div class="col-lg-4 col-md-6">
                            <div class="card book-card h-100">
                                <div class="position-relative overflow-hidden">
                                    @if ($book->cover_image)
                                        <img src="{{ Storage::url($book->cover_image) }}" class="book-cover"
                                            alt="{{ $book->title }}">
                                    @else
                                        <div class="book-cover d-flex align-items-center justify-content-center"
                                            style="background: var(--warning-gradient);">
                                            <i class="fas fa-book text-white" style="font-size: 4rem;"></i>
                                        </div>
                                    @endif
                                    <div class="position-absolute top-0 start-0 m-3">
                                        <span class="badge bg-warning text-dark fw-bold">
                                            <i class="fas fa-crown me-1"></i>Pilihan Editor
                                        </span>
                                    </div>
                                </div>
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="category-chip"
                                            style="background-color: {{ $book->category->color }}20; color: {{ $book->category->color }};">
                                            {{ $book->category->name }}
                                        </span>
                                        <div class="text-muted small">
                                            <i class="fas fa-eye me-1"></i>{{ number_format($book->views) }}
                                        </div>
                                    </div>
                                    <h5 class="card-title fw-bold mb-3">
                                        <a href="{{ route('books.show', $book->slug) }}"
                                            class="text-decoration-none text-dark">
                                            {{ Str::limit($book->title, 45) }}
                                        </a>
                                    </h5>
                                    <p class="card-text text-muted mb-2">
                                        <i class="fas fa-user me-2"></i>{{ $book->author }}
                                    </p>
                                    <p class="card-text small mb-3">{{ Str::limit($book->description, 90) }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="rating">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i
                                                    class="fas fa-star {{ $i <= $book->rating ? 'text-warning' : 'text-muted' }}"></i>
                                            @endfor
                                            <small class="text-muted ms-2">({{ number_format($book->rating, 1) }})</small>
                                        </div>
                                        <a href="{{ route('books.show', $book->slug) }}"
                                            class="btn btn-primary btn-sm rounded-pill px-3">
                                            <i class="fas fa-book-reader me-1"></i>Baca
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Popular Books Section -->
    @if ($popularBooks->count() > 0)
        <section class="py-5 section-bg-alternate">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="section-title text-white">
                        <i class="fas fa-fire me-3"></i>Trending Sekarang
                    </h2>
                    <p class="text-white-50 fs-5">Buku yang sedang populer di kalangan pembaca</p>
                </div>

                <div class="row g-4">
                    @foreach ($popularBooks as $index => $book)
                        <div class="col-lg-3 col-md-6">
                            <div class="card book-card h-100">
                                <div class="position-absolute top-0 start-0 m-3" style="z-index: 10;">
                                    <span class="badge bg-danger fw-bold fs-6">
                                        #{{ $index + 1 }}
                                    </span>
                                </div>

                                <div class="position-relative overflow-hidden">
                                    @if ($book->cover_image)
                                        <img src="{{ Storage::url($book->cover_image) }}" class="book-cover"
                                            alt="{{ $book->title }}">
                                    @else
                                        <div class="book-cover d-flex align-items-center justify-content-center"
                                            style="background: var(--secondary-gradient);">
                                            <i class="fas fa-book text-white" style="font-size: 3rem;"></i>
                                        </div>
                                    @endif
                                </div>

                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="category-chip small"
                                            style="background-color: {{ $book->category->color }}20; color: {{ $book->category->color }};">
                                            {{ $book->category->name }}
                                        </span>
                                        <div class="text-muted small">
                                            <i class="fas fa-fire me-1 text-danger"></i>{{ number_format($book->views) }}
                                        </div>
                                    </div>

                                    <h6 class="card-title fw-bold mb-2">
                                        <a href="{{ route('books.show', $book->slug) }}"
                                            class="text-decoration-none text-dark">
                                            {{ Str::limit($book->title, 35) }}
                                        </a>
                                    </h6>

                                    <p class="card-text text-muted small mb-3">
                                        <i class="fas fa-user me-1"></i>{{ $book->author }}
                                    </p>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="rating">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $book->rating ? 'text-warning' : 'text-muted' }}"
                                                    style="font-size: 0.9rem;"></i>
                                            @endfor
                                        </div>
                                        <a href="{{ route('books.show', $book->slug) }}"
                                            class="btn btn-primary btn-sm rounded-pill px-3">
                                            Baca
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Statistics Section -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title text-white">Statistik Platform</h2>
                <p class="text-white-50 fs-5">Pencapaian dan perkembangan perpustakaan digital kami</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="card stat-card text-white h-100 text-center p-4">
                        <div class="feature-icon mx-auto mb-3" style="background: var(--primary-gradient);">
                            <i class="fas fa-book"></i>
                        </div>
                        <h3 class="stat-number">{{ number_format($totalBooks ?? 0) }}</h3>
                        <p class="mb-0 text-white-50 fw-semibold">Total Koleksi Buku</p>
                        <small class="text-white-50">Terus bertambah setiap hari</small>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card stat-card text-white h-100 text-center p-4">
                        <div class="feature-icon mx-auto mb-3" style="background: var(--success-gradient);">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="stat-number">{{ number_format($totalUsers ?? 0) }}</h3>
                        <p class="mb-0 text-white-50 fw-semibold">Pembaca Aktif</p>
                        <small class="text-white-50">Komunitas yang terus berkembang</small>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card stat-card text-white h-100 text-center p-4">
                        <div class="feature-icon mx-auto mb-3" style="background: var(--warning-gradient);">
                            <i class="fas fa-list"></i>
                        </div>
                        <h3 class="stat-number">{{ number_format($totalCategories ?? 0) }}</h3>
                        <p class="mb-0 text-white-50 fw-semibold">Kategori Beragam</p>
                        <small class="text-white-50">Dari berbagai bidang ilmu</small>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card stat-card text-white h-100 text-center p-4">
                        <div class="feature-icon mx-auto mb-3" style="background: var(--secondary-gradient);">
                            <i class="fas fa-download"></i>
                        </div>
                        <h3 class="stat-number">{{ number_format($totalDownloads ?? 0) }}</h3>
                        <p class="mb-0 text-white-50 fw-semibold">Total Unduhan</p>
                        <small class="text-white-50">Akses mudah kapan saja</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="py-5 section-bg-alternate">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <div class="p-5">
                        <div class="feature-icon mx-auto mb-4"
                            style="background: var(--primary-gradient); width: 100px; height: 100px; font-size: 2.5rem;">
                            <i class="fas fa-rocket"></i>
                        </div>
                        <h2 class="section-title text-white mb-4">Mulai Petualangan Literasi Anda</h2>
                        <p class="text-white-50 fs-5 mb-4">
                            Bergabunglah dengan ribuan pembaca lainnya dan temukan buku-buku luar biasa yang akan memperluas
                            wawasan dan menghibur Anda.
                        </p>
                        <div class="d-flex gap-3 justify-content-center flex-wrap">
                            @guest
                                <a href="{{ route('register') }}" class="btn btn-light btn-hero">
                                    <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                                </a>
                                <a href="{{ route('login') }}" class="btn btn-outline-elegant btn-hero">
                                    <i class="fas fa-sign-in-alt me-2"></i>Masuk
                                </a>
                            @else
                                <a href="{{ route('books.index') }}" class="btn btn-light btn-hero">
                                    <i class="fas fa-compass me-2"></i>Jelajahi Sekarang
                                </a>
                                <a href="{{ route('user.dashboard') }}" class="btn btn-outline-elegant btn-hero">
                                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard Saya
                                </a>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="text-center">
                        <div class="feature-icon mx-auto mb-4"
                            style="background: var(--warning-gradient); width: 80px; height: 80px;">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h3 class="text-white fw-bold mb-3">Tetap Update dengan Koleksi Terbaru</h3>
                        <p class="text-white-50 mb-4">
                            Dapatkan notifikasi buku-buku baru, rekomendasi khusus, dan berita terkini dari perpustakaan
                            digital kami.
                        </p>
                        <form class="d-flex gap-2 justify-content-center">
                            <input type="email" class="form-control rounded-pill px-4"
                                placeholder="Masukkan email Anda" style="max-width: 300px;">
                            <button type="submit" class="btn btn-primary rounded-pill px-4">
                                <i class="fas fa-paper-plane me-1"></i>Berlangganan
                            </button>
                        </form>
                        <small class="text-white-50 mt-2 d-block">
                            <i class="fas fa-shield-alt me-1"></i>Kami menghormati privasi Anda dan tidak akan mengirim
                            spam
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        // Smooth scrolling untuk anchor links
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

        // Parallax effect untuk floating icon
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const rate = scrolled * -0.5;
            const icon = document.querySelector('.floating-icon');
            if (icon) {
                icon.style.transform = `translateY(${rate}px) rotate(${scrolled * 0.1}deg)`;
            }
        });

        // Animate statistics numbers on scroll
        const observerOptions = {
            threshold: 0.5,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const numberElement = entry.target.querySelector('.stat-number');
                    if (numberElement && !numberElement.classList.contains('animated')) {
                        animateNumber(numberElement);
                        numberElement.classList.add('animated');
                    }
                }
            });
        }, observerOptions);

        document.querySelectorAll('.stat-card').forEach(card => {
            observer.observe(card);
        });

        function animateNumber(element) {
            const finalNumber = parseInt(element.textContent.replace(/,/g, ''));
            const duration = 2000;
            const steps = 60;
            const increment = finalNumber / steps;
            let current = 0;

            const timer = setInterval(() => {
                current += increment;
                if (current >= finalNumber) {
                    current = finalNumber;
                    clearInterval(timer);
                }
                element.textContent = Math.floor(current).toLocaleString();
            }, duration / steps);
        }

        // Enhanced hover effects for book cards
        document.querySelectorAll('.book-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-10px) scale(1.02)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Search input focus enhancement
        const searchInput = document.querySelector('.search-input');
        if (searchInput) {
            searchInput.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });

            searchInput.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        }
    </script>
@endpush
