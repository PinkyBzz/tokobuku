<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Z3LF Luxury Bookstore</title>
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
        
        .custom-checkbox:checked {
            background-color: #111827;
            border-color: #111827;
        }
    </style>
</head>
<body class="bg-[#fcfcfc] text-gray-900 antialiased selection:bg-gray-900 selection:text-white">

    <!-- Navigation (Glassmorphism) -->
    <nav class="fixed top-0 w-full z-50 bg-white/70 backdrop-blur-xl border-b border-gray-100/50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex-shrink-0 cursor-pointer">
                    <a href="{{ route('landing') }}" class="text-xl font-bold tracking-widest text-gray-900 serif">Z3LF BOOKSTORE.</a>
                </div>

                <div class="hidden md:flex space-x-10 items-center">
                    <a href="#home" class="text-xs font-medium uppercase tracking-widest text-gray-900 border-b border-gray-900 pb-0.5">Home</a>
                    <a href="#catalog" class="text-xs font-medium uppercase tracking-widest text-gray-500 hover:text-gray-900 transition-colors">Catalog</a>
                    <a href="{{ route('about') }}" class="text-xs font-medium uppercase tracking-widest text-gray-500 hover:text-gray-900 transition-colors">About</a>
                    <a href="{{ route('contact') }}" class="text-xs font-medium uppercase tracking-widest text-gray-500 hover:text-gray-900 transition-colors">Contact</a>
                </div>

                <div class="flex items-center space-x-6">
                    <a href="{{ route('login') }}" class="text-gray-400 hover:text-gray-900 transition-colors">
                        <i class="fas fa-user w-5 h-5"></i>
                    </a>
                    <a href="{{ route('register') }}" class="hidden sm:block text-xs font-medium uppercase tracking-widest text-gray-900 border border-gray-200 px-4 py-2 hover:border-gray-900 transition-colors">
                        Sign Up
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-28 pb-20 max-w-7xl mx-auto px-6 lg:px-8">
        
        <!-- Hero Section (Editorial Layout) -->
        <div id="home" class="relative w-full bg-gray-50 rounded-lg overflow-hidden mb-20 p-8 md:p-16 flex flex-col md:flex-row items-center justify-between min-h-[500px]">
            <div class="z-10 max-w-xl space-y-8">
                <div class="inline-flex items-center space-x-2 border-b border-gray-900 pb-1">
                    <span class="text-xs font-bold uppercase tracking-widest text-gray-900">Welcome to Z3LF</span>
                </div>
                <h1 class="text-5xl md:text-7xl leading-tight text-gray-900 font-medium serif">
                    Literasi untuk<br><i class="font-serif italic text-gray-600">Pemikir</i> Modern.
                </h1>
                <p class="text-gray-600 text-lg max-w-md font-light leading-relaxed">
                    Koleksi buku dikurasi dengan cermat untuk membentuk perspektif baru dan memperluas cakrawala pemikiran Anda.
                </p>
                <div class="pt-4">
                    <a href="#catalog" class="inline-block bg-gray-900 text-white px-8 py-4 text-xs font-medium uppercase tracking-widest hover:bg-gray-800 transition-colors shadow-xl shadow-gray-200">
                        Jelajahi Koleksi
                    </a>
                </div>
            </div>
            
            <div class="mt-12 md:mt-0 relative w-full md:w-1/3 flex justify-center">
                 <div class="absolute inset-0 bg-gradient-to-tr from-gray-200 to-gray-100 rounded-full blur-3xl opacity-50 transform scale-150"></div>
                 <div class="relative w-64 aspect-[2/3] bg-[#e6e6e6] shadow-2xl rounded-sm transform rotate-[-6deg] hover:rotate-0 transition-transform duration-700 ease-out flex items-center justify-center border border-white/50">
                    <div class="text-center p-6 border-2 border-gray-400/20 w-[90%] h-[90%] flex flex-col justify-between">
                        <span class="text-[10px] uppercase tracking-[0.2em] text-gray-500 block">Curated</span>
                        <div class="w-12 h-12 rounded-full border border-gray-400 mx-auto"></div>
                        <span class="text-xs uppercase tracking-widest text-gray-900 block font-bold serif">Collection</span>
                    </div>
                 </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-20 border-y border-gray-100 py-12">
            <div class="text-center">
                <div class="text-4xl font-medium text-gray-900 mb-2 serif">{{ number_format($totalBooks ?? 0) }}+</div>
                <div class="text-xs uppercase tracking-widest text-gray-500">Koleksi Buku</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-medium text-gray-900 mb-2 serif">{{ number_format($totalCategories ?? 0) }}+</div>
                <div class="text-xs uppercase tracking-widest text-gray-500">Kategori</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-medium text-gray-900 mb-2 serif">5,000+</div>
                <div class="text-xs uppercase tracking-widest text-gray-500">Pembaca</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-medium text-gray-900 mb-2 serif">4.9/5</div>
                <div class="text-xs uppercase tracking-widest text-gray-500">Rating</div>
            </div>
        </div>

        <!-- Categories Section -->
        <div class="mb-20">
            <div class="mb-12 text-center">
                <span class="text-xs font-medium uppercase tracking-widest text-gray-500 mb-2 block">Kategori</span>
                <h2 class="text-4xl md:text-5xl text-gray-900 font-medium serif italic">Telusuri Berdasarkan Minat</h2>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @forelse($categories ?? [] as $category)
                <a href="{{ route('login') }}" 
                   class="group p-8 border border-gray-100 hover:border-gray-300 transition-all bg-white hover:shadow-lg rounded-sm">
                    <div class="text-3xl mb-4">
                        @php
                            $categoryIcons = [
                                'Fiksi' => '📖',
                                'Non-Fiksi' => '📚',
                                'Pendidikan' => '🎓',
                                'Teknologi' => '💻',
                                'Bisnis' => '💼',
                                'Agama' => '🙏',
                                'Anak-anak' => '👶',
                                'Komik' => '🎨',
                                'Sejarah' => '🏛️',
                                'Biografi' => '👤',
                                'Sains' => '🔬',
                                'Novel' => '📕',
                                'Psikologi' => '🧠',
                                'Kesehatan' => '❤️',
                                'Seni' => '🎭',
                                'Musik' => '🎵',
                                'Olahraga' => '⚽',
                                'Masakan' => '🍳',
                                'Travel' => '✈️',
                                'Politik' => '⚖️',
                            ];
                            echo $categoryIcons[$category->name] ?? '📚';
                        @endphp
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-1 serif group-hover:underline decoration-1 underline-offset-4">{{ $category->name }}</h3>
                    <p class="text-xs uppercase tracking-wider text-gray-500">{{ $category->books_count ?? 0 }} buku</p>
                </a>
                @empty
                <div class="col-span-4 text-center py-12 text-gray-500">
                    Belum ada kategori
                </div>
                @endforelse
            </div>
        </div>

        <!-- Featured Books Section -->
        <div id="catalog" class="mb-20">
            <div class="flex justify-between items-end mb-12 border-b border-gray-100 pb-6">
                <div>
                    <span class="text-xs font-medium uppercase tracking-widest text-gray-500 mb-2 block">Koleksi Pilihan</span>
                    <h2 class="text-4xl md:text-5xl text-gray-900 font-medium serif italic">Buku Terbaru</h2>
                </div>
                <a href="{{ route('login') }}" class="text-xs font-medium uppercase tracking-widest text-gray-900 hover:underline decoration-1 underline-offset-4">
                    Lihat Semua →
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-8 gap-y-16">
                @forelse($books ?? [] as $book)
                <div class="group cursor-pointer">
                    <a href="{{ route('login') }}">
                        <div class="relative w-full aspect-[2/3] bg-[#F2F0E9] mb-6 book-card rounded-sm overflow-hidden">
                            @if($book->cover_photo)
                                <img src="{{ asset('storage/' . $book->cover_photo) }}" 
                                     alt="{{ $book->judul }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="absolute inset-4 border border-gray-900/10 flex flex-col items-center justify-center p-4 text-center">
                                    <div class="w-16 h-16 rounded-full border border-gray-900/20 mb-4 flex items-center justify-center">
                                        <span class="serif italic text-xl">{{ substr($book->judul, 0, 1) }}</span>
                                    </div>
                                    <span class="text-[10px] uppercase tracking-widest text-gray-400">{{ $book->pengarang }}</span>
                                </div>
                            @endif
                            
                            @if($book->stok < 5 && $book->stok > 0)
                                <div class="absolute top-4 left-0">
                                    <span class="bg-white text-gray-900 text-[10px] font-medium px-3 py-1 uppercase tracking-widest">Terbatas</span>
                                </div>
                            @elseif($book->stok == 0)
                                <div class="absolute top-4 left-0">
                                    <span class="bg-gray-900 text-white text-[10px] font-medium px-3 py-1 uppercase tracking-widest">Habis</span>
                                </div>
                            @endif

                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/5 transition-colors duration-300 flex items-end justify-between p-4 opacity-0 group-hover:opacity-100">
                                <span class="bg-white text-gray-900 text-[10px] font-bold px-2 py-1 uppercase tracking-wider">Quick View</span>
                            </div>
                        </div>
                    </a>
                    <div class="space-y-1">
                        <h3 class="text-lg text-gray-900 font-medium serif leading-tight group-hover:underline decoration-1 underline-offset-4">{{ $book->judul }}</h3>
                        <p class="text-xs uppercase tracking-wider text-gray-500">{{ $book->category->name ?? 'Uncategorized' }}</p>
                        <p class="text-sm font-medium text-gray-900 pt-1">Rp {{ number_format($book->harga, 0, ',', '.') }}</p>
                    </div>
                </div>
                @empty
                <div class="col-span-4 text-center py-12 text-gray-500">
                    Belum ada buku tersedia
                </div>
                @endforelse
            </div>

            @if(($books ?? collect())->count() > 0)
            <div class="text-center mt-16">
                <a href="{{ route('login') }}" 
                   class="inline-block bg-gray-900 text-white px-8 py-4 text-xs font-medium uppercase tracking-widest hover:bg-gray-800 transition-colors shadow-xl shadow-gray-200">
                    Login untuk Berbelanja
                </a>
            </div>
            @endif
        </div>

        <!-- CTA Section -->
        <div class="bg-gray-900 text-white rounded-lg p-12 md:p-16 text-center">
            <h2 class="text-4xl md:text-5xl font-medium serif italic mb-4">
                Mulai Perjalanan Literasi Anda
            </h2>
            <p class="text-gray-400 text-lg mb-8 max-w-2xl mx-auto font-light">
                Bergabunglah dengan ribuan pembaca yang telah menemukan buku favorit mereka di Z3LF.
            </p>
            <a href="{{ route('register') }}" 
               class="inline-block bg-white text-gray-900 px-8 py-4 text-xs font-medium uppercase tracking-widest hover:bg-gray-100 transition-colors">
                Daftar Sekarang
            </a>
        </div>
    </main>

    <!-- Footer -->
    <footer class="border-t border-gray-100 bg-white">
        <div class="max-w-7xl mx-auto py-16 px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                <div class="col-span-1">
                    <span class="text-xl font-bold tracking-widest text-gray-900 serif">Z3LF BOOKSTORE.</span>
                    <p class="mt-4 text-sm text-gray-500 font-light">Membawa dunia literasi ke ujung jari Anda.</p>
                </div>
                <div>
                    <h4 class="text-xs font-medium uppercase tracking-widest text-gray-900 mb-4">Belanja</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-gray-900 transition-colors">Semua Buku</a></li>
                        <li><a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-gray-900 transition-colors">Koleksi Terbaru</a></li>
                        <li><a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-gray-900 transition-colors">Best Sellers</a></li>
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

    <!-- WhatsApp Floating Button -->
    <a href="https://wa.me/6282211599226?text=Halo%20admin,%20saya%20ingin%20meminta%20bantuan" 
       target="_blank"
       class="fixed bottom-6 right-6 z-50 w-14 h-14 bg-green-500 hover:bg-green-600 text-white rounded-full flex items-center justify-center shadow-2xl hover:shadow-green-500/50 transition-all duration-300 hover:scale-110 group">
        <i class="fab fa-whatsapp text-3xl group-hover:scale-110 transition-transform"></i>
        <span class="absolute right-16 bg-gray-900 text-white px-4 py-2 rounded-sm text-xs uppercase tracking-widest whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
            Chat WhatsApp
        </span>
    </a>

</body>
</html>
