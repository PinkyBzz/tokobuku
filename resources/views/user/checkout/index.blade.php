@extends('layouts.user')

@section('title', 'Checkout - Z3LF')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-12">
    <!-- Header -->
    <div class="mb-12 text-center">
        <h1 class="text-4xl md:text-5xl text-gray-900 font-medium serif italic mb-2">Checkout</h1>
        <p class="text-gray-500 font-light">Lengkapi informasi pengiriman Anda</p>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-sm">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-sm">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-sm">
            <p class="font-medium mb-2"><i class="fas fa-exclamation-triangle mr-2"></i>Terdapat kesalahan:</p>
            <ul class="list-disc list-inside text-sm space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('user.checkout.process') }}" method="POST" enctype="multipart/form-data" id="checkout-form">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <!-- Left Column - Forms -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Shipping Information -->
                <div class="bg-white border border-gray-100 rounded-sm p-8">
                    <h2 class="text-xl serif font-medium text-gray-900 mb-6 pb-4 border-b border-gray-100">Informasi Pengiriman</h2>
                    
                    <div class="space-y-6">
                        <!-- Provinsi -->
                        <div>
                            <label class="block text-xs font-medium uppercase tracking-widest text-gray-900 mb-3">Provinsi</label>
                            <input type="text" 
                                   name="provinsi" 
                                   value="{{ old('provinsi') }}"
                                   class="w-full px-4 py-4 bg-white border border-gray-200 text-sm font-light focus:outline-none focus:border-gray-900 transition-all"
                                   placeholder="Contoh: Jawa Barat"
                                   required>
                            @error('provinsi')
                                <p class="mt-2 text-xs text-red-600 font-light">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kota -->
                        <div>
                            <label class="block text-xs font-medium uppercase tracking-widest text-gray-900 mb-3">Kota/Kabupaten</label>
                            <input type="text" 
                                   name="kota" 
                                   value="{{ old('kota') }}"
                                   class="w-full px-4 py-4 bg-white border border-gray-200 text-sm font-light focus:outline-none focus:border-gray-900 transition-all"
                                   placeholder="Contoh: Bandung"
                                   required>
                            @error('kota')
                                <p class="mt-2 text-xs text-red-600 font-light">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Alamat Lengkap -->
                        <div>
                            <label class="block text-xs font-medium uppercase tracking-widest text-gray-900 mb-3">Alamat Lengkap</label>
                            <textarea name="alamat_lengkap" 
                                      rows="3"
                                      class="w-full px-4 py-4 bg-white border border-gray-200 text-sm font-light focus:outline-none focus:border-gray-900 transition-all resize-none"
                                      placeholder="Jalan, nomor rumah, RT/RW, kelurahan, kecamatan"
                                      required>{{ old('alamat_lengkap') }}</textarea>
                            @error('alamat_lengkap')
                                <p class="mt-2 text-xs text-red-600 font-light">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kode Pos -->
                        <div>
                            <label class="block text-xs font-medium uppercase tracking-widest text-gray-900 mb-3">Kode Pos</label>
                            <input type="text" 
                                   name="kode_pos" 
                                   value="{{ old('kode_pos') }}"
                                   class="w-full px-4 py-4 bg-white border border-gray-200 text-sm font-light focus:outline-none focus:border-gray-900 transition-all"
                                   placeholder="Contoh: 40123"
                                   maxlength="5"
                                   required>
                            @error('kode_pos')
                                <p class="mt-2 text-xs text-red-600 font-light">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Ongkir -->
                        <div>
                            <label class="block text-xs font-medium uppercase tracking-widest text-gray-900 mb-3">Biaya Pengiriman</label>
                            <input type="number" 
                                   name="ongkir" 
                                   value="{{ old('ongkir', 15000) }}"
                                   class="w-full px-4 py-4 bg-white border border-gray-200 text-sm font-light focus:outline-none focus:border-gray-900 transition-all"
                                   min="0"
                                   required>
                            <p class="mt-2 text-xs text-gray-500 font-light">Default: Rp 15.000</p>
                            @error('ongkir')
                                <p class="mt-2 text-xs text-red-600 font-light">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Catatan -->
                        <div>
                            <label class="block text-xs font-medium uppercase tracking-widest text-gray-900 mb-3">Catatan (Opsional)</label>
                            <textarea name="catatan" 
                                      rows="2"
                                      class="w-full px-4 py-4 bg-white border border-gray-200 text-sm font-light focus:outline-none focus:border-gray-900 transition-all resize-none"
                                      placeholder="Instruksi khusus untuk pengiriman">{{ old('catatan') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="bg-white border border-gray-100 rounded-sm p-8">
                    <h2 class="text-xl serif font-medium text-gray-900 mb-6 pb-4 border-b border-gray-100">Metode Pembayaran</h2>
                    
                    <div class="space-y-4">
                        <label class="flex items-center gap-4 p-4 border border-gray-200 hover:border-gray-900 transition-all cursor-pointer group">
                            <input type="radio" 
                                   name="metode_pembayaran" 
                                   value="transfer" 
                                   class="w-5 h-5 border-gray-300 text-gray-900 focus:ring-0"
                                   checked>
                            <div class="flex-1">
                                <div class="text-sm font-medium text-gray-900 group-hover:underline decoration-1 underline-offset-4">Transfer Bank</div>
                                <div class="text-xs text-gray-500 font-light mt-1">BCA / Mandiri / BNI</div>
                            </div>
                        </label>

                        <label class="flex items-center gap-4 p-4 border border-gray-200 hover:border-gray-900 transition-all cursor-pointer group">
                            <input type="radio" 
                                   name="metode_pembayaran" 
                                   value="ewallet" 
                                   class="w-5 h-5 border-gray-300 text-gray-900 focus:ring-0">
                            <div class="flex-1">
                                <div class="text-sm font-medium text-gray-900 group-hover:underline decoration-1 underline-offset-4">E-Wallet</div>
                                <div class="text-xs text-gray-500 font-light mt-1">GoPay / OVO / Dana</div>
                            </div>
                        </label>

                        <label class="flex items-center gap-4 p-4 border border-gray-200 hover:border-gray-900 transition-all cursor-pointer group">
                            <input type="radio" 
                                   name="metode_pembayaran" 
                                   value="cod" 
                                   class="w-5 h-5 border-gray-300 text-gray-900 focus:ring-0">
                            <div class="flex-1">
                                <div class="text-sm font-medium text-gray-900 group-hover:underline decoration-1 underline-offset-4">Cash on Delivery (COD)</div>
                                <div class="text-xs text-gray-500 font-light mt-1">Bayar saat barang diterima</div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Right Column - Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white border border-gray-100 rounded-sm p-8 sticky top-28">
                    <h2 class="text-xl serif font-medium text-gray-900 mb-6 pb-4 border-b border-gray-100">Ringkasan Pesanan</h2>
                    
                    <!-- Cart Items -->
                    <div class="space-y-4 mb-6 pb-6 border-b border-gray-100">
                        @foreach($cartItems as $item)
                        <div class="flex gap-3">
                            <div class="w-12 h-16 bg-gray-100 rounded-sm overflow-hidden flex-shrink-0">
                                @if($item->book->cover_photo)
                                    <img src="{{ asset('storage/' . $item->book->cover_photo) }}" 
                                         alt="{{ $item->book->judul }}"
                                         class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-medium text-gray-900 truncate">{{ $item->book->judul }}</h4>
                                <p class="text-xs text-gray-500 font-light">Qty: {{ $item->quantity }}</p>
                                <p class="text-xs font-medium text-gray-900 mt-1">Rp {{ number_format($item->book->harga * $item->quantity, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Price Breakdown -->
                    <div class="space-y-3 mb-6 pb-6 border-b border-gray-100">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500 font-light">Subtotal</span>
                            <span class="text-gray-900">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500 font-light">Ongkos Kirim</span>
                            <span class="text-gray-900">Rp <span id="ongkir-display">15.000</span></span>
                        </div>
                    </div>

                    <!-- Total -->
                    <div class="flex justify-between items-baseline mb-6">
                        <span class="text-xs uppercase tracking-widest text-gray-900">Total</span>
                        <span class="text-2xl serif font-medium text-gray-900">Rp <span id="total-display">{{ number_format($subtotal + 15000, 0, ',', '.') }}</span></span>
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="mb-6 pb-6 border-b border-gray-100">
                        <label class="flex items-start gap-3 cursor-pointer group">
                            <input type="checkbox" 
                                   name="agree_terms" 
                                   id="agree-terms"
                                   class="mt-1 w-5 h-5 flex-shrink-0 border-2 border-gray-300 rounded text-gray-900 focus:ring-0 focus:ring-offset-0 cursor-pointer"
                                   required>
                            <span class="text-xs text-gray-600 font-light leading-relaxed">
                                Saya menyetujui <a href="#" class="text-gray-900 underline decoration-1 underline-offset-2 hover:text-gray-600">syarat & ketentuan</a> yang berlaku
                            </span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            id="submit-btn"
                            class="w-full bg-gray-900 hover:bg-gray-800 text-white font-medium py-4 px-4 transition-colors text-xs uppercase tracking-widest shadow-xl shadow-gray-200 disabled:bg-gray-400 disabled:cursor-not-allowed"
                            disabled>
                        <span id="btn-text">Buat Pesanan</span>
                        <span id="btn-loading" class="hidden">
                            <i class="fas fa-spinner fa-spin mr-2"></i>Memproses...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
// Form submission handling
const checkoutForm = document.getElementById('checkout-form');
const submitBtn = document.getElementById('submit-btn');
const btnText = document.getElementById('btn-text');
const btnLoading = document.getElementById('btn-loading');

checkoutForm.addEventListener('submit', function(e) {
    // Show loading state
    submitBtn.disabled = true;
    btnText.classList.add('hidden');
    btnLoading.classList.remove('hidden');
});

// Update ongkir display
document.querySelector('input[name="ongkir"]').addEventListener('input', function(e) {
    const ongkir = parseInt(e.target.value) || 0;
    const subtotal = {{ $subtotal }};
    const total = subtotal + ongkir;
    
    document.getElementById('ongkir-display').textContent = ongkir.toLocaleString('id-ID');
    document.getElementById('total-display').textContent = total.toLocaleString('id-ID');
});

// Enable/disable submit button based on checkbox
const agreeCheckbox = document.getElementById('agree-terms');

agreeCheckbox.addEventListener('change', function() {
    submitBtn.disabled = !this.checked;
});
</script>
@endsection
