@props(['book'])

<div class="book-card">
    <div class="book-image-container">
        <a href="{{ route('books.show', $book->slug) }}">
            @if ($book->cover_image)
                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="book-cover"
                    loading="lazy">
            @else
                <div class="book-placeholder">
                    <i class="fas fa-book fa-3x"></i>
                </div>
            @endif
        </a>

        <!-- Book Actions Overlay -->
        <div class="book-actions-overlay">
            <div class="book-actions">
                <a href="{{ route('books.show', $book->slug) }}" class="btn btn-light btn-sm" title="Lihat Detail">
                    <i class="fas fa-eye"></i>
                </a>
                @auth
                    <button class="btn btn-light btn-sm bookmark-btn" data-book-id="{{ $book->id }}"
                        data-bookmarked="{{ $book->isBookmarkedBy(Auth::user()) ? 'true' : 'false' }}"
                        title="{{ $book->isBookmarkedBy(Auth::user()) ? 'Hapus Bookmark' : 'Tambah Bookmark' }}">
                        <i class="fas fa-bookmark {{ $book->isBookmarkedBy(Auth::user()) ? 'text-primary' : '' }}"></i>
                    </button>
                    <a href="{{ route('books.read', $book->slug) }}" class="btn btn-primary btn-sm" title="Baca Sekarang">
                        <i class="fas fa-book-open"></i>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary btn-sm" title="Login untuk Membaca">
                        <i class="fas fa-book-open"></i>
                    </a>
                @endauth
            </div>
        </div>

        <!-- Book Badge -->
        @if ($book->is_featured)
            <div class="book-badge featured">
                <i class="fas fa-crown"></i>
                <span>Pilihan</span>
            </div>
        @endif

        <!-- Book Stats -->
        <div class="book-stats-overlay">
            <div class="stat-item">
                <i class="fas fa-eye"></i>
                <span>{{ number_format($book->views) }}</span>
            </div>
        </div>
    </div>

    <div class="book-content">
        <!-- Category -->
        <div class="book-category">
            <a href="{{ route('books.index', ['category' => $book->category->id]) }}" class="category-tag"
                style="background-color: {{ $book->category->color }}20; color: {{ $book->category->color }};">
                <i class="{{ $book->category->icon }} me-1"></i>
                {{ $book->category->name }}
            </a>
        </div>

        <!-- Title -->
        <h3 class="book-title">
            <a href="{{ route('books.show', $book->slug) }}">{{ $book->title }}</a>
        </h3>

        <!-- Author -->
        <p class="book-author">
            <i class="fas fa-user-edit me-1"></i>{{ $book->author }}
        </p>

        <!-- Rating -->
        <div class="book-rating">
            <div class="stars">
                @for ($i = 1; $i <= 5; $i++)
                    <i class="fas fa-star {{ $i <= $book->rating ? 'active' : '' }}"></i>
                @endfor
            </div>
            <span class="rating-value">{{ number_format($book->rating, 1) }}</span>
            <span class="rating-count">({{ $book->reviews_count ?? 0 }})</span>
        </div>

        <!-- Description -->
        @if ($book->description)
            <p class="book-description">
                {{ Str::limit($book->description, 80) }}
            </p>
        @endif

        <!-- Meta Info -->
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

        <!-- Action Button -->
        <div class="book-action">
            @auth
                <a href="{{ route('books.read', $book->slug) }}" class="btn btn-primary w-100">
                    <i class="fas fa-book-open me-2"></i>Baca Sekarang
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-primary w-100">
                    <i class="fas fa-sign-in-alt me-2"></i>Login untuk Membaca
                </a>
            @endauth
        </div>
    </div>
</div>

<style>
    .book-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.4s ease;
        height: 100%;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--gray-200, #e5e7eb);
        position: relative;
    }

    .book-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        border-color: var(--primary-color, #6366f1);
    }

    .book-image-container {
        position: relative;
        height: 280px;
        overflow: hidden;
        background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
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
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--gray-400, #9ca3af);
        background: linear-gradient(135deg, #f9fafb, #f3f4f6);
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

    .book-actions .btn {
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(10px);
        border: none;
        transition: all 0.3s ease;
    }

    .book-actions .btn:hover {
        transform: scale(1.1);
    }

    .book-actions .btn-light {
        background: rgba(255, 255, 255, 0.9);
        color: var(--gray-700, #374151);
    }

    .book-actions .btn-primary {
        background: var(--primary-color, #6366f1);
        color: white;
    }

    .book-badge {
        position: absolute;
        top: 1rem;
        left: 1rem;
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
        padding: 0.5rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        z-index: 3;
        display: flex;
        align-items: center;
        gap: 0.25rem;
        box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
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
        backdrop-filter: blur(5px);
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .book-content {
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        height: calc(100% - 280px);
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
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        line-height: 1.3;
        color: var(--gray-800, #1f2937);
    }

    .book-title a {
        color: inherit;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .book-title a:hover {
        color: var(--primary-color, #6366f1);
    }

    .book-author {
        color: var(--gray-600, #4b5563);
        font-size: 0.9rem;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
    }

    .book-rating {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
        font-size: 0.9rem;
    }

    .stars {
        display: flex;
        gap: 0.2rem;
    }

    .stars i {
        color: var(--gray-300, #d1d5db);
        font-size: 0.8rem;
    }

    .stars i.active {
        color: #f59e0b;
    }

    .rating-value {
        font-weight: 600;
        color: var(--gray-700, #374151);
    }

    .rating-count {
        color: var(--gray-500, #6b7280);
        font-size: 0.8rem;
    }

    .book-description {
        color: var(--gray-600, #4b5563);
        font-size: 0.9rem;
        line-height: 1.4;
        margin-bottom: 1rem;
        flex-grow: 1;
    }

    .book-meta {
        display: flex;
        gap: 1rem;
        font-size: 0.8rem;
        color: var(--gray-500, #6b7280);
        margin-bottom: 1.5rem;
        padding-top: 1rem;
        border-top: 1px solid var(--gray-200, #e5e7eb);
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    .book-action {
        margin-top: auto;
    }

    .book-action .btn {
        border-radius: 50px;
        padding: 0.75rem 1rem;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .book-action .btn-primary {
        background: var(--primary-color, #6366f1);
        color: white;
    }

    .book-action .btn-primary:hover {
        background: var(--primary-dark, #4338ca);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(99, 102, 241, 0.3);
    }

    .book-action .btn-outline-primary {
        border-color: var(--primary-color, #6366f1);
        color: var(--primary-color, #6366f1);
        background: transparent;
    }

    .book-action .btn-outline-primary:hover {
        background: var(--primary-color, #6366f1);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(99, 102, 241, 0.3);
    }

    /* Bookmark functionality */
    .bookmark-btn.bookmarked {
        color: var(--primary-color, #6366f1) !important;
    }

    /* Loading state */
    .book-card.loading {
        pointer-events: none;
        opacity: 0.7;
    }

    .book-card.loading::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 30px;
        height: 30px;
        margin: -15px 0 0 -15px;
        border: 3px solid var(--primary-color, #6366f1);
        border-top: 3px solid transparent;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        z-index: 10;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .book-image-container {
            height: 240px;
        }

        .book-content {
            padding: 1rem;
            height: calc(100% - 240px);
        }

        .book-meta {
            flex-direction: column;
            gap: 0.5rem;
        }

        .book-actions {
            gap: 0.25rem;
        }

        .book-actions .btn {
            width: 35px;
            height: 35px;
        }
    }

    /* Animation for new cards */
    .book-card.animate-in {
        animation: slideInUp 0.6s ease-out;
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Bookmark functionality
        document.querySelectorAll('.bookmark-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const bookId = this.dataset.bookId;
                const isBookmarked = this.dataset.bookmarked === 'true';

                // Show loading state
                this.disabled = true;
                const originalHtml = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

                // Send AJAX request
                fetch(`/books/${bookId}/bookmark`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector(
                                'meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update button state
                            this.dataset.bookmarked = data.isBookmarked ? 'true' : 'false';
                            this.title = data.isBookmarked ? 'Hapus Bookmark' :
                                'Tambah Bookmark';

                            // Update icon
                            const iconClass = data.isBookmarked ?
                                'fas fa-bookmark text-primary' : 'fas fa-bookmark';
                            this.innerHTML = `<i class="${iconClass}"></i>`;

                            // Show success feedback
                            this.classList.add('animate__animated', 'animate__pulse');
                            setTimeout(() => {
                                this.classList.remove('animate__animated',
                                    'animate__pulse');
                            }, 600);

                        } else {
                            this.innerHTML = originalHtml;
                            alert('Terjadi kesalahan');
                        }
                    })
                    .catch(error => {
                        this.innerHTML = originalHtml;
                        alert('Silakan login terlebih dahulu');
                    })
                    .finally(() => {
                        this.disabled = false;
                    });
            });
        });

        // Lazy loading for images
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        observer.unobserve(img);
                    }
                }
            });
        });

        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    });
</script>
