@extends('layouts.user')

@section('content')
<div class="pt-28 pb-20 max-w-7xl mx-auto px-6 lg:px-8">
    
    <!-- Page Header -->
    <div class="mb-12">
        <span class="text-xs font-medium uppercase tracking-widest text-gray-500 mb-2 block">Katalog</span>
        <h1 class="text-5xl md:text-6xl text-gray-900 font-medium serif italic mb-4">Koleksi Lengkap</h1>
        <p class="text-gray-500 text-lg font-light max-w-2xl">Telusuri katalog lengkap kami yang dikurasi dengan cermat untuk pembaca yang cerdas.</p>
    </div>

    <div class="flex flex-col lg:flex-row gap-16">
        
        <!-- Refined Sidebar -->
        <aside class="w-full lg:w-60 flex-shrink-0 hidden lg:block sticky top-32 h-fit space-y-12">
            <div>
                <h3 class="serif text-xl text-gray-900 mb-6 italic">Kategori</h3>
                <form method="GET" action="{{ route('user.books.index') }}">
                    <ul class="space-y-4">
                        <li>
                            <button type="submit" name="category" value="" class="group flex items-center justify-between text-sm {{ request('category') == '' ? 'text-gray-900 font-medium' : 'text-gray-500 hover:text-gray-900' }} transition-colors w-full text-left">
                                <span class="border-b {{ request('category') == '' ? 'border-gray-900' : 'border-transparent group-hover:border-gray-900' }} pb-0.5 transition-all">Semua Buku</span>
                                <span class="text-xs {{ request('category') == '' ? 'text-gray-900' : 'text-gray-300' }}">{{ $totalBooks }}</span>
                            </button>
                        </li>
                        @foreach($categories as $category)
                        <li>
                            <button type="submit" name="category" value="{{ $category->id }}" class="group flex items-center justify-between text-sm {{ request('category') == $category->id ? 'text-gray-900 font-medium' : 'text-gray-500 hover:text-gray-900' }} transition-colors w-full text-left">
                                <span class="border-b {{ request('category') == $category->id ? 'border-gray-900' : 'border-transparent group-hover:border-gray-900' }} pb-0.5 transition-all">{{ $category->name }}</span>
                                <span class="text-xs {{ request('category') == $category->id ? 'text-gray-900' : 'text-gray-300' }}">{{ $category->books_count }}</span>
                            </button>
                        </li>
                        @endforeach
                    </ul>
                </form>
            </div>

            <div>
                <h3 class="serif text-xl text-gray-900 mb-6 italic">Urutkan</h3>
                <form method="GET" action="{{ route('user.books.index') }}" class="space-y-4">
                    <input type="hidden" name="category" value="{{ request('category') }}">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <button type="submit" name="sort" value="latest" class="block w-full text-left text-sm {{ request('sort', 'latest') == 'latest' ? 'text-gray-900 font-medium' : 'text-gray-500 hover:text-gray-900' }} transition-colors">Terbaru</button>
                    <button type="submit" name="sort" value="name" class="block w-full text-left text-sm {{ request('sort') == 'name' ? 'text-gray-900 font-medium' : 'text-gray-500 hover:text-gray-900' }} transition-colors">Nama (A-Z)</button>
                    <button type="submit" name="sort" value="price_low" class="block w-full text-left text-sm {{ request('sort') == 'price_low' ? 'text-gray-900 font-medium' : 'text-gray-500 hover:text-gray-900' }} transition-colors">Harga: Rendah ke Tinggi</button>
                    <button type="submit" name="sort" value="price_high" class="block w-full text-left text-sm {{ request('sort') == 'price_high' ? 'text-gray-900 font-medium' : 'text-gray-500 hover:text-gray-900' }} transition-colors">Harga: Tinggi ke Rendah</button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Toolbar -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10 border-b border-gray-100 pb-6">
                <p class="text-sm text-gray-500 font-light">
                    Menampilkan <span class="text-gray-900 font-medium">{{ $books->count() }}</span> dari <span class="text-gray-900 font-medium">{{ $books->total() }}</span> buku
                </p>
                
                <!-- Search -->
                <form method="GET" action="{{ route('user.books.index') }}" class="flex gap-2 w-full md:w-auto">
                    <input type="hidden" name="category" value="{{ request('category') }}">
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Cari judul atau penulis..."
                           class="flex-1 md:w-64 px-4 py-3 bg-white border border-gray-200 text-sm font-light focus:outline-none focus:border-gray-900 transition-all">
                    <button type="submit" class="bg-gray-900 text-white px-6 py-3 hover:bg-gray-800 transition-colors">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>

            <!-- Books Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-16">
                @forelse($books as $book)
                <div class="group cursor-pointer">
                    <a href="{{ route('user.books.show', $book->id) }}">
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
                                @if($book->stok > 0)
                                <button onclick="event.preventDefault(); addToCart({{ $book->id }})" class="bg-gray-900 text-white p-2 rounded-full hover:scale-110 transition-transform">
                                    <i class="fas fa-plus w-4 h-4"></i>
                                </button>
                                @endif
                            </div>
                        </div>
                    </a>
                    <div class="space-y-1">
                        <h3 class="text-lg text-gray-900 font-medium serif leading-tight group-hover:underline decoration-1 underline-offset-4">{{ $book->judul }}</h3>
                        <p class="text-xs uppercase tracking-wider text-gray-500">{{ $book->category->name ?? 'Uncategorized' }}</p>
                        <p class="text-sm font-light text-gray-600">{{ $book->pengarang }}</p>
                        <p class="text-sm font-medium text-gray-900 pt-1">Rp {{ number_format($book->harga, 0, ',', '.') }}</p>
                    </div>
                </div>
                @empty
                <div class="col-span-3 text-center py-20">
                    <div class="w-24 h-24 rounded-full border-2 border-gray-100 mx-auto mb-6 flex items-center justify-center">
                        <i class="fas fa-book text-3xl text-gray-300"></i>
                    </div>
                    <h3 class="text-xl text-gray-900 font-medium serif mb-2">Tidak Ada Buku</h3>
                    <p class="text-gray-500 font-light">Tidak ada buku yang sesuai dengan pencarian Anda.</p>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($books->hasPages())
            <div class="mt-16 flex justify-center">
                <nav class="flex items-center space-x-2">
                    @if ($books->onFirstPage())
                        <span class="p-3 border border-gray-100 text-gray-300 cursor-not-allowed">
                            <i class="fas fa-chevron-left w-3 h-3"></i>
                        </span>
                    @else
                        <a href="{{ $books->previousPageUrl() }}" class="p-3 border border-gray-200 text-gray-900 hover:border-gray-900 transition-colors">
                            <i class="fas fa-chevron-left w-3 h-3"></i>
                        </a>
                    @endif

                    @foreach ($books->getUrlRange(1, $books->lastPage()) as $page => $url)
                        @if ($page == $books->currentPage())
                            <span class="px-4 py-3 border border-gray-900 bg-gray-900 text-white text-xs font-medium uppercase tracking-widest">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="px-4 py-3 border border-gray-200 text-gray-600 text-xs font-medium uppercase tracking-widest hover:border-gray-900 hover:text-gray-900 transition-all">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if ($books->hasMorePages())
                        <a href="{{ $books->nextPageUrl() }}" class="p-3 border border-gray-200 text-gray-900 hover:border-gray-900 transition-colors">
                            <i class="fas fa-chevron-right w-3 h-3"></i>
                        </a>
                    @else
                        <span class="p-3 border border-gray-100 text-gray-300 cursor-not-allowed">
                            <i class="fas fa-chevron-right w-3 h-3"></i>
                        </span>
                    @endif
                </nav>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    .book-card {
        transition: transform 0.4s cubic-bezier(0.25, 1, 0.5, 1), box-shadow 0.4s ease;
    }
    .book-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 40px -4px rgba(0, 0, 0, 0.1);
    }
</style>

<script>
function addToCart(bookId) {
    fetch(`/user/cart/add/${bookId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Buku berhasil ditambahkan ke keranjang!');
        } else {
            alert(data.message || 'Gagal menambahkan buku ke keranjang');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat menambahkan buku ke keranjang');
    });
}
</script>
@endsection
