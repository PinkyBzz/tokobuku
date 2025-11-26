@extends('layouts.user')

@section('title', 'Contact - Z3LF Bookstore')

@section('content')
    <!-- Hero -->
    <div class="pt-32 lg:pt-40 pb-16 lg:pb-20 bg-white">
        <div class="max-w-4xl mx-auto px-4 lg:px-6 text-center">
            <h1 class="text-4xl lg:text-7xl text-gray-900 font-medium serif italic mb-6">Hubungi Kami</h1>
            <p class="text-lg lg:text-xl text-gray-500 font-light leading-relaxed">
                Kami siap membantu Anda. Jangan ragu untuk menghubungi kami.
            </p>
        </div>
    </div>

    <!-- Content -->
    <div class="max-w-5xl mx-auto px-4 lg:px-6 py-12 lg:py-20">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">
            <!-- Contact Form -->
            <div class="bg-white border border-gray-100 rounded-sm p-6 lg:p-10">
                <h2 class="text-xl lg:text-2xl serif font-medium text-gray-900 mb-6 lg:mb-8 italic">Kirim Pesan</h2>
                
                <form action="{{ route('contact.submit') }}" method="POST" class="space-y-4 lg:space-y-6">
                    @csrf
                    <div>
                        <label class="block text-xs font-medium uppercase tracking-widest text-gray-900 mb-3">Nama</label>
                        <input type="text" 
                               name="name"
                               class="w-full px-4 py-4 bg-white border border-gray-200 text-sm font-light focus:outline-none focus:border-gray-900 transition-all"
                               placeholder="Nama lengkap Anda"
                               required>
                    </div>

                    <div>
                        <label class="block text-xs font-medium uppercase tracking-widest text-gray-900 mb-3">Email</label>
                        <input type="email" 
                               name="email"
                               class="w-full px-4 py-4 bg-white border border-gray-200 text-sm font-light focus:outline-none focus:border-gray-900 transition-all"
                               placeholder="email@example.com"
                               required>
                    </div>

                    <div>
                        <label class="block text-xs font-medium uppercase tracking-widest text-gray-900 mb-3">Subjek</label>
                        <input type="text" 
                               name="subject"
                               class="w-full px-4 py-4 bg-white border border-gray-200 text-sm font-light focus:outline-none focus:border-gray-900 transition-all"
                               placeholder="Topik pesan Anda"
                               required>
                    </div>

                    <div>
                        <label class="block text-xs font-medium uppercase tracking-widest text-gray-900 mb-3">Pesan</label>
                        <textarea rows="5"
                                  name="message"
                                  class="w-full px-4 py-4 bg-white border border-gray-200 text-sm font-light focus:outline-none focus:border-gray-900 transition-all resize-none"
                                  placeholder="Tulis pesan Anda di sini..."
                                  required></textarea>
                    </div>

                    <button type="submit" 
                            class="w-full bg-gray-900 hover:bg-gray-800 text-white font-medium py-4 px-4 transition-colors text-xs uppercase tracking-widest shadow-xl shadow-gray-200">
                        Kirim Pesan
                    </button>
                </form>
            </div>

            <!-- Contact Info -->
            <div class="space-y-6 lg:space-y-8">
                <div class="bg-white border border-gray-100 rounded-sm p-6 lg:p-10">
                    <h2 class="text-xl lg:text-2xl serif font-medium text-gray-900 mb-6 lg:mb-8 italic">Informasi Kontak</h2>
                    
                    <div class="space-y-6">
                        <div class="flex gap-4">
                            <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-map-marker-alt text-gray-900"></i>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-widest text-gray-500 mb-1">Alamat</p>
                                <p class="text-sm font-light text-gray-900">Jl. Merdeka No. 123<br>Jakarta 10110, Indonesia</p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-envelope text-gray-900"></i>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-widest text-gray-500 mb-1">Email</p>
                                <p class="text-sm font-light text-gray-900">hello@z3lf.id<br>support@z3lf.id</p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-phone text-gray-900"></i>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-widest text-gray-500 mb-1">Telepon</p>
                                <p class="text-sm font-light text-gray-900">+62 21 1234 5678<br>+62 812 3456 7890</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-gray-100 rounded-sm p-6 lg:p-10">
                    <h2 class="text-lg lg:text-xl serif font-medium text-gray-900 mb-6 italic">Jam Operasional</h2>
                    <div class="space-y-3 text-sm font-light text-gray-600">
                        <div class="flex justify-between">
                            <span>Senin - Jumat</span>
                            <span class="text-gray-900">09:00 - 18:00</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Sabtu</span>
                            <span class="text-gray-900">10:00 - 16:00</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Minggu</span>
                            <span class="text-gray-900">Tutup</span>
                        </div>
                    </div>
                </div>

                <div class="flex gap-4">
                    <a href="#" class="w-12 h-12 bg-white border border-gray-100 rounded-full flex items-center justify-center hover:border-gray-900 transition-colors">
                        <i class="fab fa-instagram text-gray-900"></i>
                    </a>
                    <a href="#" class="w-12 h-12 bg-white border border-gray-100 rounded-full flex items-center justify-center hover:border-gray-900 transition-colors">
                        <i class="fab fa-twitter text-gray-900"></i>
                    </a>
                    <a href="#" class="w-12 h-12 bg-white border border-gray-100 rounded-full flex items-center justify-center hover:border-gray-900 transition-colors">
                        <i class="fab fa-facebook text-gray-900"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
