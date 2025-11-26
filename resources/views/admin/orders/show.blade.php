@extends('layouts.admin')

@section('title', 'Order Detail')
@section('page-title', 'Order #' . $order->invoice_number)

@section('content')
<div class="space-y-6">
    <!-- Back Button -->
    <div>
        <a href="{{ route('admin.orders.index') }}" 
           class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            <span class="uppercase tracking-widest text-xs">Back to Orders</span>
        </a>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Order Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Status -->
            <div class="bg-white border border-gray-100 rounded-sm p-8">
                <h2 class="text-xl font-medium text-gray-900 serif italic mb-6">Order Status</h2>
                
                <!-- Status Update Form -->
                <form method="POST" action="{{ route('admin.orders.update-status', $order) }}" class="mb-8">
                    @csrf
                    @method('PATCH')
                    <div class="flex gap-4">
                        <select name="status" 
                                class="flex-1 px-4 py-3 bg-white border border-gray-200 text-sm font-light focus:outline-none focus:border-gray-900 transition-all">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending Payment</option>
                            <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="processed" {{ $order->status == 'processed' ? 'selected' : '' }}>Processing</option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <button type="submit" 
                                class="bg-gray-900 hover:bg-gray-800 text-white px-6 py-3 transition-colors text-xs uppercase tracking-widest">
                            Update Status
                        </button>
                    </div>
                </form>

                <!-- Progress Bar -->
                <div class="relative">
                    <div class="flex justify-between mb-2">
                        @php
                            $statuses = ['pending', 'paid', 'processed', 'shipped', 'delivered'];
                            $currentIndex = array_search($order->status, $statuses);
                        @endphp
                        @foreach($statuses as $index => $status)
                            <div class="flex flex-col items-center" style="width: 20%;">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center mb-2
                                    @if($index <= $currentIndex) bg-gray-900 text-white
                                    @else bg-gray-100 text-gray-400
                                    @endif">
                                    @if($index < $currentIndex)
                                        <i class="fas fa-check text-xs"></i>
                                    @else
                                        <span class="text-xs">{{ $index + 1 }}</span>
                                    @endif
                                </div>
                                <span class="text-xs uppercase tracking-widest text-gray-600 text-center">{{ $status }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="absolute top-4 left-0 right-0 h-0.5 bg-gray-100 -z-10" style="width: 100%; margin: 0 10%;">
                        <div class="h-full bg-gray-900 transition-all" style="width: {{ ($currentIndex / (count($statuses) - 1)) * 100 }}%;"></div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="bg-white border border-gray-100 rounded-sm p-8">
                <h2 class="text-xl font-medium text-gray-900 serif italic mb-6">Order Items</h2>
                
                <div class="space-y-4">
                    @foreach($order->items as $item)
                        <div class="flex gap-4 py-4 border-b border-gray-100 last:border-0">
                            <img src="{{ asset('storage/' . $item->book->cover_image) }}" 
                                 alt="{{ $item->book->title }}" 
                                 class="w-16 h-24 object-cover border border-gray-100 flex-shrink-0">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">{{ $item->book->title }}</p>
                                <p class="text-xs text-gray-500 font-light mt-1">{{ $item->book->author }}</p>
                                <p class="text-xs text-gray-500 font-light mt-2">Qty: {{ $item->quantity }} × Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Shipping Address -->
            <div class="bg-white border border-gray-100 rounded-sm p-8">
                <h2 class="text-xl font-medium text-gray-900 serif italic mb-6">Shipping Address</h2>
                
                <div class="space-y-2 text-sm text-gray-600 font-light">
                    <p class="font-medium text-gray-900">{{ $order->user->name }}</p>
                    <p>{{ $order->alamat_lengkap }}</p>
                    <p>{{ $order->kota }}, {{ $order->provinsi }} {{ $order->kode_pos }}</p>
                    @if($order->catatan)
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <p class="text-xs uppercase tracking-widest text-gray-500 mb-1">Notes:</p>
                            <p class="italic">{{ $order->catatan }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Payment Proof -->
            @if($order->payment_proof)
                <div class="bg-white border border-gray-100 rounded-sm p-8">
                    <h2 class="text-xl font-medium text-gray-900 serif italic mb-6">Payment Proof</h2>
                    <img src="{{ asset('storage/' . $order->payment_proof) }}" 
                         alt="Payment Proof" 
                         class="max-w-md border border-gray-100 rounded-sm">
                </div>
            @endif
        </div>

        <!-- Order Summary Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white border border-gray-100 rounded-sm p-8 lg:sticky lg:top-28">
                <h2 class="text-xl font-medium text-gray-900 serif italic mb-6">Order Summary</h2>
                
                <div class="space-y-4">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 font-light">Invoice Number</span>
                        <span class="font-medium text-gray-900">#{{ $order->invoice_number }}</span>
                    </div>

                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 font-light">Order Date</span>
                        <span class="font-medium text-gray-900">{{ $order->created_at->format('d M Y') }}</span>
                    </div>

                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 font-light">Customer</span>
                        <span class="font-medium text-gray-900">{{ $order->user->name }}</span>
                    </div>

                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 font-light">Email</span>
                        <span class="font-medium text-gray-900 text-xs">{{ $order->user->email }}</span>
                    </div>

                    <div class="pt-4 border-t border-gray-100 space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 font-light">Subtotal</span>
                            <span class="text-gray-900">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                        </div>

                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 font-light">Shipping ({{ $order->ongkir }}kg)</span>
                            <span class="text-gray-900">Rp {{ number_format($order->ongkir * 10000, 0, ',', '.') }}</span>
                        </div>

                        <div class="pt-3 border-t border-gray-100">
                            <div class="flex justify-between">
                                <span class="text-xs uppercase tracking-widest text-gray-900 font-medium">Total</span>
                                <span class="text-xl font-medium text-gray-900 serif">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100">
                        <p class="text-xs uppercase tracking-widest text-gray-500 mb-2">Payment Method</p>
                        <p class="text-sm font-medium text-gray-900">{{ ucfirst($order->metode_pembayaran) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
