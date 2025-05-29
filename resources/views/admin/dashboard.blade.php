@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-tachometer-alt text-primary mr-2"></i>Dashboard
        </h1>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Total Users Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2 stats-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Pengguna</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_users'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-eye mr-1"></i>Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Books Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2 stats-card success">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Buku</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_books'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <a href="{{ route('admin.books.index') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-eye mr-1"></i>Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Categories Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2 stats-card info">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Kategori</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_categories'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-folder fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye mr-1"></i>Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Readings Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2 stats-card warning">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Bacaan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_readings'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book-reader fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <small class="text-muted">
                            <i class="fas fa-chart-line mr-1"></i>
                            Rata-rata:
                            {{ $stats['total_users'] > 0 ? round($stats['total_readings'] / $stats['total_users'], 1) : 0 }}
                            per pengguna
                        </small>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Recent Users -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-user-plus mr-2"></i>Pengguna Baru
                    </h6>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-light btn-sm">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body p-0">
                    @if (count($recentUsers) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Bergabung</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentUsers as $user)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img class="rounded-circle mr-2"
                                                        src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=32&background=4e73df&color=ffffff"
                                                        width="32" height="32">
                                                    <span class="font-weight-bold">{{ $user->name }}</span>
                                                </div>
                                            </td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.users.show', $user) }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-users fa-3x text-gray-300 mb-3"></i>
                            <p class="text-muted">Belum ada pengguna baru</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Reading Statistics Chart -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-chart-line mr-2"></i>Statistik Bacaan (7 Hari Terakhir)
                    </h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="readingChart" width="100%" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@push('styles')
    <style>
        .book-card {
            transition: all 0.3s ease;
            border: none;
        }

        .book-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(50, 50, 93, 0.1), 0 5px 15px rgba(0, 0, 0, 0.07);
        }

        .stats-card:hover {
            transform: translateY(-3px);
        }

        .card-header {
            border-bottom: none;
        }

        .badge {
            font-size: 0.75rem;
        }

        .chart-area {
            position: relative;
            height: 300px;
        }

        .quick-action-card {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .quick-action-card:hover {
            transform: translateY(-5px);
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // Reading Statistics Chart
            var ctx = document.getElementById('readingChart').getContext('2d');
            var readingChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [
                        @foreach ($readingStats as $stat)
                            '{{ \Carbon\Carbon::parse($stat->date)->format('d M') }}',
                        @endforeach
                    ],
                    datasets: [{
                        label: 'Jumlah Bacaan',
                        data: [
                            @foreach ($readingStats as $stat)
                                {{ $stat->count }},
                            @endforeach
                        ],
                        backgroundColor: 'rgba(78, 115, 223, 0.1)',
                        borderColor: 'rgba(78, 115, 223, 1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });

            // Enhanced hover effects
            $('.stats-card').hover(
                function() {
                    $(this).addClass('shadow-lg');
                },
                function() {
                    $(this).removeClass('shadow-lg');
                }
            );
        });
    </script>
@endpush
