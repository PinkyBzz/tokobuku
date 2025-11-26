<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books Catalog - BookHaven</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Custom Select Dropdown Styling */
        select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
        }
        
        select:focus {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%233B82F6' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E");
        }
        
        select option {
            padding: 0.75rem 1rem;
            font-weight: 500;
        }
        
        select option:checked {
            background-color: #3B82F6;
            color: white;
        }
    </style>
</head>
<body class="font-inter bg-slate-50">
    <!-- Navigation -->
    <nav class="fixed w-full bg-white border-b border-slate-200 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('user.home') }}" class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center">
                        <i class="fas fa-book-open text-white text-sm"></i>
                    </div>
                    <span class="text-xl font-bold text-slate-900">BookHaven</span>
                </a>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('user.home') }}" class="text-slate-700 hover:text-primary transition-colors">Home</a>
                    <a href="{{ route('user.books.index') }}" class="text-primary font-medium">Books</a>
                    <a href="{{ route('user.cart.index') }}" class="relative text-slate-700 hover:text-primary transition-colors">
                        <i class="fas fa-shopping-cart"></i>
                    </a>
                </div>

                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <button onclick="toggleUserMenu()" class="flex items-center space-x-2 text-slate-700 hover:text-primary transition-colors">
                            @if(auth()->user()->photo)
                                <img src="{{ asset('storage/' . auth()->user()->photo) }}" 
                                     alt="{{ auth()->user()->name }}"
                                     class="w-8 h-8 rounded-full object-cover">
                            @else
                                <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm font-semibold">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </span>
                                </div>
                            @endif
                            <span class="hidden md:block font-medium">{{ auth()->user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        
                        <div id="userMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-slate-200 py-2">
                            <a href="#" class="block px-4 py-2 text-slate-700 hover:bg-slate-50">
                                <i class="fas fa-user mr-2"></i> Profile
                            </a>
                            <a href="#" class="block px-4 py-2 text-slate-700 hover:bg-slate-50">
                                <i class="fas fa-cog mr-2"></i> Settings
                            </a>
                            <hr class="my-2 border-slate-200">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-20 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-slate-900 mb-2">Books Catalog</h1>
                <p class="text-slate-600">Browse our collection of books</p>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded-xl mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <div class="grid lg:grid-cols-4 gap-8">
                <!-- Sidebar Filters -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl border border-slate-200 p-6 sticky top-24">
                        <h2 class="text-lg font-bold text-slate-900 mb-4">Filters</h2>
                        
                        <form method="GET" action="{{ route('user.books.index') }}" class="space-y-6">
                            <!-- Search -->
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    <i class="fas fa-search text-primary mr-1"></i> Search
                                </label>
                                <input type="text" 
                                       name="search" 
                                       value="{{ request('search') }}"
                                       placeholder="Title or Author..."
                                       class="w-full px-4 py-3 border-2 border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200 hover:border-primary/50">
                            </div>

                            <!-- Category Filter -->
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    <i class="fas fa-folder text-primary mr-1"></i> Category
                                </label>
                                <select name="category" 
                                        class="w-full px-4 py-3 border-2 border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200 text-slate-700 font-medium bg-white hover:border-primary/50 cursor-pointer">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }} ({{ $category->books_count }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Sort By -->
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    <i class="fas fa-sort text-primary mr-1"></i> Sort By
                                </label>
                                <select name="sort" 
                                        class="w-full px-4 py-3 border-2 border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200 text-slate-700 font-medium bg-white hover:border-primary/50 cursor-pointer">
                                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name (A-Z)</option>
                                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                                </select>
                            </div>

                            <!-- Filter Buttons -->
                            <div class="flex gap-2">
                                <button type="submit" class="flex-1 bg-primary hover:bg-primary-dark text-white font-semibold py-3 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-0.5">
                                    <i class="fas fa-filter mr-2"></i> Apply
                                </button>
                                <a href="{{ route('user.books.index') }}" 
                                   class="px-4 bg-slate-100 hover:bg-slate-200 text-slate-900 font-semibold py-3 rounded-lg transition-all duration-200 flex items-center justify-center shadow-sm hover:shadow-md transform hover:-translate-y-0.5">
                                    <i class="fas fa-redo"></i>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Books Grid -->
                <div class="lg:col-span-3">
                    <!-- Results Count -->
                    <div class="mb-6">
                        <p class="text-slate-600">
                            Showing <span class="font-semibold">{{ $books->count() }}</span> of <span class="font-semibold">{{ $books->total() }}</span> books
                        </p>
                    </div>

                    <!-- Books Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                        @forelse($books as $book)
                        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden hover:shadow-lg transition-shadow">
                            <!-- Book Cover -->
                            <a href="{{ route('user.books.show', $book->id) }}" class="block">
                                <div class="aspect-[3/4] bg-slate-100 relative">
                                    @if($book->cover_photo)
                                        <img src="{{ asset('storage/' . $book->cover_photo) }}" 
                                             alt="{{ $book->judul }}"
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <i class="fas fa-book text-slate-400 text-4xl"></i>
                                        </div>
                                    @endif
                                    
                                    @if($book->stok > 0)
                                        <span class="absolute top-2 right-2 bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-medium">
                                            In Stock
                                        </span>
                                    @else
                                        <span class="absolute top-2 right-2 bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs font-medium">
                                            Out of Stock
                                        </span>
                                    @endif
                                </div>
                            </a>

                            <!-- Book Info -->
                            <div class="p-4">
                                <a href="{{ route('user.books.show', $book->id) }}">
                                    <h3 class="font-bold text-slate-900 mb-2 line-clamp-2 hover:text-primary transition-colors">{{ $book->judul }}</h3>
                                </a>
                                <p class="text-sm text-slate-600 mb-2">by {{ $book->pengarang }}</p>
                                <p class="text-sm text-slate-500 mb-3">{{ $book->category->name ?? 'Uncategorized' }}</p>
                                
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-lg font-bold text-primary">
                                        Rp {{ number_format($book->harga, 0, ',', '.') }}
                                    </span>
                                    <span class="text-sm text-slate-500">
                                        Stock: {{ $book->stok }}
                                    </span>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex gap-2">
                                    @if($book->stok > 0)
                                        <form action="{{ route('user.cart.add', $book->id) }}" method="POST" class="flex-1">
                                            @csrf
                                            <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white px-4 py-2 rounded-lg transition-colors text-sm font-medium">
                                                <i class="fas fa-cart-plus mr-1"></i> Add to Cart
                                            </button>
                                        </form>
                                    @else
                                        <button class="flex-1 bg-slate-300 text-slate-500 px-4 py-2 rounded-lg text-sm font-medium cursor-not-allowed" disabled>
                                            Out of Stock
                                        </button>
                                    @endif
                                    <a href="{{ route('user.books.show', $book->id) }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-lg transition-colors">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-3 text-center py-12 bg-white rounded-xl border border-slate-200">
                            <i class="fas fa-book-open text-slate-400 text-5xl mb-4"></i>
                            <p class="text-slate-600 mb-2">No books found</p>
                            <p class="text-slate-500 text-sm">Try adjusting your filters or search terms</p>
                        </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($books->hasPages())
                    <div class="flex justify-center">
                        {{ $books->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </main>

    <script>
        function toggleUserMenu() {
            const menu = document.getElementById('userMenu');
            menu.classList.toggle('hidden');
        }

        document.addEventListener('click', function(event) {
            const userMenu = document.getElementById('userMenu');
            const button = event.target.closest('button');
            
            if (!button || !button.onclick) {
                if (userMenu && !userMenu.classList.contains('hidden')) {
                    userMenu.classList.add('hidden');
                }
            }
        });
    </script>
</body>
</html>
