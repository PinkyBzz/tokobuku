<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - Z3LF</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, .serif { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="bg-[#fcfcfc] text-gray-900 antialiased">

    <!-- Mobile Menu Button -->
    <button id="mobile-menu-btn" class="lg:hidden fixed top-4 left-4 z-50 bg-gray-900 text-white p-3 rounded-sm">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen bg-white border-r border-gray-100 transform -translate-x-full lg:translate-x-0 transition-transform duration-300">
        <div class="h-full px-3 py-6 overflow-y-auto">
            <!-- Logo -->
            <div class="mb-10 px-3">
                <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold tracking-widest text-gray-900 serif">Z3LF BOOKSTORE.</a>
                <p class="text-xs uppercase tracking-widest text-gray-400 mt-1">Admin Panel</p>
            </div>

            <!-- Navigation -->
            <ul class="space-y-2 font-medium">
                <li>
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center px-3 py-3 text-sm text-gray-600 hover:bg-gray-50 transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-gray-50 text-gray-900' : '' }}">
                        <i class="fas fa-chart-line w-5"></i>
                        <span class="ml-3 uppercase tracking-widest text-xs font-medium">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.books.index') }}" 
                       class="flex items-center px-3 py-3 text-sm text-gray-600 hover:bg-gray-50 transition-colors {{ request()->routeIs('admin.books.*') ? 'bg-gray-50 text-gray-900' : '' }}">
                        <i class="fas fa-book w-5"></i>
                        <span class="ml-3 uppercase tracking-widest text-xs font-medium">Books</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.categories.index') }}" 
                       class="flex items-center px-3 py-3 text-sm text-gray-600 hover:bg-gray-50 transition-colors {{ request()->routeIs('admin.categories.*') ? 'bg-gray-50 text-gray-900' : '' }}">
                        <i class="fas fa-folder w-5"></i>
                        <span class="ml-3 uppercase tracking-widest text-xs font-medium">Categories</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.orders.index') }}" 
                       class="flex items-center px-3 py-3 text-sm text-gray-600 hover:bg-gray-50 transition-colors {{ request()->routeIs('admin.orders.*') ? 'bg-gray-50 text-gray-900' : '' }}">
                        <i class="fas fa-shopping-cart w-5"></i>
                        <span class="ml-3 uppercase tracking-widest text-xs font-medium">Orders</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users.index') }}" 
                       class="flex items-center px-3 py-3 text-sm text-gray-600 hover:bg-gray-50 transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-gray-50 text-gray-900' : '' }}">
                        <i class="fas fa-users w-5"></i>
                        <span class="ml-3 uppercase tracking-widest text-xs font-medium">Users</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.reports.index') }}" 
                       class="flex items-center px-3 py-3 text-sm text-gray-600 hover:bg-gray-50 transition-colors {{ request()->routeIs('admin.reports.*') ? 'bg-gray-50 text-gray-900' : '' }}">
                        <i class="fas fa-chart-line w-5"></i>
                        <span class="ml-3 uppercase tracking-widest text-xs font-medium">Laporan</span>
                    </a>
                </li>
                <li class="pt-4 border-t border-gray-100">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-3 py-3 text-sm text-gray-600 hover:bg-gray-50 transition-colors">
                            <i class="fas fa-sign-out-alt w-5"></i>
                            <span class="ml-3 uppercase tracking-widest text-xs font-medium">Logout</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="lg:ml-64">
        <!-- Top Bar -->
        <header class="bg-white border-b border-gray-100 sticky top-0 z-30">
            <div class="px-4 lg:px-8 py-6">
                <div class="flex items-center justify-between">
                    <h1 class="text-xl lg:text-2xl font-medium text-gray-900 serif italic">@yield('page-title', 'Dashboard')</h1>
                    <div class="flex items-center gap-4">
                        <span class="hidden sm:block text-sm text-gray-500 font-light">{{ Auth::user()->name }}</span>
                        <div class="w-10 h-10 bg-gray-900 rounded-full flex items-center justify-center">
                            <span class="text-white text-sm font-medium">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="p-4 lg:p-8">
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-sm">
                    <p class="text-sm font-light">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-sm">
                    <p class="text-sm font-light">{{ session('error') }}</p>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- WhatsApp Floating Button -->
    <a href="https://wa.me/6282211599226?text=Halo%20admin,%20saya%20ingin%20meminta%20bantuan" 
       target="_blank"
       class="fixed bottom-6 right-6 z-50 w-14 h-14 bg-green-500 hover:bg-green-600 text-white rounded-full flex items-center justify-center shadow-2xl hover:shadow-green-500/50 transition-all duration-300 hover:scale-110 group">
        <i class="fab fa-whatsapp text-3xl group-hover:scale-110 transition-transform"></i>
        <span class="absolute right-16 bg-gray-900 text-white px-4 py-2 rounded-sm text-xs uppercase tracking-widest whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
            Chat WhatsApp
        </span>
    </a>

    <script>
        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const sidebar = document.getElementById('sidebar');
        
        mobileMenuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
        });
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', (e) => {
            if (window.innerWidth < 1024) {
                if (!sidebar.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
                    sidebar.classList.add('-translate-x-full');
                }
            }
        });
    </script>

</body>
</html>
