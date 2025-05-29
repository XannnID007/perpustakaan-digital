@extends('layouts.app')

@section('title', 'Dashboard - Digital Library')

@section('content')
    <!-- Welcome Header -->
    <section class="welcome-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="welcome-content">
                        <div class="greeting">
                            <h1 class="welcome-title">
                                Selamat datang kembali, <span class="user-name">{{ Auth::user()->name }}</span>! 👋
                            </h1>
                            <p class="welcome-subtitle">
                                @php
                                    $hour = date('H');
                                    $greeting =
                                        $hour < 12 ? 'Selamat pagi' : ($hour < 17 ? 'Selamat siang' : 'Selamat malam');
                                @endphp
                                {{ $greeting }}! Mari lanjutkan petualangan literasi Anda hari ini.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="user-avatar-section">
                        <div class="user-avatar">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&size=120&background=6366f1&color=ffffff&bold=true"
                                alt="{{ Auth::user()->name }}" class="avatar-img">
                            <div class="avatar-status">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                        <div class="user-info">
                            <h4 class="user-name-display">{{ Auth::user()->name }}</h4>
                            <p class="user-role">Pembaca Aktif</p>
                            <div class="user-level">
                                <div class="level-badge">
                                    <i class="fas fa-star me-1"></i>
                                    Level {{ min(floor($stats['total_reading_time'] / 60) + 1, 10) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Cards -->
    <section class="stats-section">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-card reading-time">
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ $stats['total_reading_time'] }}</div>
                        <div class="stat-label">Menit Membaca</div>
                        <div class="stat-progress">
                            <div class="progress-bar"
                                style="width: {{ min(($stats['total_reading_time'] / 500) * 100, 100) }}%"></div>
                        </div>
                        <div class="stat-subtitle">Target: 500 menit</div>
                    </div>
                </div>

                <div class="stat-card bookmarks">
                    <div class="stat-icon">
                        <i class="fas fa-bookmark"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ $stats['total_bookmarks'] }}</div>
                        <div class="stat-label">Buku Tersimpan</div>
                        <div class="stat-trend">
                            <i class="fas fa-arrow-up"></i>
                            <span>+{{ $stats['total_bookmarks'] > 5 ? rand(1, 3) : 0 }} minggu ini</span>
                        </div>
                    </div>
                    <a href="{{ route('user.bookmarks') }}" class="stat-action">
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

                <div class="stat-card books-read">
                    <div class="stat-icon">
                        <i class="fas fa-book-reader"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ $stats['total_reading_history'] }}</div>
                        <div class="stat-label">Buku Dibaca</div>
                        <div class="stat-subtitle">{{ $stats['categories_read'] }} kategori berbeda</div>
                    </div>
                    <a href="{{ route('user.reading-history') }}" class="stat-action">
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

                <div class="stat-card achievements">
                    <div class="stat-icon">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ min(floor($stats['total_reading_time'] / 60) + 1, 10) }}</div>
                        <div class="stat-label">Pencapaian</div>
                        <div class="achievement-badges">
                            @if ($stats['total_reading_time'] > 60)
                                <span class="badge">📚 Pemula</span>
                            @endif
                            @if ($stats['total_bookmarks'] > 5)
                                <span class="badge">🔖 Kolektor</span>
                            @endif
                            @if ($stats['total_reading_history'] > 10)
                                <span class="badge">🏆 Rajin Baca</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Actions -->
    <section class="quick-actions-section">
        <div class="container">
            <div class="section-header">
                <h3 class="section-title">
                    <i class="fas fa-bolt me-2"></i>Aksi Cepat
                </h3>
            </div>

            <div class="quick-actions-grid">
                <a href="{{ route('books.index') }}" class="action-card explore">
                    <div class="action-icon">
                        <i class="fas fa-compass"></i>
                    </div>
                    <div class="action-content">
                        <h4 class="action-title">Jelajahi Buku</h4>
                        <p class="action-description">Temukan buku baru yang menarik</p>
                    </div>
                    <div class="action-arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </a>

                <a href="{{ route('category.preferences') }}" class="action-card preferences">
                    <div class="action-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <div class="action-content">
                        <h4 class="action-title">Atur Preferensi</h4>
                        <p class="action-description">Personalisasi rekomendasi Anda</p>
                    </div>
                    <div class="action-arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </a>

                <a href="{{ route('user.bookmarks') }}" class="action-card bookmarks-action">
                    <div class="action-icon">
                        <i class="fas fa-bookmark"></i>
                    </div>
                    <div class="action-content">
                        <h4 class="action-title">Lihat Bookmark</h4>
                        <p class="action-description">{{ $stats['total_bookmarks'] }} buku tersimpan</p>
                    </div>
                    <div class="action-arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </a>

                <a href="{{ route('user.reading-history') }}" class="action-card history">
                    <div class="action-icon">
                        <i class="fas fa-history"></i>
                    </div>
                    <div class="action-content">
                        <h4 class="action-title">Riwayat Baca</h4>
                        <p class="action-description">Lanjutkan bacaan terakhir</p>
                    </div>
                    <div class="action-arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- Recent Activity -->
    <section class="activity-section">
        <div class="container">
            <div class="row g-4">
                <!-- Bookmarks Section -->
                <div class="col-lg-6">
                    <div class="activity-card">
                        <div class="activity-header">
                            <h4 class="activity-title">
                                <i class="fas fa-bookmark me-2"></i>Bookmark Terbaru
                            </h4>
                            <a href="{{ route('user.bookmarks') }}" class="view-all-link">
                                Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>

                        <div class="activity-content">
                            @if (count($bookmarks) > 0)
                                <div class="books-list">
                                    @foreach ($bookmarks->take(4) as $bookmark)
                                        <div class="book-list-item">
                                            <div class="book-cover-small">
                                                @if ($bookmark->book->cover_image)
                                                    <img src="{{ asset('storage/' . $bookmark->book->cover_image) }}"
                                                        alt="{{ $bookmark->book->title }}">
                                                @else
                                                    <div class="cover-placeholder">
                                                        <i class="fas fa-book"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="book-info">
                                                <h5 class="book-title">{{ Str::limit($bookmark->book->title, 30) }}</h5>
                                                <p class="book-author">{{ $bookmark->book->author }}</p>
                                                <div class="book-meta">
                                                    <span class="category-tag"
                                                        style="background-color: {{ $bookmark->book->category->color }}20; color: {{ $bookmark->book->category->color }};">
                                                        {{ $bookmark->book->category->name }}
                                                    </span>
                                                    <span class="reading-progress">
                                                        {{ round(($bookmark->last_page / $bookmark->book->pages) * 100) }}%
                                                        selesai
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="book-actions">
                                                <a href="{{ route('books.read', ['slug' => $bookmark->book->slug, 'page' => $bookmark->last_page]) }}"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="fas fa-play"></i>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="empty-state-small">
                                    <i class="fas fa-bookmark fa-2x mb-2"></i>
                                    <p>Belum ada bookmark</p>
                                    <a href="{{ route('books.index') }}" class="btn btn-outline-primary btn-sm">
                                        Jelajahi Buku
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Reading History Section -->
                <div class="col-lg-6">
                    <div class="activity-card">
                        <div class="activity-header">
                            <h4 class="activity-title">
                                <i class="fas fa-history me-2"></i>Bacaan Terakhir
                            </h4>
                            <a href="{{ route('user.reading-history') }}" class="view-all-link">
                                Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>

                        <div class="activity-content">
                            @if (count($recentReading) > 0)
                                <div class="books-list">
                                    @foreach ($recentReading->take(4) as $history)
                                        <div class="book-list-item">
                                            <div class="book-cover-small">
                                                @if ($history->book->cover_image)
                                                    <img src="{{ asset('storage/' . $history->book->cover_image) }}"
                                                        alt="{{ $history->book->title }}">
                                                @else
                                                    <div class="cover-placeholder">
                                                        <i class="fas fa-book"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="book-info">
                                                <h5 class="book-title">{{ Str::limit($history->book->title, 30) }}</h5>
                                                <p class="book-author">{{ $history->book->author }}</p>
                                                <div class="book-meta">
                                                    <span class="reading-time">
                                                        <i class="fas fa-clock me-1"></i>
                                                        {{ $history->total_reading_time }} menit
                                                    </span>
                                                    <span class="last-read">
                                                        {{ $history->last_read_at->diffForHumans() }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="book-actions">
                                                <a href="{{ route('books.read', ['slug' => $history->book->slug, 'page' => $history->last_page]) }}"
                                                    class="btn btn-sm btn-success">
                                                    <i class="fas fa-play"></i>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="empty-state-small">
                                    <i class="fas fa-book-reader fa-2x mb-2"></i>
                                    <p>Belum ada riwayat bacaan</p>
                                    <a href="{{ route('books.index') }}" class="btn btn-outline-success btn-sm">
                                        Mulai Membaca
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Reading Goals -->
    <section class="goals-section">
        <div class="container">
            <div class="goals-card">
                <div class="goals-header">
                    <div class="goals-icon">
                        <i class="fas fa-target"></i>
                    </div>
                    <div class="goals-content">
                        <h3 class="goals-title">Target Membaca Bulanan</h3>
                        <p class="goals-subtitle">Tetap konsisten dengan target harian Anda</p>
                    </div>
                </div>

                <div class="goals-progress">
                    <div class="progress-circle">
                        <div class="progress-ring">
                            <div class="progress-fill"
                                style="--progress: {{ min(($stats['total_reading_time'] / 1200) * 100, 100) }}%"></div>
                            <div class="progress-center">
                                <div class="progress-percentage">
                                    {{ round(min(($stats['total_reading_time'] / 1200) * 100, 100)) }}%</div>
                                <div class="progress-label">Tercapai</div>
                            </div>
                        </div>
                    </div>

                    <div class="goals-stats">
                        <div class="goal-stat">
                            <div class="stat-value">{{ $stats['total_reading_time'] }}</div>
                            <div class="stat-name">Menit Terbaca</div>
                        </div>
                        <div class="goal-stat">
                            <div class="stat-value">1200</div>
                            <div class="stat-name">Target Bulanan</div>
                        </div>
                        <div class="goal-stat">
                            <div class="stat-value">{{ max(0, 1200 - $stats['total_reading_time']) }}</div>
                            <div class="stat-name">Tersisa</div>
                        </div>
                    </div>
                </div>

                @if ($stats['total_reading_time'] < 1200)
                    <div class="goals-motivation">
                        <p class="motivation-text">
                            <i class="fas fa-fire me-2"></i>
                            Anda hampir mencapai target! Baca {{ max(0, 1200 - $stats['total_reading_time']) }} menit lagi
                            untuk menyelesaikan target bulan ini.
                        </p>
                        <a href="{{ route('books.index') }}" class="btn btn-primary">
                            <i class="fas fa-rocket me-2"></i>Lanjutkan Membaca
                        </a>
                    </div>
                @else
                    <div class="goals-celebration">
                        <p class="celebration-text">
                            <i class="fas fa-trophy me-2"></i>
                            Selamat! Anda telah mencapai target membaca bulan ini! 🎉
                        </p>
                        <a href="{{ route('books.index') }}" class="btn btn-success">
                            <i class="fas fa-star me-2"></i>Terus Membaca
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        .welcome-header {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            padding: 6rem 0 4rem;
            margin-top: -100px;
            padding-top: 200px;
            position: relative;
            overflow: hidden;
        }

        .welcome-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="welcome-pattern" width="30" height="30" patternUnits="userSpaceOnUse"><circle cx="15" cy="15" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23welcome-pattern)"/></svg>');
            animation: float 40s ease-in-out infinite;
        }

        .welcome-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .user-name {
            background: linear-gradient(45deg, #ffffff, #f1f5f9);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .welcome-subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
            margin: 0;
        }

        .user-avatar-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            position: relative;
            z-index: 2;
        }

        .user-avatar {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .avatar-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .avatar-status {
            position: absolute;
            bottom: 5px;
            right: 5px;
            width: 30px;
            height: 30px;
            background: #10b981;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            border: 3px solid white;
        }

        .user-name-display {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .user-role {
            opacity: 0.8;
            margin-bottom: 1rem;
        }

        .level-badge {
            background: rgba(255, 255, 255, 0.2);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .stats-section {
            margin-top: -80px;
            position: relative;
            z-index: 10;
            padding-bottom: 4rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 25px;
            padding: 2.5rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            transition: all 0.4s ease;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, transparent, rgba(255, 255, 255, 0.1));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.15);
        }

        .stat-card:hover::before {
            opacity: 1;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            color: white;
        }

        .reading-time .stat-icon {
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }

        .bookmarks .stat-icon {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        }

        .books-read .stat-icon {
            background: linear-gradient(135deg, #10b981, #059669);
        }

        .achievements .stat-icon {
            background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            color: var(--gray-800);
            line-height: 1;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 1rem;
        }

        .stat-progress {
            width: 100%;
            height: 6px;
            background: var(--gray-200);
            border-radius: 3px;
            overflow: hidden;
            margin-bottom: 0.5rem;
        }

        .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #f59e0b, #d97706);
            border-radius: 3px;
            transition: width 1s ease;
        }

        .stat-subtitle,
        .stat-trend {
            font-size: 0.9rem;
            color: var(--gray-600);
        }

        .stat-trend {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            color: #10b981;
        }

        .stat-action {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray-600);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .stat-action:hover {
            background: var(--primary-color);
            color: white;
            transform: scale(1.1);
        }

        .achievement-badges {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .achievement-badges .badge {
            background: var(--gray-100);
            color: var(--gray-700);
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .quick-actions-section {
            padding: 4rem 0;
        }

        .section-header {
            margin-bottom: 3rem;
            text-align: center;
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 600;
            color: var(--gray-800);
        }

        .quick-actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
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
            border: 2px solid var(--gray-200);
            text-decoration: none;
            color: inherit;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .action-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.5s ease;
        }

        .action-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            border-color: var(--primary-color);
            text-decoration: none;
            color: inherit;
        }

        .action-card:hover::before {
            left: 100%;
        }

        .action-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            flex-shrink: 0;
        }

        .explore .action-icon {
            background: linear-gradient(135deg, #06b6d4, #0891b2);
        }

        .preferences .action-icon {
            background: linear-gradient(135deg, #ec4899, #db2777);
        }

        .bookmarks-action .action-icon {
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }

        .history .action-icon {
            background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        }

        .action-content {
            flex-grow: 1;
        }

        .action-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 0.5rem;
        }

        .action-description {
            color: var(--gray-600);
            font-size: 0.9rem;
            margin: 0;
        }

        .action-arrow {
            color: var(--gray-400);
            transition: all 0.3s ease;
        }

        .action-card:hover .action-arrow {
            color: var(--primary-color);
            transform: translateX(5px);
        }

        .activity-section {
            padding: 4rem 0;
            background: var(--gray-50);
        }

        .activity-card {
            background: white;
            border-radius: 25px;
            padding: 2rem;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--gray-200);
            height: 100%;
        }

        .activity-header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--gray-100);
        }

        .activity-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--gray-800);
            margin: 0;
        }

        .view-all-link:hover {
            color: var(--accent-color);
            text-decoration: underline;
        }

        .activity-content {
            min-height: 300px;
        }

        .books-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .book-list-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: var(--gray-50);
            border-radius: 15px;
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }

        .book-list-item:hover {
            background: white;
            border-color: var(--primary-color);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .book-cover-small {
            width: 50px;
            height: 65px;
            border-radius: 8px;
            overflow: hidden;
            flex-shrink: 0;
            position: relative;
        }

        .book-cover-small img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .cover-placeholder {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }

        .book-info {
            flex-grow: 1;
            min-width: 0;
        }

        .book-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 0.25rem;
            line-height: 1.3;
        }

        .book-author {
            font-size: 0.9rem;
            color: var(--gray-600);
            margin-bottom: 0.5rem;
        }

        .book-meta {
            display: flex;
            gap: 0.75rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .category-tag {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 10px;
            font-weight: 500;
        }

        .reading-progress,
        .reading-time,
        .last-read {
            font-size: 0.8rem;
            color: var(--gray-500);
            display: flex;
            align-items: center;
        }

        .book-actions {
            display: flex;
            gap: 0.5rem;
            flex-shrink: 0;
        }

        .book-actions .btn {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
        }

        .empty-state-small {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 3rem 1rem;
            color: var(--gray-500);
        }

        .empty-state-small i {
            color: var(--gray-300);
            margin-bottom: 1rem;
        }

        .empty-state-small p {
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .goals-section {
            padding: 4rem 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            position: relative;
            overflow: hidden;
        }

        .goals-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="goals-pattern" width="40" height="40" patternUnits="userSpaceOnUse"><circle cx="20" cy="20" r="2" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23goals-pattern)"/></svg>');
            animation: float 50s ease-in-out infinite reverse;
        }

        .goals-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-radius: 30px;
            padding: 3rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            z-index: 2;
        }

        .goals-header {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .goals-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
        }

        .goals-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .goals-subtitle {
            opacity: 0.8;
            font-size: 1.1rem;
        }

        .goals-progress {
            display: flex;
            align-items: center;
            gap: 3rem;
            margin-bottom: 2rem;
        }

        .progress-circle {
            position: relative;
            width: 180px;
            height: 180px;
            flex-shrink: 0;
        }

        .progress-ring {
            width: 100%;
            height: 100%;
            position: relative;
            border-radius: 50%;
            background: conic-gradient(from 0deg,
                    #10b981 0deg,
                    #10b981 var(--progress, 0%),
                    rgba(255, 255, 255, 0.2) var(--progress, 0%),
                    rgba(255, 255, 255, 0.2) 360deg);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .progress-ring::before {
            content: '';
            position: absolute;
            width: calc(100% - 20px);
            height: calc(100% - 20px);
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .progress-center {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .progress-percentage {
            font-size: 2.5rem;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 0.25rem;
        }

        .progress-label {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        .goals-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            flex-grow: 1;
        }

        .goal-stat {
            text-align: center;
            padding: 1.5rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stat-name {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        .goals-motivation,
        .goals-celebration {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .motivation-text,
        .celebration-text {
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .goals-motivation .btn,
        .goals-celebration .btn {
            padding: 0.75rem 2rem;
            font-weight: 600;
            border-radius: 25px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Animations */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            33% {
                transform: translateY(-10px) rotate(1deg);
            }

            66% {
                transform: translateY(10px) rotate(-1deg);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            }

            .goals-progress {
                flex-direction: column;
                gap: 2rem;
            }

            .progress-circle {
                width: 150px;
                height: 150px;
            }
        }

        @media (max-width: 768px) {
            .welcome-header {
                padding: 4rem 0 2rem;
                margin-top: -80px;
                padding-top: 150px;
            }

            .welcome-title {
                font-size: 2rem;
            }

            .user-avatar-section {
                margin-top: 2rem;
            }

            .avatar-img {
                width: 80px;
                height: 80px;
            }

            .stats-section {
                margin-top: -40px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .stat-card {
                padding: 2rem;
            }

            .stat-number {
                font-size: 2.5rem;
            }

            .quick-actions-grid {
                grid-template-columns: 1fr;
            }

            .action-card {
                padding: 1.5rem;
            }

            .goals-card {
                padding: 2rem;
            }

            .goals-header {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .goals-title {
                font-size: 1.5rem;
            }

            .goals-stats {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .progress-circle {
                width: 120px;
                height: 120px;
            }

            .progress-percentage {
                font-size: 2rem;
            }
        }

        @media (max-width: 576px) {
            .welcome-title {
                font-size: 1.5rem;
            }

            .section-title {
                font-size: 2rem;
            }

            .book-list-item {
                padding: 0.75rem;
            }

            .book-cover-small {
                width: 40px;
                height: 50px;
            }

            .book-title {
                font-size: 0.9rem;
            }

            .book-author {
                font-size: 0.8rem;
            }

            .book-meta {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
        }

        /* Loading animations for stats */
        .stat-card {
            animation: fadeInUp 0.6s ease forwards;
        }

        .stat-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .stat-card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .stat-card:nth-child(3) {
            animation-delay: 0.3s;
        }

        .stat-card:nth-child(4) {
            animation-delay: 0.4s;
        }

        /* Hover effects for interactive elements */
        .book-list-item {
            position: relative;
            overflow: hidden;
        }

        .book-list-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(99, 102, 241, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .book-list-item:hover::before {
            left: 100%;
        }

        /* Smooth scrolling for the entire page */
        html {
            scroll-behavior: smooth;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--gray-100);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--accent-color);
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animate progress bars on page load
            const progressBars = document.querySelectorAll('.progress-bar');
            progressBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0%';
                setTimeout(() => {
                    bar.style.width = width;
                }, 500);
            });

            // Animate stat numbers counting up
            const statNumbers = document.querySelectorAll('.stat-number');
            statNumbers.forEach(stat => {
                const finalValue = parseInt(stat.textContent);
                let currentValue = 0;
                const increment = finalValue / 50;
                const timer = setInterval(() => {
                    currentValue += increment;
                    if (currentValue >= finalValue) {
                        currentValue = finalValue;
                        clearInterval(timer);
                    }
                    stat.textContent = Math.floor(currentValue);
                }, 30);
            });

            // Add smooth reveal animation for cards
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            });

            document.querySelectorAll('.activity-card, .goals-card').forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(card);
            });

            // Greeting update based on time
            function updateGreeting() {
                const hour = new Date().getHours();
                const greetingElement = document.querySelector('.welcome-subtitle');
                let greeting;

                if (hour < 12) {
                    greeting = 'Selamat pagi';
                } else if (hour < 17) {
                    greeting = 'Selamat siang';
                } else {
                    greeting = 'Selamat malam';
                }

                if (greetingElement) {
                    greetingElement.innerHTML = greeting + '! Mari lanjutkan petualangan literasi Anda hari ini.';
                }
            }

            updateGreeting();

            // Add ripple effect to action cards
            document.querySelectorAll('.action-card').forEach(card => {
                card.addEventListener('click', function(e) {
                    const ripple = document.createElement('span');
                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;

                    ripple.style.width = ripple.style.height = size + 'px';
                    ripple.style.left = x + 'px';
                    ripple.style.top = y + 'px';
                    ripple.classList.add('ripple');

                    this.appendChild(ripple);

                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });
        });

        // Add ripple CSS
        const rippleStyle = document.createElement('style');
        rippleStyle.textContent = `
            .ripple {
                position: absolute;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.3);
                transform: scale(0);
                animation: ripple-animation 0.6s linear;
                pointer-events: none;
            }
            
            @keyframes ripple-animation {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(rippleStyle);
    </script>
@endpush
