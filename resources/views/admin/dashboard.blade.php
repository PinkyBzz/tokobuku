@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6 lg:space-y-8">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
        <!-- Total Orders -->
        <div class="bg-white border border-gray-100 rounded-sm p-4 lg:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-widest text-gray-500 mb-2">Total Orders</p>
                    <p class="text-2xl lg:text-3xl font-medium text-gray-900 serif">{{ $totalOrders }}</p>
                </div>
                <div class="w-10 h-10 lg:w-12 lg:h-12 bg-gray-50 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-shopping-cart text-gray-900 text-sm lg:text-base"></i>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="bg-white border border-gray-100 rounded-sm p-4 lg:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-widest text-gray-500 mb-2">Total Revenue</p>
                    <p class="text-xl lg:text-2xl font-medium text-gray-900 serif">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                </div>
                <div class="w-10 h-10 lg:w-12 lg:h-12 bg-gray-50 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-dollar-sign text-gray-900 text-sm lg:text-base"></i>
                </div>
            </div>
        </div>

        <!-- Total Books -->
        <div class="bg-white border border-gray-100 rounded-sm p-4 lg:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-widest text-gray-500 mb-2">Total Books</p>
                    <p class="text-2xl lg:text-3xl font-medium text-gray-900 serif">{{ $totalBooks }}</p>
                </div>
                <div class="w-10 h-10 lg:w-12 lg:h-12 bg-gray-50 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-book text-gray-900 text-sm lg:text-base"></i>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div class="bg-white border border-gray-100 rounded-sm p-4 lg:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-widest text-gray-500 mb-2">Total Users</p>
                    <p class="text-2xl lg:text-3xl font-medium text-gray-900 serif">{{ $totalUsers }}</p>
                </div>
                <div class="w-10 h-10 lg:w-12 lg:h-12 bg-gray-50 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-users text-gray-900 text-sm lg:text-base"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-4 lg:gap-8">
        <!-- Recent Orders -->
        <div class="bg-white border border-gray-100 rounded-sm p-4 lg:p-8">
            <div class="flex items-center justify-between mb-4 lg:mb-6">
                <h2 class="text-lg lg:text-xl font-medium text-gray-900 serif italic">Recent Orders</h2>
                <a href="{{ route('admin.orders.index') }}" class="text-xs uppercase tracking-widest text-gray-500 hover:text-gray-900">View All</a>
            </div>

            <div class="space-y-3 lg:space-y-4 overflow-x-auto">
                @forelse($recentOrders as $order)
                    <div class="flex items-center justify-between py-3 lg:py-4 border-b border-gray-100 last:border-0 min-w-[300px]">
                        <div>
                            <p class="text-sm font-medium text-gray-900">#{{ $order->invoice_number }}</p>
                            <p class="text-xs text-gray-500 font-light mt-1">{{ $order->user->name }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-900">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                            <span class="inline-block mt-1 px-2 lg:px-3 py-1 text-[10px] lg:text-xs uppercase tracking-widest rounded-full
                                @if($order->status == 'pending') bg-yellow-50 text-yellow-700
                                @elseif($order->status == 'paid') bg-blue-50 text-blue-700
                                @elseif($order->status == 'processed') bg-purple-50 text-purple-700
                                @elseif($order->status == 'shipped') bg-indigo-50 text-indigo-700
                                @elseif($order->status == 'delivered') bg-green-50 text-green-700
                                @else bg-red-50 text-red-700
                                @endif">
                                {{ $order->status }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 font-light text-center py-8">No recent orders</p>
                @endforelse
            </div>
        </div>

        <!-- Low Stock Books -->
        <div class="bg-white border border-gray-100 rounded-sm p-4 lg:p-8">
            <div class="flex items-center justify-between mb-4 lg:mb-6">
                <h2 class="text-lg lg:text-xl font-medium text-gray-900 serif italic">Low Stock Alert</h2>
                <a href="{{ route('admin.books.index') }}" class="text-xs uppercase tracking-widest text-gray-500 hover:text-gray-900">View All</a>
            </div>

            <div class="space-y-3 lg:space-y-4">
                @forelse($lowStockBooks as $book)
                    <div class="flex items-center gap-3 lg:gap-4 py-3 lg:py-4 border-b border-gray-100 last:border-0">
                        <img src="{{ asset('storage/' . $book->cover_photo) }}" alt="{{ $book->judul }}" class="w-10 h-14 lg:w-12 lg:h-16 object-cover border border-gray-100 flex-shrink-0">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $book->judul }}</p>
                            <p class="text-xs text-gray-500 font-light mt-1 truncate">{{ $book->pengarang }}</p>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <span class="inline-block px-2 lg:px-3 py-1 text-[10px] lg:text-xs font-medium rounded-full
                                @if($book->stok == 0) bg-red-50 text-red-700
                                @elseif($book->stok <= 5) bg-orange-50 text-orange-700
                                @else bg-yellow-50 text-yellow-700
                                @endif">
                                {{ $book->stok }} left
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 font-light text-center py-8">All books are well stocked</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Order Status Chart -->
    <div class="bg-white border border-gray-100 rounded-sm p-4 lg:p-8">
        <h2 class="text-lg lg:text-xl font-medium text-gray-900 serif italic mb-4 lg:mb-6">Orders by Status</h2>
        
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 lg:gap-4">
            @foreach($ordersByStatus as $status => $count)
                <div class="text-center p-3 lg:p-4 border border-gray-100 rounded-sm">
                    <p class="text-xl lg:text-2xl font-medium text-gray-900 serif">{{ $count }}</p>
                    <p class="text-[10px] lg:text-xs uppercase tracking-widest text-gray-500 mt-1 lg:mt-2">{{ $status }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
