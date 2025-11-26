@extends('layouts.user')

@section('title', 'About - Z3LF Bookstore')

@section('content')
    <!-- Hero -->
    <div class="pt-32 lg:pt-40 pb-16 lg:pb-20 bg-white">
        <div class="max-w-4xl mx-auto px-4 lg:px-6 text-center">
            <h1 class="text-4xl lg:text-7xl text-gray-900 font-medium serif italic mb-6">Tentang Z3LF</h1>
            <p class="text-lg lg:text-xl text-gray-500 font-light leading-relaxed">
                Sebuah kurasi buku untuk pemikir modern yang mencari perspektif baru.
            </p>
        </div>
    </div>

    <!-- Content -->
    <div class="max-w-4xl mx-auto px-4 lg:px-6 py-12 lg:py-20">
        <div class="prose prose-lg max-w-none">
            <div class="bg-white border border-gray-100 rounded-sm p-8 lg:p-12 mb-8 lg:mb-12">
                <h2 class="text-2xl lg:text-3xl serif font-medium text-gray-900 mb-6 italic">Filosofi Kami</h2>
                <p class="text-gray-600 font-light leading-relaxed mb-4">
                    Z3LF didirikan dengan keyakinan bahwa buku adalah jendela menuju dunia yang lebih luas. Kami percaya bahwa setiap halaman yang dibaca adalah langkah menuju pemahaman yang lebih dalam tentang diri sendiri dan dunia di sekitar kita.
                </p>
                <p class="text-gray-600 font-light leading-relaxed">
                    Dengan kurasi yang cermat, kami menghadirkan koleksi buku yang tidak hanya informatif, tetapi juga transformatif - buku-buku yang menginspirasi, menantang, dan membentuk cara berpikir.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8 mb-8 lg:mb-12">
                <div class="bg-white border border-gray-100 rounded-sm p-6 lg:p-8 text-center">
                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-book-open text-gray-900 text-2xl"></i>
                    </div>
                    <h3 class="text-lg serif font-medium text-gray-900 mb-2">Kurasi Berkualitas</h3>
                    <p class="text-sm text-gray-500 font-light">Setiap buku dipilih dengan cermat untuk nilai dan kualitasnya</p>
                </div>

                <div class="bg-white border border-gray-100 rounded-sm p-6 lg:p-8 text-center">
                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-gray-900 text-2xl"></i>
                    </div>
                    <h3 class="text-lg serif font-medium text-gray-900 mb-2">Komunitas Pembaca</h3>
                    <p class="text-sm text-gray-500 font-light">Bergabung dengan ribuan pembaca yang passionate</p>
                </div>

                <div class="bg-white border border-gray-100 rounded-sm p-6 lg:p-8 text-center">
                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shipping-fast text-gray-900 text-2xl"></i>
                    </div>
                    <h3 class="text-lg serif font-medium text-gray-900 mb-2">Pengiriman Cepat</h3>
                    <p class="text-sm text-gray-500 font-light">Buku favorit Anda sampai dengan aman dan cepat</p>
                </div>
            </div>

            <div class="bg-gray-900 text-white rounded-sm p-8 lg:p-12 text-center">
                <p class="text-xl lg:text-2xl serif italic mb-6">"Membaca adalah bepergian tanpa harus meninggalkan rumah"</p>
                <p class="text-xs lg:text-sm uppercase tracking-widest text-gray-400">— Z3LF Team</p>
            </div>
        </div>
    </div>
@endsection
