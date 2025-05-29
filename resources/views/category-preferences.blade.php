@extends('layouts.app')

@section('title', 'Atur Preferensi - Digital Library')

@section('content')
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-8 text-center">
                    <div class="page-header-content">
                        <div class="header-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h1 class="page-title">Pilih Kategori Favorit Anda</h1>
                        <p class="page-subtitle">
                            Bantu kami memberikan rekomendasi buku yang lebih personal dengan memilih kategori yang Anda
                            sukai.
                            Anda dapat memilih lebih dari satu kategori.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Preferences Form Section -->
    <section class="preferences-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <form action="{{ route('save.preferences') }}" method="POST" class="preferences-form">
                        @csrf

                        <!-- Instructions -->
                        <div class="instructions-card">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h4 class="instructions-title">
                                        <i class="fas fa-lightbulb me-2"></i>Cara Memilih
                                    </h4>
                                    <p class="instructions-text">
                                        Klik pada kategori yang Anda minati. Semakin banyak kategori yang dipilih,
                                        semakin beragam rekomendasi yang akan Anda terima.
                                    </p>
                                </div>
                                <div class="col-md-4 text-md-end">
                                    <div class="selection-counter">
                                        <span class="counter-text">Dipilih: </span>
                                        <span class="counter-number">0</span>
                                        <span class="counter-total">kategori</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Categories Grid -->
                        <div class="categories-grid">
                            @foreach ($categories as $category)
                                <div class="category-item">
                                    <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                        id="category-{{ $category->id }}" class="category-checkbox">

                                    <label for="category-{{ $category->id }}" class="category-card">
                                        <div class="category-icon" style="color: {{ $category->color }};">
                                            <i class="{{ $category->icon }}"></i>
                                        </div>

                                        <div class="category-content">
                                            <h5 class="category-name">{{ $category->name }}</h5>
                                            @if ($category->description)
                                                <p class="category-description">{{ Str::limit($category->description, 60) }}
                                                </p>
                                            @endif
                                            <div class="category-stats">
                                                <span class="book-count">
                                                    <i class="fas fa-book me-1"></i>
                                                    {{ $category->books_count ?? 0 }} buku
                                                </span>
                                            </div>
                                        </div>

                                        <div class="category-overlay">
                                            <div class="check-icon">
                                                <i class="fas fa-check"></i>
                                            </div>
                                        </div>

                                        <div class="category-border"></div>
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <!-- Form Actions -->
                        <div class="form-actions">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="help-text">
                                        <i class="fas fa-info-circle me-2 text-info"></i>
                                        Anda dapat mengubah preferensi ini kapan saja di pengaturan akun.
                                    </div>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <div class="action-buttons">
                                        <button type="button" class="btn btn-outline-secondary me-3" id="selectAllBtn">
                                            <i class="fas fa-check-double me-2"></i>Pilih Semua
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary me-3" id="clearAllBtn">
                                            <i class="fas fa-times me-2"></i>Hapus Semua
                                        </button>
                                        <button type="submit" class="btn btn-primary btn-lg" id="saveBtn" disabled>
                                            <i class="fas fa-save me-2"></i>Simpan Preferensi
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="benefits-section">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h3 class="benefits-title">Manfaat Mengatur Preferensi</h3>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <h5 class="benefit-title">Rekomendasi Akurat</h5>
                        <p class="benefit-description">
                            Dapatkan rekomendasi buku yang sesuai dengan minat dan preferensi Anda.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h5 class="benefit-title">Hemat Waktu</h5>
                        <p class="benefit-description">
                            Temukan buku favorit lebih cepat tanpa perlu mencari satu per satu.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="fas fa-gem"></i>
                        </div>
                        <h5 class="benefit-title">Konten Personal</h5>
                        <p class="benefit-description">
                            Nikmati pengalaman membaca yang dipersonalisasi khusus untuk Anda.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        .page-header {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            padding: 8rem 0 5rem;
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
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="heart-pattern" width="30" height="30" patternUnits="userSpaceOnUse"><path d="M15,25 C10,15 0,15 0,25 C0,35 15,45 15,45 C15,45 30,35 30,25 C30,15 20,15 15,25 Z" fill="white" opacity="0.05"/></pattern></defs><rect width="100" height="100" fill="url(%23heart-pattern)"/></svg>');
            animation: float 40s ease-in-out infinite;
        }

        .header-icon {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            font-size: 2.5rem;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .page-subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        .preferences-section {
            padding: 4rem 0;
            margin-top: -80px;
            position: relative;
            z-index: 10;
        }

        .instructions-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 3rem;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .instructions-title {
            color: var(--gray-800);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .instructions-text {
            color: var(--gray-600);
            margin: 0;
            line-height: 1.5;
        }

        .selection-counter {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            text-align: center;
        }

        .counter-number {
            font-size: 1.5rem;
            font-weight: 800;
            margin: 0 0.5rem;
        }

        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .category-item {
            position: relative;
        }

        .category-checkbox {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .category-card {
            display: block;
            background: white;
            border-radius: 20px;
            padding: 2rem;
            cursor: pointer;
            transition: all 0.4s ease;
            border: 2px solid var(--gray-200);
            position: relative;
            overflow: hidden;
            height: 100%;
            text-decoration: none;
            color: inherit;
        }

        .category-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
            border-color: var(--primary-color);
            text-decoration: none;
            color: inherit;
        }

        .category-icon {
            font-size: 3rem;
            margin-bottom: 1.5rem;
            display: block;
            transition: all 0.3s ease;
        }

        .category-name {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 0.5rem;
        }

        .category-description {
            color: var(--gray-600);
            font-size: 0.9rem;
            line-height: 1.4;
            margin-bottom: 1rem;
        }

        .category-stats {
            color: var(--gray-500);
            font-size: 0.85rem;
        }

        .category-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            opacity: 0;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .check-icon {
            background: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--primary-color);
            transform: scale(0);
            transition: all 0.3s ease;
        }

        .category-border {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border: 3px solid var(--primary-color);
            border-radius: 20px;
            opacity: 0;
            transition: all 0.3s ease;
        }

        /* Selected state */
        .category-checkbox:checked+.category-card {
            border-color: var(--primary-color);
            background: rgba(99, 102, 241, 0.05);
        }

        .category-checkbox:checked+.category-card .category-overlay {
            opacity: 0.95;
        }

        .category-checkbox:checked+.category-card .check-icon {
            transform: scale(1);
        }

        .category-checkbox:checked+.category-card .category-border {
            opacity: 1;
        }

        .form-actions {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--gray-200);
        }

        .help-text {
            color: var(--gray-600);
            font-size: 0.9rem;
        }

        .action-buttons {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .btn {
            border-radius: 50px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        }

        .btn-primary:disabled {
            background: var(--gray-400);
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .benefits-section {
            padding: 5rem 0;
            background: var(--gray-50);
        }

        .benefits-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 3rem;
        }

        .benefit-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            height: 100%;
            transition: all 0.3s ease;
            border: 1px solid var(--gray-200);
        }

        .benefit-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .benefit-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 1.8rem;
        }

        .benefit-title {
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 1rem;
        }

        .benefit-description {
            color: var(--gray-600);
            line-height: 1.5;
            margin: 0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-title {
                font-size: 2.5rem;
            }

            .categories-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .action-buttons {
                justify-content: center;
                margin-top: 1rem;
            }

            .form-actions .row {
                flex-direction: column;
                text-align: center;
            }

            .help-text {
                margin-bottom: 1rem;
            }
        }

        @media (max-width: 576px) {
            .page-header {
                padding: 6rem 0 3rem;
                padding-top: 150px;
            }

            .header-icon {
                width: 80px;
                height: 80px;
                font-size: 2rem;
            }

            .selection-counter {
                padding: 0.75rem 1rem;
                font-size: 0.9rem;
            }

            .counter-number {
                font-size: 1.2rem;
            }

            .category-card {
                padding: 1.5rem;
            }

            .action-buttons {
                flex-direction: column;
            }

            .action-buttons .btn {
                width: 100%;
                margin-bottom: 0.5rem;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            let selectedCount = 0;

            // Update counter
            function updateCounter() {
                selectedCount = $('.category-checkbox:checked').length;
                $('.counter-number').text(selectedCount);

                // Enable/disable save button
                $('#saveBtn').prop('disabled', selectedCount === 0);

                // Update button text
                if (selectedCount === 0) {
                    $('#saveBtn').html('<i class="fas fa-save me-2"></i>Pilih Minimal 1 Kategori');
                } else {
                    $('#saveBtn').html(`<i class="fas fa-save me-2"></i>Simpan ${selectedCount} Kategori`);
                }
            }

            // Handle checkbox change
            $('.category-checkbox').on('change', function() {
                updateCounter();

                // Animate selection
                const $card = $(this).next('.category-card');
                if (this.checked) {
                    $card.addClass('selected');
                } else {
                    $card.removeClass('selected');
                }
            });

            // Select all button
            $('#selectAllBtn').on('click', function() {
                $('.category-checkbox').prop('checked', true).trigger('change');
                $(this).text('Semua Dipilih').prop('disabled', true);
                $('#clearAllBtn').prop('disabled', false).html(
                    '<i class="fas fa-times me-2"></i>Hapus Semua');
            });

            // Clear all button
            $('#clearAllBtn').on('click', function() {
                $('.category-checkbox').prop('checked', false).trigger('change');
                $(this).text('Semua Dihapus').prop('disabled', true);
                $('#selectAllBtn').prop('disabled', false).html(
                    '<i class="fas fa-check-double me-2"></i>Pilih Semua');

                setTimeout(() => {
                    $(this).prop('disabled', false).html(
                        '<i class="fas fa-times me-2"></i>Hapus Semua');
                }, 1000);
            });

            // Form submission with loading state
            $('.preferences-form').on('submit', function(e) {
                if (selectedCount === 0) {
                    e.preventDefault();
                    alert('Silakan pilih minimal satu kategori!');
                    return;
                }

                $('#saveBtn').html('<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...').prop(
                    'disabled', true);
            });

            // Initialize counter
            updateCounter();

            // Add hover effects
            $('.category-card').on('mouseenter', function() {
                if (!$(this).prev('.category-checkbox').is(':checked')) {
                    $(this).find('.category-icon').css('transform', 'scale(1.1)');
                }
            }).on('mouseleave', function() {
                $(this).find('.category-icon').css('transform', 'scale(1)');
            });

            // Animate on scroll
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, {
                threshold: 0.1
            });

            // Observe category cards
            document.querySelectorAll('.category-item').forEach((item, index) => {
                item.style.opacity = '0';
                item.style.transform = 'translateY(30px)';
                item.style.transition = `all 0.6s ease ${index * 0.1}s`;
                observer.observe(item);
            });
        });
    </script>
@endpush
