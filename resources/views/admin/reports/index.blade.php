@extends('layouts.admin')

@section('title', 'Laporan Penjualan - Z3LF Admin')

@section('content')
<div class="p-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl serif font-medium text-gray-900 mb-2">Laporan Penjualan</h1>
        <p class="text-gray-600 font-light">Analisis lengkap performa toko</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Revenue -->
        <div class="bg-white border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gray-900 flex items-center justify-center">
                    <i class="fas fa-money-bill-wave text-white"></i>
                </div>
            </div>
            <p class="text-xs uppercase tracking-widest text-gray-500 mb-2">Total Pendapatan</p>
            <p class="text-2xl serif font-medium text-gray-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        </div>

        <!-- Total Orders -->
        <div class="bg-white border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gray-900 flex items-center justify-center">
                    <i class="fas fa-shopping-bag text-white"></i>
                </div>
            </div>
            <p class="text-xs uppercase tracking-widest text-gray-500 mb-2">Total Pesanan</p>
            <p class="text-2xl serif font-medium text-gray-900">{{ $totalOrders }}</p>
        </div>

        <!-- Books Sold -->
        <div class="bg-white border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gray-900 flex items-center justify-center">
                    <i class="fas fa-book text-white"></i>
                </div>
            </div>
            <p class="text-xs uppercase tracking-widest text-gray-500 mb-2">Buku Terjual</p>
            <p class="text-2xl serif font-medium text-gray-900">{{ $booksSold }}</p>
        </div>

        <!-- Average Order -->
        <div class="bg-white border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gray-900 flex items-center justify-center">
                    <i class="fas fa-chart-line text-white"></i>
                </div>
            </div>
            <p class="text-xs uppercase tracking-widest text-gray-500 mb-2">Rata-rata Pesanan</p>
            <p class="text-2xl serif font-medium text-gray-900">Rp {{ number_format($avgOrderValue, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Sales Trend -->
        <div class="bg-white border border-gray-200 p-6">
            <h2 class="text-lg serif font-medium text-gray-900 mb-4">Tren Penjualan</h2>
            <div class="h-80">
                <canvas id="salesTrendChart"></canvas>
            </div>
        </div>

        <!-- Top Categories -->
        <div class="bg-white border border-gray-200 p-6">
            <h2 class="text-lg serif font-medium text-gray-900 mb-4">Kategori Terlaris</h2>
            <div class="h-80">
                <canvas id="categoriesChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Tables -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Top Books -->
        <div class="bg-white border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg serif font-medium text-gray-900">Buku Terlaris</h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($topBooks as $index => $book)
                        <div class="flex items-center gap-4 pb-4 border-b border-gray-100 last:border-0">
                            <div class="w-8 h-8 bg-gray-900 text-white flex items-center justify-center text-sm font-medium">
                                {{ $index + 1 }}
                            </div>
                            <img src="{{ $book->cover_photo ? asset('storage/' . $book->cover_photo) : 'https://via.placeholder.com/50x70' }}" 
                                 alt="{{ $book->judul }}" 
                                 class="w-12 h-16 object-cover">
                            <div class="flex-1">
                                <p class="font-medium text-sm text-gray-900">{{ $book->judul }}</p>
                                <p class="text-xs text-gray-500 font-light">{{ $book->pengarang }}</p>
                                <div class="flex items-center gap-3 mt-1">
                                    <span class="text-xs text-gray-600">{{ $book->total_sold }} terjual</span>
                                    <span class="text-xs font-medium text-gray-900">Rp {{ number_format($book->revenue, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-8 font-light">Belum ada data</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Top Customers -->
        <div class="bg-white border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg serif font-medium text-gray-900">Pelanggan Teratas</h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($topCustomers as $index => $customer)
                        <div class="flex items-center gap-4 pb-4 border-b border-gray-100 last:border-0">
                            <div class="w-8 h-8 bg-gray-900 text-white flex items-center justify-center text-sm font-medium">
                                {{ $index + 1 }}
                            </div>
                            <img src="{{ $customer->photo ? asset('storage/' . $customer->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($customer->name) . '&size=48&background=1a1a1a&color=fff' }}" 
                                 alt="{{ $customer->name }}" 
                                 class="w-12 h-12 rounded-full object-cover">
                            <div class="flex-1">
                                <p class="font-medium text-sm text-gray-900">{{ $customer->name }}</p>
                                <p class="text-xs text-gray-500 font-light">{{ $customer->email }}</p>
                                <div class="flex items-center gap-3 mt-1">
                                    <span class="text-xs text-gray-600">{{ $customer->orders_count }} pesanan</span>
                                    <span class="text-xs font-medium text-gray-900">Rp {{ number_format($customer->total_spent, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-8 font-light">Belum ada data</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const salesLabels = {!! json_encode($salesTrendLabels ?? ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']) !!};
    const salesData = {!! json_encode($salesTrendData ?? [1200000, 1500000, 1800000, 1400000, 2000000, 2200000]) !!};
    const catLabels = {!! json_encode($categoryLabels ?? ['Fiction', 'Education', 'Technology', 'Romance', 'Science']) !!};
    const catData = {!! json_encode($categoryData ?? [35, 25, 20, 12, 8]) !!};

    // Sales Trend Chart
    const salesCtx = document.getElementById('salesTrendChart').getContext('2d');
    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: salesLabels,
            datasets: [{
                label: 'Pendapatan',
                data: salesData,
                borderColor: '#1a1a1a',
                backgroundColor: 'rgba(26, 26, 26, 0.1)',
                borderWidth: 2,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#1a1a1a',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 4
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
                    },
                    ticks: {
                        color: '#6b7280',
                        font: {
                            size: 11,
                            weight: 300
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f3f4f6'
                    },
                    ticks: {
                        color: '#6b7280',
                        font: {
                            size: 11,
                            weight: 300
                        },
                        callback: function(value) {
                            return 'Rp ' + (value/1000000).toFixed(0) + 'M';
                        }
                    }
                }
            }
        }
    });

    // Categories Chart
    const categoriesCtx = document.getElementById('categoriesChart').getContext('2d');
    new Chart(categoriesCtx, {
        type: 'doughnut',
        data: {
            labels: catLabels,
            datasets: [{
                data: catData,
                backgroundColor: ['#1a1a1a', '#4b5563', '#6b7280', '#9ca3af', '#d1d5db'],
                borderWidth: 0,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        usePointStyle: true,
                        pointStyle: 'circle',
                        color: '#6b7280',
                        font: {
                            size: 11,
                            weight: 300
                        }
                    }
                }
            },
            cutout: '60%'
        }
    });
</script>
@endsection
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'inter': ['Inter', 'sans-serif'],
                    },
                    colors: {
                        'primary': '#3B82F6',
                        'primary-dark': '#1E40AF',
                        'secondary': '#64748B',
                        'accent': '#F1F5F9',
                    }
                }
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="font-inter bg-slate-50">

    <!-- Sidebar -->
    <div class="flex h-screen">
        <aside class="w-64 bg-white border-r border-slate-200 flex-shrink-0 shadow-sm">
            <div class="p-6 border-b border-slate-200">
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center">
                        <i class="fas fa-book-open text-white text-sm"></i>
                    </div>
                    <h1 class="text-xl font-bold text-slate-900">BookHaven</h1>
                </div>
                <p class="text-sm text-slate-500 mt-1">Admin Panel</p>
            </div>
            
            <nav class="p-4">
                <div class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2 text-slate-700 hover:bg-slate-100 hover:text-primary transition-colors rounded-lg">
                        <i class="fas fa-home mr-3"></i> 
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('admin.books.index') }}" class="flex items-center px-3 py-2 text-slate-700 hover:bg-slate-100 hover:text-primary transition-colors rounded-lg">
                        <i class="fas fa-book mr-3"></i> 
                        <span>Manage Books</span>
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="flex items-center px-3 py-2 text-slate-700 hover:bg-slate-100 hover:text-primary transition-colors rounded-lg">
                        <i class="fas fa-shopping-cart mr-3"></i> 
                        <span>Orders</span>
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="flex items-center px-3 py-2 text-slate-700 hover:bg-slate-100 hover:text-primary transition-colors rounded-lg">
                        <i class="fas fa-users mr-3"></i> 
                        <span>Users</span>
                    </a>
                    <a href="{{ route('admin.reports.index') }}" class="flex items-center px-3 py-2 bg-primary/10 text-primary rounded-lg border-l-2 border-primary">
                        <i class="fas fa-chart-line mr-3"></i> 
                        <span class="font-medium">Reports</span>
                    </a>
                </div>
                
                <div class="mt-8 pt-4 border-t border-slate-200">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-3 py-2 text-red-600 hover:bg-red-50 transition-colors rounded-lg">
                            <i class="fas fa-sign-out-alt mr-3"></i> 
                            <span>Sign Out</span>
                        </button>
                    </form>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-auto">
            <!-- Header -->
            <header class="bg-white border-b border-slate-200">
                <div class="px-6 py-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-2xl font-bold text-slate-900">Reports & Analytics</h2>
                            <p class="text-slate-600">Comprehensive business insights and analytics</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <button onclick="exportReport()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors font-medium">
                                <i class="fas fa-download mr-2"></i>Export PDF
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <div class="p-6">
                <!-- Overview Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Total Revenue -->
                    <div class="bg-white rounded-xl border border-slate-200 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-slate-500 text-sm font-medium">Total Revenue</p>
                                <p class="text-3xl font-bold text-slate-900 mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                                <div class="flex items-center mt-2">
                                    <span class="text-green-600 text-sm font-medium">↗ 12.5%</span>
                                    <span class="text-slate-500 text-sm ml-1">from last month</span>
                                </div>
                            </div>
                            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-dollar-sign text-green-600 text-lg"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Total Orders -->
                    <div class="bg-white rounded-xl border border-slate-200 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-slate-500 text-sm font-medium">Total Orders</p>
                                <p class="text-3xl font-bold text-slate-900 mt-1">{{ $totalOrders }}</p>
                                <div class="flex items-center mt-2">
                                    <span class="text-blue-600 text-sm font-medium">↗ 8.2%</span>
                                    <span class="text-slate-500 text-sm ml-1">from last month</span>
                                </div>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-shopping-cart text-blue-600 text-lg"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Books Sold -->
                    <div class="bg-white rounded-xl border border-slate-200 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-slate-500 text-sm font-medium">Books Sold</p>
                                <p class="text-3xl font-bold text-slate-900 mt-1">{{ $booksSold }}</p>
                                <div class="flex items-center mt-2">
                                    <span class="text-purple-600 text-sm font-medium">↗ 15.3%</span>
                                    <span class="text-slate-500 text-sm ml-1">from last month</span>
                                </div>
                            </div>
                            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-book text-purple-600 text-lg"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Average Order Value -->
                    <div class="bg-white rounded-xl border border-slate-200 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-slate-500 text-sm font-medium">Avg Order Value</p>
                                <p class="text-3xl font-bold text-slate-900 mt-1">Rp {{ number_format($avgOrderValue, 0, ',', '.') }}</p>
                                <div class="flex items-center mt-2">
                                    <span class="text-orange-600 text-sm font-medium">↗ 3.7%</span>
                                    <span class="text-slate-500 text-sm ml-1">from last month</span>
                                </div>
                            </div>
                            <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-chart-line text-orange-600 text-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Row -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <!-- Sales Trend Chart -->
                    <div class="bg-white rounded-xl border border-slate-200 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-lg font-bold text-slate-900">Sales Trend</h3>
                                <p class="text-sm text-slate-500">Daily sales over time</p>
                            </div>
                        </div>
                        <div class="h-80">
                            <canvas id="salesTrendChart"></canvas>
                        </div>
                    </div>

                    <!-- Top Categories Chart -->
                    <div class="bg-white rounded-xl border border-slate-200 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-lg font-bold text-slate-900">Top Categories</h3>
                                <p class="text-sm text-slate-500">Best performing book categories</p>
                            </div>
                        </div>
                        <div class="h-80">
                            <canvas id="categoriesChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Data Tables -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Top Selling Books -->
                    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-200">
                            <h3 class="text-lg font-bold text-slate-900">Top Selling Books</h3>
                            <p class="text-sm text-slate-500">Best performing books this month</p>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                @forelse($topBooks as $index => $book)
                                    <div class="flex items-center space-x-4 p-3 hover:bg-slate-50 rounded-lg transition-colors">
                                        <div class="flex-shrink-0">
                                            <span class="w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center text-sm font-bold">{{ $index + 1 }}</span>
                                        </div>
                                        <img src="{{ $book->cover_photo ? asset('storage/' . $book->cover_photo) : 'https://via.placeholder.com/50x70' }}" 
                                             alt="{{ $book->judul }}" 
                                             class="w-12 h-16 object-cover rounded-lg border border-slate-200">
                                        <div class="flex-1 min-w-0">
                                            <p class="font-semibold text-sm text-slate-900 truncate">{{ $book->judul }}</p>
                                            <p class="text-xs text-slate-500 truncate">{{ $book->pengarang }}</p>
                                            <div class="flex items-center mt-1">
                                                <span class="text-xs text-slate-600">{{ $book->total_sold }} sold</span>
                                                <span class="text-xs text-slate-400 mx-2">•</span>
                                                <span class="text-xs font-medium text-green-600">Rp {{ number_format($book->revenue, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-center text-slate-500 py-8">No data available</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Top Customers -->
                    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-200">
                            <h3 class="text-lg font-bold text-slate-900">Top Customers</h3>
                            <p class="text-sm text-slate-500">Highest spending customers</p>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                @forelse($topCustomers as $index => $customer)
                                    <div class="flex items-center space-x-4 p-3 hover:bg-slate-50 rounded-lg transition-colors">
                                        <div class="flex-shrink-0">
                                            <span class="w-8 h-8 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center text-sm font-bold">{{ $index + 1 }}</span>
                                        </div>
                                        <img src="{{ $customer->photo ? asset('storage/' . $customer->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($customer->name) . '&size=48&background=3B82F6&color=fff' }}" 
                                             alt="{{ $customer->name }}" 
                                             class="w-12 h-12 rounded-full">
                                        <div class="flex-1 min-w-0">
                                            <p class="font-semibold text-sm text-slate-900 truncate">{{ $customer->name }}</p>
                                            <p class="text-xs text-slate-500 truncate">{{ $customer->email }}</p>
                                            <div class="flex items-center mt-1">
                                                <span class="text-xs text-slate-600">{{ $customer->orders_count }} orders</span>
                                                <span class="text-xs text-slate-400 mx-2">•</span>
                                                <span class="text-xs font-medium text-green-600">Rp {{ number_format($customer->total_spent, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-center text-slate-500 py-8">No data available</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        const salesLabels = {!! json_encode($salesTrendLabels ?? ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']) !!};
        const salesData = {!! json_encode($salesTrendData ?? [1200000, 1500000, 1800000, 1400000, 2000000, 2200000]) !!};
        const catLabels = {!! json_encode($categoryLabels ?? ['Fiction', 'Education', 'Technology', 'Romance', 'Science']) !!};
        const catData = {!! json_encode($categoryData ?? [35, 25, 20, 12, 8]) !!};

        // Sales Trend Chart
        const salesCtx = document.getElementById('salesTrendChart').getContext('2d');
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: salesLabels,
                datasets: [{
                    label: 'Revenue',
                    data: salesData,
                    borderColor: '#3B82F6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#3B82F6',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 3,
                    pointRadius: 6
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
                        },
                        border: {
                            color: '#e2e8f0'
                        },
                        ticks: {
                            color: '#64748b'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f1f5f9'
                        },
                        border: {
                            color: '#e2e8f0'
                        },
                        ticks: {
                            color: '#64748b',
                            callback: function(value) {
                                return 'Rp ' + (value/1000000).toFixed(0) + 'M';
                            }
                        }
                    }
                }
            }
        });

        // Categories Chart
        const categoriesCtx = document.getElementById('categoriesChart').getContext('2d');
        new Chart(categoriesCtx, {
            type: 'doughnut',
            data: {
                labels: catLabels,
                datasets: [{
                    data: catData,
                    backgroundColor: ['#3B82F6', '#10B981', '#8B5CF6', '#F59E0B', '#EF4444'],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    }
                },
                cutout: '60%'
            }
        });

        function exportReport() {
            window.open('/admin/reports/export', '_blank');
        }
    </script>
</body>
</html>
