@extends('layouts.user')

@section('title', $book->judul . ' - Z3LF Bookstore')

@section('content')
<div class="pt-24 pb-20">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-10" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-2 text-sm">
                <li>
                    <a href="{{ route('user.home') }}" class="text-gray-500 hover:text-gray-900 transition-colors">Home</a>
                </li>
                <li><span class="text-gray-300 mx-2">/</span></li>
                <li>
                    <a href="{{ route('user.books.index') }}" class="text-gray-500 hover:text-gray-900 transition-colors">Catalog</a>
                </li>
                <li><span class="text-gray-300 mx-2">/</span></li>
                <li>
                    <a href="{{ route('user.books.index', ['category' => $book->category_id]) }}" class="text-gray-500 hover:text-gray-900 transition-colors">{{ $book->category->name ?? 'Books' }}</a>
                </li>
                <li><span class="text-gray-300 mx-2">/</span></li>
                <li class="text-gray-900 font-medium">{{ $book->judul }}</li>
            </ol>
        </nav>

        @if(session('success'))
        <div class="bg-green-50 border border-green-100 text-green-800 px-6 py-4 mb-8 flex items-center gap-3">
            <i class="fas fa-check-circle"></i>
            <p class="text-sm">{{ session('success') }}</p>
        </div>
        @endif

        <!-- Book Detail Grid -->
        <div class="grid lg:grid-cols-2 gap-16 mb-20">
            <!-- Book Cover -->
            <div>
                <div class="bg-[#F2F0E9] rounded-sm overflow-hidden sticky top-32">
                    <div class="aspect-[2/3]">
                        @if($book->cover_photo)
                            <img src="{{ asset('storage/' . $book->cover_photo) }}" 
                                 alt="{{ $book->judul }}"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <div class="text-center">
                                    <span class="text-9xl serif text-gray-400">{{ substr($book->judul, 0, 1) }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Book Info -->
            <div>
                <!-- Category & Stock -->
                <div class="flex items-center gap-3 mb-6">
                    <span class="px-4 py-2 bg-gray-100 text-gray-900 text-xs uppercase tracking-widest">
                        {{ $book->category->name ?? 'Uncategorized' }}
                    </span>
                    @if($book->stok > 0)
                        @if($book->stok <= 5)
                        <span class="px-4 py-2 bg-amber-50 text-amber-900 text-xs uppercase tracking-widest">
                            Terbatas
                        </span>
                        @endif
                    @else
                        <span class="px-4 py-2 bg-gray-100 text-gray-500 text-xs uppercase tracking-widest">
                            Habis
                        </span>
                    @endif
                </div>

                <!-- Title & Author -->
                <h1 class="text-4xl md:text-5xl serif italic text-gray-900 mb-4 leading-tight">{{ $book->judul }}</h1>
                <p class="text-xl font-light text-gray-600 mb-8">oleh <span class="italic">{{ $book->pengarang }}</span></p>

                <!-- Rating -->
                <div class="flex items-center gap-6 mb-8 pb-8 border-b border-gray-100">
                    <div class="flex items-center gap-2">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= round($averageRating))
                                <i class="fas fa-star text-gray-900 text-lg"></i>
                            @else
                                <i class="far fa-star text-gray-300 text-lg"></i>
                            @endif
                        @endfor
                    </div>
                    <span class="text-lg font-medium text-gray-900">{{ number_format($averageRating, 1) }}</span>
                    <span class="text-sm text-gray-500">{{ $totalReviews }} ulasan</span>
                </div>

                <!-- Price -->
                <div class="mb-10">
                    <div class="text-4xl font-light text-gray-900 mb-2">
                        Rp {{ number_format($book->harga, 0, ',', '.') }}
                    </div>
                    <p class="text-sm text-gray-500">Stok: {{ $book->stok }} tersedia</p>
                </div>

                <!-- Actions -->
                <div class="space-y-3 mb-12">
                    @if($book->stok > 0)
                        <form action="{{ route('user.cart.add', $book->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-gray-900 text-white py-5 text-sm uppercase tracking-widest hover:bg-gray-800 transition-all shadow-xl shadow-gray-200">
                                <i class="fas fa-shopping-bag mr-2"></i> Tambah ke Keranjang
                            </button>
                        </form>
                    @else
                        <button class="w-full bg-gray-200 text-gray-400 py-5 text-sm uppercase tracking-widest cursor-not-allowed" disabled>
                            Stok Habis
                        </button>
                    @endif
                </div>

                <!-- Book Details -->
                <div class="space-y-4 mb-10 pb-10 border-b border-gray-100">
                    <div class="flex">
                        <span class="w-32 text-xs uppercase tracking-widest text-gray-500">Penerbit</span>
                        <span class="flex-1 font-light text-gray-900">{{ $book->penerbit }}</span>
                    </div>
                    <div class="flex">
                        <span class="w-32 text-xs uppercase tracking-widest text-gray-500">Tahun</span>
                        <span class="flex-1 font-light text-gray-900">{{ $book->tahun_terbit }}</span>
                    </div>
                    <div class="flex">
                        <span class="w-32 text-xs uppercase tracking-widest text-gray-500">ISBN</span>
                        <span class="flex-1 font-light text-gray-900">{{ $book->isbn ?? 'N/A' }}</span>
                    </div>
                </div>

                <!-- Synopsis -->
                <div>
                    <h2 class="text-xl serif italic text-gray-900 mb-4">Sinopsis</h2>
                    <p class="font-light text-gray-700 leading-relaxed whitespace-pre-line">{{ $book->sinopsis ?? 'Belum ada sinopsis untuk buku ini.' }}</p>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="border-t border-gray-100 pt-16">
            <h2 class="text-3xl serif italic text-gray-900 mb-12">Ulasan Pembaca</h2>

            <!-- Rating Overview -->
            <div class="grid md:grid-cols-3 gap-12 mb-16">
                <!-- Average Rating -->
                <div class="text-center border-r border-gray-100">
                    <div class="text-6xl font-light text-gray-900 mb-4">{{ number_format($averageRating, 1) }}</div>
                    <div class="flex justify-center gap-1 mb-3">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= round($averageRating))
                                <i class="fas fa-star text-gray-900 text-xl"></i>
                            @else
                                <i class="far fa-star text-gray-300 text-xl"></i>
                            @endif
                        @endfor
                    </div>
                    <p class="text-sm text-gray-500 uppercase tracking-widest">{{ $totalReviews }} Ulasan</p>
                </div>

                <!-- Rating Distribution -->
                <div class="md:col-span-2">
                    @foreach([5, 4, 3, 2, 1] as $rating)
                    <div class="flex items-center gap-4 mb-4">
                        <div class="flex items-center gap-2 w-20">
                            <span class="text-sm font-light text-gray-700">{{ $rating }}</span>
                            <i class="fas fa-star text-gray-400 text-xs"></i>
                        </div>
                        <div class="flex-1 bg-gray-100 h-1.5">
                            @php
                                $percentage = $totalReviews > 0 ? ($ratingDistribution[$rating] / $totalReviews) * 100 : 0;
                            @endphp
                            <div class="bg-gray-900 h-1.5 transition-all duration-500" style="width: {{ $percentage }}%"></div>
                        </div>
                        <span class="text-sm text-gray-500 w-12 text-right">{{ $ratingDistribution[$rating] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Write Review Form -->
            @if(!$userReview)
            <div class="bg-gray-50 border border-gray-100 p-10 mb-16">
                <h3 class="text-lg serif italic text-gray-900 mb-6">Tulis Ulasan Anda</h3>
                <form action="{{ route('user.books.reviews.store', $book->id) }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label class="block text-xs uppercase tracking-widest text-gray-900 mb-3">Rating *</label>
                        <div class="flex gap-2">
                            @for($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer">
                                <input type="radio" name="rating" value="{{ $i }}" class="hidden peer" required>
                                <i class="far fa-star text-3xl text-gray-300 peer-checked:fas peer-checked:text-gray-900 hover:text-gray-400 transition-colors"></i>
                            </label>
                            @endfor
                        </div>
                        @error('rating')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs uppercase tracking-widest text-gray-900 mb-3">Komentar *</label>
                        <textarea name="komentar" rows="4" required
                                  class="w-full px-4 py-4 bg-white border border-gray-200 font-light focus:outline-none focus:border-gray-900 transition-all resize-none"
                                  placeholder="Bagikan pendapat Anda tentang buku ini..."></textarea>
                        @error('komentar')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="bg-gray-900 text-white px-8 py-4 text-sm uppercase tracking-widest hover:bg-gray-800 transition-all shadow-xl shadow-gray-200">
                        Kirim Ulasan
                    </button>
                </form>
            </div>
            @else
            <div class="bg-blue-50 border border-blue-100 text-blue-900 px-6 py-4 mb-16 flex items-center gap-3">
                <i class="fas fa-info-circle"></i>
                <p class="text-sm">Anda sudah mengulas buku ini. Anda dapat mengedit ulasan di bawah.</p>
            </div>
            @endif

            <!-- Reviews List -->
            <div class="space-y-10">
                @forelse($book->reviews()->with('user')->latest()->get() as $review)
                <div class="border-b border-gray-100 pb-10 last:border-0">
                    <div class="flex items-start gap-6">
                        <div class="flex-shrink-0">
                            @if($review->user->photo)
                                <img src="{{ asset('storage/' . $review->user->photo) }}" 
                                     alt="{{ $review->user->name }}"
                                     class="w-14 h-14 rounded-full object-cover">
                            @else
                                <div class="w-14 h-14 bg-gray-200 rounded-full flex items-center justify-center">
                                    <span class="text-gray-600 font-medium serif text-lg">
                                        {{ substr($review->user->name, 0, 1) }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        <div class="flex-1">
                            <div class="flex items-start justify-between mb-3">
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ $review->user->name }}</h4>
                                    <p class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="flex items-center gap-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <i class="fas fa-star text-gray-900 text-sm"></i>
                                        @else
                                            <i class="far fa-star text-gray-300 text-sm"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                            <p class="font-light text-gray-700 leading-relaxed">{{ $review->komentar }}</p>

                            @if($review->user_id === auth()->id())
                            <div class="mt-4">
                                <button onclick="editReview({{ $review->id }}, {{ $review->rating }}, '{{ addslashes($review->komentar) }}')"
                                        class="text-sm text-gray-500 hover:text-gray-900 transition-colors underline decoration-1 underline-offset-4">
                                    Edit Ulasan
                                </button>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-16">
                    <i class="fas fa-comments text-gray-200 text-6xl mb-6"></i>
                    <p class="text-gray-500 font-light">Belum ada ulasan. Jadilah yang pertama mengulas buku ini!</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Related Books -->
        @if($relatedBooks->count() > 0)
        <div class="border-t border-gray-100 pt-20 mt-20">
            <h2 class="text-3xl serif italic text-gray-900 mb-12">Buku Terkait</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-8 gap-y-16">
                @foreach($relatedBooks as $relatedBook)
                <a href="{{ route('user.books.show', $relatedBook->id) }}" class="group book-card">
                    <div class="aspect-[2/3] bg-[#F2F0E9] rounded-sm overflow-hidden mb-6 relative">
                        @if($relatedBook->cover_photo)
                            <img src="{{ asset('storage/' . $relatedBook->cover_photo) }}" 
                                 alt="{{ $relatedBook->judul }}"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <span class="text-6xl serif text-gray-400">{{ substr($relatedBook->judul, 0, 1) }}</span>
                            </div>
                        @endif
                        
                        @if($relatedBook->stok <= 0)
                        <span class="absolute top-4 right-4 px-3 py-1 bg-gray-900 text-white text-xs uppercase tracking-widest">
                            Habis
                        </span>
                        @elseif($relatedBook->stok <= 5)
                        <span class="absolute top-4 right-4 px-3 py-1 bg-amber-500 text-white text-xs uppercase tracking-widest">
                            Terbatas
                        </span>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-widest text-gray-500 mb-2">{{ $relatedBook->category->name ?? 'Uncategorized' }}</p>
                        <h3 class="serif text-lg text-gray-900 mb-1 line-clamp-2 group-hover:underline decoration-1 underline-offset-4">{{ $relatedBook->judul }}</h3>
                        <p class="text-sm font-light text-gray-600 mb-3">{{ $relatedBook->pengarang }}</p>
                        <p class="text-lg font-light text-gray-900">Rp {{ number_format($relatedBook->harga, 0, ',', '.') }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Edit Review Modal -->
<div id="editReviewModal" class="hidden fixed inset-0 bg-black/30 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white border border-gray-100 max-w-lg w-full p-10">
        <h3 class="text-2xl serif italic text-gray-900 mb-8">Edit Ulasan Anda</h3>
        <form action="{{ route('user.books.reviews.store', $book->id) }}" method="POST" class="space-y-6">
            @csrf
            
            <div>
                <label class="block text-xs uppercase tracking-widest text-gray-900 mb-3">Rating *</label>
                <div class="flex gap-2" id="editRatingStars">
                    @for($i = 1; $i <= 5; $i++)
                    <label class="cursor-pointer">
                        <input type="radio" name="rating" value="{{ $i }}" class="hidden peer">
                        <i class="far fa-star text-3xl text-gray-300 peer-checked:fas peer-checked:text-gray-900 hover:text-gray-400 transition-colors"></i>
                    </label>
                    @endfor
                </div>
            </div>

            <div>
                <label class="block text-xs uppercase tracking-widest text-gray-900 mb-3">Komentar *</label>
                <textarea name="komentar" id="editKomentar" rows="4" required
                          class="w-full px-4 py-4 bg-white border border-gray-200 font-light focus:outline-none focus:border-gray-900 transition-all resize-none"></textarea>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-gray-900 text-white py-4 text-sm uppercase tracking-widest hover:bg-gray-800 transition-all shadow-xl shadow-gray-200">
                    Update Ulasan
                </button>
                <button type="button" onclick="closeEditModal()" class="px-6 bg-gray-100 text-gray-900 py-4 text-sm uppercase tracking-widest hover:bg-gray-200 transition-all">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
function editReview(reviewId, rating, comment) {
    const modal = document.getElementById('editReviewModal');
    const ratingInputs = document.querySelectorAll('#editRatingStars input[name="rating"]');
    const commentTextarea = document.getElementById('editKomentar');
    
    ratingInputs.forEach(input => {
        if (parseInt(input.value) === rating) {
            input.checked = true;
        }
    });
    
    commentTextarea.value = comment;
    modal.classList.remove('hidden');
}

function closeEditModal() {
    const modal = document.getElementById('editReviewModal');
    modal.classList.add('hidden');
}

document.getElementById('editReviewModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditModal();
    }
});
</script>
@endsection
