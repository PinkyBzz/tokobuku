<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Z3LF Bookstore')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, .serif { font-family: 'Playfair Display', serif; }
        html { scroll-behavior: smooth; }
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 4px; }
        .book-card {
            transition: transform 0.4s cubic-bezier(0.25, 1, 0.5, 1), box-shadow 0.4s ease;
        }
        .book-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px -4px rgba(0, 0, 0, 0.1);
        }
    </style>
    @yield('styles')
</head>
<body class="bg-[#fcfcfc] text-gray-900 antialiased selection:bg-gray-900 selection:text-white">

    <!-- Navigation (Glassmorphism) -->
    <nav class="fixed top-0 w-full z-50 bg-white/70 backdrop-blur-xl border-b border-gray-100/50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">
            <div class="flex justify-between h-16 lg:h-20 items-center">
                <div class="flex-shrink-0 cursor-pointer">
                    <a href="{{ route('user.home') }}" class="text-base lg:text-xl font-bold tracking-widest text-gray-900 serif">Z3LF BOOKSTORE.</a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-6 lg:space-x-10 items-center">
                    <a href="{{ route('user.home') }}" class="text-xs font-medium uppercase tracking-widest {{ request()->routeIs('user.home') ? 'text-gray-900 border-b border-gray-900 pb-0.5' : 'text-gray-500 hover:text-gray-900' }} transition-colors">Home</a>
                    <a href="{{ route('user.books.index') }}" class="text-xs font-medium uppercase tracking-widest {{ request()->routeIs('user.books.*') ? 'text-gray-900 border-b border-gray-900 pb-0.5' : 'text-gray-500 hover:text-gray-900' }} transition-colors">Catalog</a>
                    <a href="{{ route('about') }}" class="text-xs font-medium uppercase tracking-widest {{ request()->routeIs('about') ? 'text-gray-900 border-b border-gray-900 pb-0.5' : 'text-gray-500 hover:text-gray-900' }} transition-colors">About</a>
                    <a href="{{ route('contact') }}" class="text-xs font-medium uppercase tracking-widest {{ request()->routeIs('contact') ? 'text-gray-900 border-b border-gray-900 pb-0.5' : 'text-gray-500 hover:text-gray-900' }} transition-colors">Contact</a>
                </div>

                <div class="flex items-center space-x-4 lg:space-x-6">
                    <a href="{{ route('user.cart.index') }}" class="relative text-gray-400 hover:text-gray-900 transition-colors group">
                        <i class="fas fa-shopping-bag text-lg lg:text-xl"></i>
                        @if(session('cart') && count(session('cart')) > 0)
                        <span class="absolute -top-1 -right-1 h-4 w-4 rounded-full bg-gray-900 text-white text-[10px] flex items-center justify-center font-medium">{{ count(session('cart')) }}</span>
                        @endif
                    </a>
                    <div class="hidden md:block relative group">
                        <button class="text-gray-400 hover:text-gray-900 transition-colors flex items-center gap-2">
                            <i class="fas fa-user text-lg"></i>
                            <span class="hidden sm:block text-xs font-medium uppercase tracking-widest text-gray-900">{{ Auth::user()->username }}</span>
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-white border border-gray-100 shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-right">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Mobile Menu Button -->
                    <button id="mobile-menu-btn" class="md:hidden text-gray-900">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="md:hidden hidden border-t border-gray-100/50 py-4">
                <div class="space-y-1">
                    <a href="{{ route('user.home') }}" class="block px-4 py-3 text-xs font-medium uppercase tracking-widest {{ request()->routeIs('user.home') ? 'text-gray-900 bg-gray-50' : 'text-gray-500' }}">Home</a>
                    <a href="{{ route('user.books.index') }}" class="block px-4 py-3 text-xs font-medium uppercase tracking-widest {{ request()->routeIs('user.books.*') ? 'text-gray-900 bg-gray-50' : 'text-gray-500' }}">Catalog</a>
                    <a href="{{ route('about') }}" class="block px-4 py-3 text-xs font-medium uppercase tracking-widest {{ request()->routeIs('about') ? 'text-gray-900 bg-gray-50' : 'text-gray-500' }}">About</a>
                    <a href="{{ route('contact') }}" class="block px-4 py-3 text-xs font-medium uppercase tracking-widest {{ request()->routeIs('contact') ? 'text-gray-900 bg-gray-50' : 'text-gray-500' }}">Contact</a>
                    <div class="border-t border-gray-100/50 mt-2 pt-2">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-3 text-xs font-medium uppercase tracking-widest text-gray-500">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- WhatsApp Floating Button -->
    <a href="https://wa.me/6282211599226?text=Halo%20admin,%20saya%20ingin%20meminta%20bantuan" 
       target="_blank"
       class="fixed bottom-6 right-6 z-50 w-14 h-14 bg-green-500 hover:bg-green-600 text-white rounded-full flex items-center justify-center shadow-2xl hover:shadow-green-500/50 transition-all duration-300 hover:scale-110 group">
        <i class="fab fa-whatsapp text-3xl group-hover:scale-110 transition-transform"></i>
        <span class="absolute right-16 bg-gray-900 text-white px-4 py-2 rounded-sm text-xs uppercase tracking-widest whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
            Chat WhatsApp
        </span>
    </a>

    <!-- Footer -->
    <footer class="border-t border-gray-100 bg-white mt-20">
        <div class="max-w-7xl mx-auto py-16 px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                <div class="col-span-1">
                    <span class="text-xl font-bold tracking-widest text-gray-900 serif">Z3LF BOOKSTORE.</span>
                    <p class="mt-4 text-sm text-gray-500 font-light">Membawa dunia literasi ke ujung jari Anda.</p>
                </div>
                <div>
                    <h4 class="text-xs font-medium uppercase tracking-widest text-gray-900 mb-4">Belanja</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('user.books.index') }}" class="text-sm text-gray-500 hover:text-gray-900 transition-colors">Semua Buku</a></li>
                        <li><a href="{{ route('user.books.index', ['sort' => 'latest']) }}" class="text-sm text-gray-500 hover:text-gray-900 transition-colors">Koleksi Terbaru</a></li>
                        <li><a href="{{ route('user.books.index', ['sort' => 'price_low']) }}" class="text-sm text-gray-500 hover:text-gray-900 transition-colors">Best Sellers</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-xs font-medium uppercase tracking-widest text-gray-900 mb-4">Informasi</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('about') }}" class="text-sm text-gray-500 hover:text-gray-900 transition-colors">Tentang Kami</a></li>
                        <li><a href="{{ route('contact') }}" class="text-sm text-gray-500 hover:text-gray-900 transition-colors">Hubungi Kami</a></li>
                        <li><a href="#" class="text-sm text-gray-500 hover:text-gray-900 transition-colors">FAQ</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-xs font-medium uppercase tracking-widest text-gray-900 mb-4">Newsletter</h4>
                    <form class="flex gap-2">
                        <input type="email" placeholder="Email Anda" class="flex-1 bg-white border border-gray-200 px-4 py-3 text-sm placeholder-gray-400 focus:outline-none focus:border-gray-900 transition-all">
                        <button type="button" class="bg-gray-900 text-white px-4 py-3 hover:bg-gray-800 transition-colors">
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </form>
                </div>
            </div>
            <div class="mt-12 pt-8 border-t border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-xs text-gray-400">© 2025 Z3LF Bookstore. All rights reserved.</p>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-gray-500"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-gray-400 hover:text-gray-500"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-gray-400 hover:text-gray-500"><i class="fab fa-facebook"></i></a>
                </div>
            </div>
        </div>
    </footer>

    @yield('scripts')
    
    <script>
        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
                const icon = mobileMenuBtn.querySelector('i');
                icon.classList.toggle('fa-bars');
                icon.classList.toggle('fa-times');
            });
        }
    </script>
</body>
</html>
