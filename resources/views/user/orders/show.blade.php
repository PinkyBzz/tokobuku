@extends('layouts.user')

@section('title', 'Order Detail - Z3LF')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-12">
    <!-- Header -->
    <div class="mb-12">
        <a href="{{ route('user.home') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-900 transition-colors font-light mb-6">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
        <h1 class="text-4xl md:text-5xl text-gray-900 font-medium serif italic mb-2">Order Detail</h1>
        <p class="text-gray-500 font-light">Invoice #{{ $order->invoice_number }}</p>
    </div>

    <!-- Order Status -->
    <div class="bg-white border border-gray-100 rounded-sm p-8 mb-8">
        <div class="flex items-center justify-between mb-6 pb-6 border-b border-gray-100">
            <div>
                <p class="text-xs uppercase tracking-widest text-gray-500 mb-2">Status Pesanan</p>
                <p class="text-xl serif font-medium text-gray-900 capitalize">
                    @switch($order->status)
                        @case('pending') Menunggu Pembayaran @break
                        @case('paid') Dibayar @break
                        @case('processed') Diproses @break
                        @case('shipped') Dikirim @break
                        @case('delivered') Diterima @break
                        @case('cancelled') Dibatalkan @break
                        @default {{ $order->status }}
                    @endswitch
                </p>
            </div>
            <div class="text-right">
                <p class="text-xs uppercase tracking-widest text-gray-500 mb-2">Tanggal Order</p>
                <p class="text-sm font-medium text-gray-900">{{ $order->created_at->format('d M Y') }}</p>
            </div>
        </div>

        <!-- Progress Bar -->
        <div class="flex items-center justify-between relative">
            @php
                $statuses = ['pending', 'paid', 'processed', 'shipped', 'delivered'];
                $currentIndex = array_search($order->status, $statuses);
            @endphp
            
            @foreach($statuses as $index => $status)
            <div class="flex flex-col items-center relative z-10">
                <div class="w-8 h-8 rounded-full border-2 flex items-center justify-center mb-2 {{ $index <= $currentIndex ? 'bg-gray-900 border-gray-900' : 'bg-white border-gray-200' }}">
                    @if($index <= $currentIndex)
                        <i class="fas fa-check text-white text-xs"></i>
                    @endif
                </div>
                <p class="text-[10px] uppercase tracking-wider {{ $index <= $currentIndex ? 'text-gray-900 font-medium' : 'text-gray-400 font-light' }}">
                    {{ ucfirst($status) }}
                </p>
            </div>
            @endforeach

            <div class="absolute top-4 left-0 right-0 h-0.5 bg-gray-200 -z-10"></div>
            <div class="absolute top-4 left-0 h-0.5 bg-gray-900 -z-10 transition-all" style="width: {{ ($currentIndex / (count($statuses) - 1)) * 100 }}%"></div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Order Items -->
        <div class="lg:col-span-2">
            <div class="bg-white border border-gray-100 rounded-sm p-8">
                <h2 class="text-xl serif font-medium text-gray-900 mb-6 pb-4 border-b border-gray-100">Items Pesanan</h2>
                
                <div class="space-y-6">
                    @foreach($order->orderItems as $item)
                    <div class="flex gap-4 pb-6 border-b border-gray-100 last:border-0 last:pb-0">
                        <div class="w-20 h-28 bg-gray-100 rounded-sm overflow-hidden flex-shrink-0">
                            @if($item->book->cover_photo)
                                <img src="{{ asset('storage/' . $item->book->cover_photo) }}" 
                                     alt="{{ $item->book->judul }}"
                                     class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg serif font-medium text-gray-900 mb-1">{{ $item->book->judul }}</h3>
                            <p class="text-xs uppercase tracking-wider text-gray-500 mb-2">{{ $item->book->pengarang }}</p>
                            <div class="flex items-center justify-between mt-4">
                                <p class="text-sm text-gray-500 font-light">Qty: {{ $item->quantity }}</p>
                                <p class="text-sm font-medium text-gray-900">Rp {{ number_format($item->harga * $item->quantity, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Shipping Address -->
            <div class="bg-white border border-gray-100 rounded-sm p-8 mt-8">
                <h2 class="text-xl serif font-medium text-gray-900 mb-6 pb-4 border-b border-gray-100">Alamat Pengiriman</h2>
                <div class="text-sm font-light text-gray-600 space-y-1">
                    <p class="font-medium text-gray-900">{{ $order->user->name }}</p>
                    <p>{{ $order->alamat_lengkap }}</p>
                    <p>{{ $order->kota }}, {{ $order->provinsi }} {{ $order->kode_pos }}</p>
                    @if($order->catatan)
                        <p class="mt-3 text-xs text-gray-500 italic border-t border-gray-100 pt-3">Catatan: {{ $order->catatan }}</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white border border-gray-100 rounded-sm p-8 sticky top-28">
                <h2 class="text-xl serif font-medium text-gray-900 mb-6 pb-4 border-b border-gray-100">Ringkasan</h2>
                
                <div class="space-y-3 mb-6 pb-6 border-b border-gray-100">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 font-light">Subtotal</span>
                        <span class="text-gray-900">Rp {{ number_format($order->total_harga - $order->ongkir, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 font-light">Ongkos Kirim</span>
                        <span class="text-gray-900">Rp {{ number_format($order->ongkir, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="flex justify-between items-baseline mb-6 pb-6 border-b border-gray-100">
                    <span class="text-xs uppercase tracking-widest text-gray-900">Total</span>
                    <span class="text-2xl serif font-medium text-gray-900">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                </div>

                <div class="mb-6">
                    <p class="text-xs uppercase tracking-widest text-gray-900 mb-2">Metode Pembayaran</p>
                    <p class="text-sm font-medium text-gray-900">{{ $order->metode_pembayaran }}</p>
                </div>

                @if($order->status === 'pending' && !$order->payment_proof)
                <form action="{{ route('user.orders.upload-payment', $order->id) }}" method="POST" enctype="multipart/form-data" class="mt-6">
                    @csrf
                    <label class="block text-xs uppercase tracking-widest text-gray-900 mb-3">Upload Bukti Pembayaran</label>
                    <input type="file" 
                           name="payment_proof" 
                           accept="image/*"
                           class="w-full text-sm text-gray-500 font-light
                                  file:mr-4 file:py-3 file:px-4
                                  file:border-0
                                  file:text-xs file:uppercase file:tracking-widest
                                  file:bg-gray-900 file:text-white
                                  hover:file:bg-gray-800 file:transition-colors
                                  file:cursor-pointer cursor-pointer"
                           required>
                    <button type="submit" 
                            class="w-full mt-4 bg-gray-900 hover:bg-gray-800 text-white font-medium py-4 px-4 transition-colors text-xs uppercase tracking-widest shadow-xl shadow-gray-200">
                        Upload Bukti
                    </button>
                </form>
                @elseif($order->payment_proof)
                <div class="mt-6">
                    <p class="text-xs uppercase tracking-widest text-gray-900 mb-3">Bukti Pembayaran</p>
                    <img src="{{ asset('storage/' . $order->payment_proof) }}" 
                         alt="Payment Proof" 
                         class="w-full border border-gray-200 rounded-sm">
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
