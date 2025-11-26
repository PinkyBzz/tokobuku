@extends('layouts.user')

@section('title', 'Keranjang Belanja - Z3LF Bookstore')

@section('content')
<div class="pt-24 pb-20">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-12">
            <h1 class="text-4xl md:text-5xl serif italic text-gray-900 mb-3">Keranjang Belanja</h1>
            <p class="font-light text-gray-600">Tinjau pesanan Anda sebelum checkout</p>
        </div>

        @if(session('success'))
        <div class="bg-green-50 border border-green-100 text-green-800 px-6 py-4 mb-8 flex items-center gap-3">
            <i class="fas fa-check-circle"></i>
            <p class="text-sm">{{ session('success') }}</p>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-50 border border-red-100 text-red-800 px-6 py-4 mb-8 flex items-center gap-3">
            <i class="fas fa-exclamation-circle"></i>
            <p class="text-sm">{{ session('error') }}</p>
        </div>
        @endif

        @if($cartItems->count() > 0)
        <div class="grid lg:grid-cols-3 gap-12">
            <!-- Cart Items -->
            <div class="lg:col-span-2 space-y-6">
                @foreach($cartItems as $item)
                <div class="bg-white border border-gray-100 p-8 hover:shadow-lg hover:shadow-gray-100 transition-shadow">
                    <div class="flex gap-8">
                        <!-- Book Cover -->
                        <div class="flex-shrink-0">
                            <a href="{{ route('user.books.show', $item->book->id) }}" class="block w-32 aspect-[2/3] bg-[#F2F0E9] rounded-sm overflow-hidden group">
                                @if($item->book->cover_photo)
                                    <img src="{{ asset('storage/' . $item->book->cover_photo) }}" 
                                         alt="{{ $item->book->judul }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <span class="text-4xl serif text-gray-400">{{ substr($item->book->judul, 0, 1) }}</span>
                                    </div>
                                @endif
                            </a>
                        </div>

                        <!-- Book Details -->
                        <div class="flex-1">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex-1">
                                    <p class="text-xs uppercase tracking-widest text-gray-500 mb-2">{{ $item->book->category->name ?? 'Uncategorized' }}</p>
                                    <a href="{{ route('user.books.show', $item->book->id) }}" class="serif text-xl text-gray-900 hover:underline decoration-1 underline-offset-4 mb-2 block">
                                        {{ $item->book->judul }}
                                    </a>
                                    <p class="text-sm font-light text-gray-600 mb-1">oleh {{ $item->book->pengarang }}</p>
                                </div>
                                <form action="{{ route('user.cart.remove', $item->id) }}" method="POST" onsubmit="return confirm('Hapus buku ini dari keranjang?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-600 transition-colors ml-4">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>

                            <div class="flex items-end justify-between mt-6 pt-6 border-t border-gray-100">
                                <!-- Quantity Controls -->
                                <div class="flex items-center gap-4">
                                    <span class="text-xs uppercase tracking-widest text-gray-500">Jumlah</span>
                                    <form action="{{ route('user.cart.update', $item->id) }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <div class="flex items-center border border-gray-200">
                                            <button type="button" onclick="decrementQty({{ $item->id }})" class="px-4 py-2 hover:bg-gray-50 transition-colors">
                                                <i class="fas fa-minus text-xs"></i>
                                            </button>
                                            <input type="number" 
                                                   name="qty" 
                                                   id="qty-{{ $item->id }}"
                                                   value="{{ $item->qty }}" 
                                                   min="1" 
                                                   max="{{ $item->book->stok }}"
                                                   class="w-16 text-center border-x border-gray-200 py-2 font-light focus:outline-none focus:border-gray-900"
                                                   onchange="this.form.submit()">
                                            <button type="button" onclick="incrementQty({{ $item->id }}, {{ $item->book->stok }})" class="px-4 py-2 hover:bg-gray-50 transition-colors">
                                                <i class="fas fa-plus text-xs"></i>
                                            </button>
                                        </div>
                                    </form>
                                    <span class="text-xs text-gray-400">
                                        Stok: {{ $item->book->stok }}
                                    </span>
                                </div>

                                <!-- Price -->
                                <div class="text-right">
                                    <p class="text-2xl font-light text-gray-900 mb-1">
                                        Rp {{ number_format($item->book->harga * $item->qty, 0, ',', '.') }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        Rp {{ number_format($item->book->harga, 0, ',', '.') }} × {{ $item->qty }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white border border-gray-100 p-8 sticky top-32">
                    <h2 class="text-xl serif italic text-gray-900 mb-8">Ringkasan Pesanan</h2>
                    
                    <div class="space-y-4 mb-8 pb-8 border-b border-gray-100">
                        <div class="flex justify-between font-light text-gray-700">
                            <span>Subtotal ({{ $cartItems->count() }} item)</span>
                            <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between font-light text-gray-700">
                            <span>Pajak (10%)</span>
                            <span>Rp {{ number_format($tax, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-baseline mb-10">
                        <span class="text-xs uppercase tracking-widest text-gray-500">Total</span>
                        <span class="text-3xl font-light text-gray-900">
                            Rp {{ number_format($total, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="space-y-3">
                        <a href="{{ route('user.checkout.index') }}" class="block w-full bg-gray-900 text-white py-5 text-center text-sm uppercase tracking-widest hover:bg-gray-800 transition-all shadow-xl shadow-gray-200">
                            Lanjut ke Checkout
                        </a>

                        <a href="{{ route('user.books.index') }}" class="block w-full text-center bg-white border border-gray-200 text-gray-900 py-5 text-sm uppercase tracking-widest hover:bg-gray-50 transition-all">
                            Lanjut Belanja
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @else
        <!-- Empty Cart -->
        <div class="bg-white border border-gray-100 py-20 text-center">
            <div class="max-w-md mx-auto">
                <div class="w-32 h-32 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-8">
                    <i class="fas fa-shopping-bag text-gray-300 text-5xl"></i>
                </div>
                <h2 class="text-3xl serif italic text-gray-900 mb-4">Keranjang Kosong</h2>
                <p class="font-light text-gray-600 mb-10">Sepertinya Anda belum menambahkan buku ke keranjang.</p>
                <a href="{{ route('user.books.index') }}" class="inline-block bg-gray-900 text-white px-10 py-5 text-sm uppercase tracking-widest hover:bg-gray-800 transition-all shadow-xl shadow-gray-200">
                    Jelajahi Koleksi
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
function incrementQty(itemId, maxStock) {
    const input = document.getElementById('qty-' + itemId);
    const currentValue = parseInt(input.value);
    if (currentValue < maxStock) {
        input.value = currentValue + 1;
        input.form.submit();
    }
}

function decrementQty(itemId) {
    const input = document.getElementById('qty-' + itemId);
    const currentValue = parseInt(input.value);
    if (currentValue > 1) {
        input.value = currentValue - 1;
        input.form.submit();
    }
}
</script>
@endsection
