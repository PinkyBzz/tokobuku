@extends('layouts.admin')

@section('title', 'Manage Books')
@section('page-title', 'Manage Books')

@section('content')
<div class="space-y-4 lg:space-y-6">
    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <p class="text-sm text-gray-500 font-light">Total {{ $books->total() }} books</p>
        </div>
        <a href="{{ route('admin.books.create') }}" 
           class="bg-gray-900 hover:bg-gray-800 text-white px-4 lg:px-6 py-3 transition-colors text-xs uppercase tracking-widest shadow-xl shadow-gray-200 text-center">
            <i class="fas fa-plus mr-2"></i> Add New Book
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white border border-gray-100 rounded-sm p-4 lg:p-6">
        <form method="GET" action="{{ route('admin.books.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label class="block text-xs font-medium uppercase tracking-widest text-gray-900 mb-2">Search</label>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Title or author..."
                       class="w-full px-4 py-3 bg-white border border-gray-200 text-sm font-light focus:outline-none focus:border-gray-900 transition-all">
            </div>
            <div>
                <label class="block text-xs font-medium uppercase tracking-widest text-gray-900 mb-2">Category</label>
                <select name="category" 
                        class="w-full px-4 py-3 bg-white border border-gray-200 text-sm font-light focus:outline-none focus:border-gray-900 transition-all">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium uppercase tracking-widest text-gray-900 mb-2">Stock Status</label>
                <select name="stock_status" 
                        class="w-full px-4 py-3 bg-white border border-gray-200 text-sm font-light focus:outline-none focus:border-gray-900 transition-all">
                    <option value="">All</option>
                    <option value="in_stock" {{ request('stock_status') == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                    <option value="low_stock" {{ request('stock_status') == 'low_stock' ? 'selected' : '' }}>Low Stock</option>
                    <option value="out_of_stock" {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                </select>
            </div>
            <div class="flex items-end gap-2 sm:col-span-2 lg:col-span-1">
                <button type="submit" 
                        class="flex-1 bg-gray-900 hover:bg-gray-800 text-white px-4 py-3 transition-colors text-xs uppercase tracking-widest">
                    Filter
                </button>
                <a href="{{ route('admin.books.index') }}" 
                   class="px-4 py-3 bg-white border border-gray-200 hover:border-gray-900 text-gray-900 text-xs uppercase tracking-widest transition-colors">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Books Table (Desktop) -->
    <div class="hidden lg:block bg-white border border-gray-100 rounded-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-widest text-gray-900">Book</th>
                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-widest text-gray-900">Category</th>
                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-widest text-gray-900">Price</th>
                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-widest text-gray-900">Stock</th>
                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-widest text-gray-900">Status</th>
                        <th class="px-6 py-4 text-right text-xs font-medium uppercase tracking-widest text-gray-900">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($books as $book)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <img src="{{ asset('storage/' . $book->cover_photo) }}" 
                                         alt="{{ $book->judul }}" 
                                         class="w-12 h-16 object-cover border border-gray-100">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ Str::limit($book->judul, 40) }}</p>
                                        <p class="text-xs text-gray-500 font-light mt-1">{{ $book->pengarang }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-600 font-light">{{ $book->category->name }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm font-medium text-gray-900">Rp {{ number_format($book->harga, 0, ',', '.') }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-block px-3 py-1 text-xs font-medium rounded-full
                                    @if($book->stok == 0) bg-red-50 text-red-700
                                    @elseif($book->stok <= 10) bg-orange-50 text-orange-700
                                    @else bg-green-50 text-green-700
                                    @endif">
                                    {{ $book->stok }} pcs
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-block px-3 py-1 text-xs uppercase tracking-widest rounded-full
                                    @if($book->stok > 0) bg-green-50 text-green-700
                                    @else bg-gray-100 text-gray-600
                                    @endif">
                                    {{ $book->stok > 0 ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.books.edit', $book) }}" 
                                       class="px-3 py-2 text-xs uppercase tracking-widest text-gray-600 hover:text-gray-900 border border-gray-200 hover:border-gray-900 transition-colors">
                                        Edit
                                    </a>
                                    <form method="POST" 
                                          action="{{ route('admin.books.destroy', $book) }}" 
                                          onsubmit="return confirm('Are you sure you want to delete this book?');"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="px-3 py-2 text-xs uppercase tracking-widest text-red-600 hover:text-red-800 border border-red-200 hover:border-red-600 transition-colors">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <p class="text-sm text-gray-500 font-light">No books found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($books->hasPages())
            <div class="border-t border-gray-100 px-6 py-4">
                {{ $books->links() }}
            </div>
        @endif
    </div>

    <!-- Books Cards (Mobile) -->
    <div class="lg:hidden space-y-4">
        @forelse($books as $book)
            <div class="bg-white border border-gray-100 rounded-sm p-4">
                <div class="flex gap-4">
                    <img src="{{ asset('storage/' . $book->cover_photo) }}" 
                         alt="{{ $book->judul }}" 
                         class="w-20 h-28 object-cover border border-gray-100 flex-shrink-0">
                    <div class="flex-1 min-w-0">
                        <h3 class="text-sm font-medium text-gray-900 mb-1">{{ $book->judul }}</h3>
                        <p class="text-xs text-gray-500 font-light mb-2">{{ $book->pengarang }}</p>
                        
                        <div class="space-y-2 mb-3">
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-gray-500">Category:</span>
                                <span class="text-gray-900">{{ $book->category->name }}</span>
                            </div>
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-gray-500">Price:</span>
                                <span class="text-gray-900 font-medium">Rp {{ number_format($book->harga, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-gray-500">Stock:</span>
                                <span class="inline-block px-2 py-1 text-[10px] font-medium rounded-full
                                    @if($book->stok == 0) bg-red-50 text-red-700
                                    @elseif($book->stok <= 10) bg-orange-50 text-orange-700
                                    @else bg-green-50 text-green-700
                                    @endif">
                                    {{ $book->stok }} pcs
                                </span>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ route('admin.books.edit', $book) }}" 
                               class="flex-1 text-center px-3 py-2 text-xs uppercase tracking-widest text-gray-600 hover:text-gray-900 border border-gray-200 hover:border-gray-900 transition-colors">
                                Edit
                            </a>
                            <form method="POST" 
                                  action="{{ route('admin.books.destroy', $book) }}" 
                                  onsubmit="return confirm('Are you sure you want to delete this book?');"
                                  class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-full px-3 py-2 text-xs uppercase tracking-widest text-red-600 hover:text-red-800 border border-red-200 hover:border-red-600 transition-colors">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white border border-gray-100 rounded-sm p-8 text-center">
                <p class="text-sm text-gray-500 font-light">No books found</p>
            </div>
        @endforelse

        <!-- Pagination -->
        @if($books->hasPages())
            <div class="bg-white border border-gray-100 rounded-sm px-4 py-4">
                {{ $books->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
