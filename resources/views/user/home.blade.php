@extends('layouts.user')

@section('title', 'My Dashboard - Z3LF Bookstore')

@section('content')
<!-- Hero Dashboard Section -->
<div class="pt-24 lg:pt-32 pb-12 lg:pb-20 bg-gradient-to-b from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <!-- Personal Welcome -->
        <div class="mb-8 lg:mb-12">
            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                <div>
                    <p class="text-xs uppercase tracking-widest text-gray-500 mb-3">Your Personal Library</p>
                    <h1 class="text-4xl lg:text-6xl font-medium text-gray-900 serif mb-4">
                        Welcome back,<br><i class="italic text-gray-600">{{ auth()->user()->name }}</i>
                    </h1>
                    <p class="text-gray-600 font-light max-w-xl">Continue your reading journey with curated collections handpicked for discerning readers.</p>
                </div>
                <div class="flex gap-4">
                    <a href="{{ route('user.books.index') }}" class="bg-gray-900 text-white px-6 lg:px-8 py-3 lg:py-4 text-xs uppercase tracking-widest hover:bg-gray-800 transition-colors shadow-xl shadow-gray-200">
                        Browse Catalog
                    </a>
                    <a href="{{ route('user.orders.index') }}" class="border border-gray-200 text-gray-900 px-6 lg:px-8 py-3 lg:py-4 text-xs uppercase tracking-widest hover:border-gray-900 transition-colors">
                        My Orders
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats Overview - Luxury Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-12 lg:mb-16">
            <!-- Total Orders -->
            <div class="bg-white border border-gray-100 rounded-sm p-6 lg:p-8 hover:shadow-lg transition-all group">
                <div class="mb-6">
                    <div class="w-12 h-12 bg-gray-50 rounded-sm flex items-center justify-center group-hover:bg-gray-900 transition-colors">
                        <i class="fas fa-shopping-bag text-gray-900 group-hover:text-white text-lg transition-colors"></i>
                    </div>
                </div>
                <div class="text-3xl lg:text-4xl font-medium text-gray-900 serif mb-2">{{ $totalOrders }}</div>
                <div class="text-xs uppercase tracking-widest text-gray-500">Total Orders</div>
            </div>

            <!-- Pending Orders -->
            <div class="bg-white border border-gray-100 rounded-sm p-6 lg:p-8 hover:shadow-lg transition-all group">
                <div class="mb-6">
                    <div class="w-12 h-12 bg-gray-50 rounded-sm flex items-center justify-center group-hover:bg-gray-900 transition-colors">
                        <i class="fas fa-clock text-gray-900 group-hover:text-white text-lg transition-colors"></i>
                    </div>
                </div>
                <div class="text-3xl lg:text-4xl font-medium text-gray-900 serif mb-2">{{ $pendingOrders }}</div>
                <div class="text-xs uppercase tracking-widest text-gray-500">Pending</div>
            </div>

            <!-- Completed Orders -->
            <div class="bg-white border border-gray-100 rounded-sm p-6 lg:p-8 hover:shadow-lg transition-all group">
                <div class="mb-6">
                    <div class="w-12 h-12 bg-gray-50 rounded-sm flex items-center justify-center group-hover:bg-gray-900 transition-colors">
                        <i class="fas fa-check-circle text-gray-900 group-hover:text-white text-lg transition-colors"></i>
                    </div>
                </div>
                <div class="text-3xl lg:text-4xl font-medium text-gray-900 serif mb-2">{{ $completedOrders }}</div>
                <div class="text-xs uppercase tracking-widest text-gray-500">Completed</div>
            </div>

            <!-- Cart Items -->
            <div class="bg-white border border-gray-100 rounded-sm p-6 lg:p-8 hover:shadow-lg transition-all group">
                <div class="mb-6">
                    <div class="w-12 h-12 bg-gray-50 rounded-sm flex items-center justify-center group-hover:bg-gray-900 transition-colors">
                        <i class="fas fa-shopping-cart text-gray-900 group-hover:text-white text-lg transition-colors"></i>
                    </div>
                </div>
                <div class="text-3xl lg:text-4xl font-medium text-gray-900 serif mb-2">{{ $cartItemsCount }}</div>
                <div class="text-xs uppercase tracking-widest text-gray-500">In Cart</div>
            </div>
        </div>
    </div>
</div>

<!-- Categories Section -->
<div class="py-12 lg:py-20 bg-white border-y border-gray-100">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="mb-8 lg:mb-12 text-center">
            <p class="text-xs uppercase tracking-widest text-gray-500 mb-4">Explore by Genre</p>
            <h2 class="text-3xl lg:text-5xl font-medium text-gray-900 serif italic">Curated Collections</h2>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 lg:gap-6">
            @forelse($categories as $category)
            <a href="{{ route('user.books.index', ['category' => $category->id]) }}" class="bg-gray-50 border border-gray-100 rounded-sm p-6 hover:bg-white hover:border-gray-900 hover:shadow-lg transition-all group text-center">
                <div class="w-12 h-12 bg-white border border-gray-100 rounded-sm flex items-center justify-center mx-auto mb-4 group-hover:bg-gray-900 group-hover:border-gray-900 transition-all">
                    @php
                        $categoryIcons = [
                            'Fiksi' => 'fa-book-open',
                            'Non-Fiksi' => 'fa-graduation-cap',
                            'Pendidikan' => 'fa-school',
                            'Teknologi' => 'fa-laptop-code',
                            'Bisnis' => 'fa-briefcase',
                            'Agama' => 'fa-praying-hands',
                            'Anak-anak' => 'fa-child',
                            'Komik' => 'fa-dragon',
                            'Sejarah' => 'fa-landmark',
                            'Biografi' => 'fa-user-circle',
                            'Sains' => 'fa-flask',
                            'Novel' => 'fa-feather',
                            'Psikologi' => 'fa-brain',
                            'Kesehatan' => 'fa-heartbeat',
                            'Seni' => 'fa-palette',
                            'Musik' => 'fa-music',
                            'Olahraga' => 'fa-futbol',
                            'Masakan' => 'fa-utensils',
                            'Travel' => 'fa-plane',
                            'Politik' => 'fa-balance-scale',
                        ];
                        $icon = $categoryIcons[$category->name] ?? 'fa-bookmark';
                    @endphp
                    <i class="fas {{ $icon }} text-gray-400 group-hover:text-white transition-colors"></i>
                </div>
                <h3 class="text-sm font-medium text-gray-900 mb-2 uppercase tracking-widest">{{ $category->name }}</h3>
                <p class="text-xs text-gray-500 font-light">{{ $category->books_count ?? 0 }} Books</p>
            </a>
            @empty
            <div class="col-span-6 text-center py-16 text-gray-500">
                <i class="fas fa-folder-open text-5xl mb-4 text-gray-300"></i>
                <p class="text-sm font-light">No categories available</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Latest Books Section -->
<div class="py-12 lg:py-20 bg-[#fcfcfc]">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="flex items-end justify-between mb-8 lg:mb-12 border-b border-gray-100 pb-6">
            <div>
                <p class="text-xs uppercase tracking-widest text-gray-500 mb-4">New Arrivals</p>
                <h2 class="text-3xl lg:text-5xl font-medium text-gray-900 serif italic">Latest Editions</h2>
            </div>
            <a href="{{ route('user.books.index', ['sort' => 'latest']) }}" class="text-xs uppercase tracking-widest text-gray-500 hover:text-gray-900 border-b border-gray-900 pb-1 hidden lg:block">
                View All Books →
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
            @forelse($latestBooks as $book)
            <div class="bg-white border border-gray-100 rounded-sm overflow-hidden hover:shadow-2xl hover:shadow-gray-200 transition-all duration-500 book-card group">
                <!-- Book Cover -->
                <div class="aspect-[3/4] bg-gray-50 relative overflow-hidden">
                    @if($book->cover_photo)
                        <img src="{{ asset('storage/' . $book->cover_photo) }}" 
                             alt="{{ $book->judul }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <i class="fas fa-book text-gray-300 text-5xl"></i>
                        </div>
                    @endif
                    
                    @if($book->stok > 0)
                        <span class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm text-gray-900 px-3 py-1 text-xs uppercase tracking-widest font-medium">
                            Available
                        </span>
                    @else
                        <span class="absolute top-4 right-4 bg-gray-900/90 backdrop-blur-sm text-white px-3 py-1 text-xs uppercase tracking-widest font-medium">
                            Sold Out
                        </span>
                    @endif
                </div>

                <!-- Book Info -->
                <div class="p-6">
                    <p class="text-xs uppercase tracking-widest text-gray-500 mb-2">{{ $book->category->name ?? 'Uncategorized' }}</p>
                    <h3 class="font-medium text-gray-900 mb-2 leading-tight serif text-lg line-clamp-2">{{ $book->judul }}</h3>
                    <p class="text-sm text-gray-600 font-light mb-4">by {{ $book->pengarang }}</p>
                    
                    <div class="flex items-center justify-between mb-6 pt-4 border-t border-gray-100">
                        <span class="text-xl font-medium text-gray-900 serif">
                            Rp {{ number_format($book->harga, 0, ',', '.') }}
                        </span>
                        <span class="text-xs text-gray-500 font-light">
                            {{ $book->stok }} in stock
                        </span>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3">
                        <form action="{{ route('user.cart.add', $book->id) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full bg-gray-900 hover:bg-gray-800 text-white px-4 py-3 transition-colors text-xs uppercase tracking-widest shadow-lg shadow-gray-200">
                                Add to Cart
                            </button>
                        </form>
                        <a href="{{ route('user.books.show', $book->id) }}" class="bg-white border border-gray-200 hover:border-gray-900 text-gray-900 px-4 py-3 transition-colors flex items-center justify-center">
                            <i class="fas fa-eye text-sm"></i>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-4 text-center py-16 bg-white border border-gray-100 rounded-sm">
                <i class="fas fa-book-open text-gray-300 text-6xl mb-6"></i>
                <p class="text-gray-600 font-light">No books available at the moment</p>
            </div>
            @endforelse
        </div>

        <div class="text-center mt-12 lg:hidden">
            <a href="{{ route('user.books.index') }}" class="inline-block bg-gray-900 text-white px-8 py-4 text-xs uppercase tracking-widest hover:bg-gray-800 transition-colors shadow-xl shadow-gray-200">
                View All Books
            </a>
        </div>
    </div>
</div>
@endsection
