@extends('layouts.admin')

@section('title', 'Add New Book')
@section('page-title', 'Add New Book')

@section('content')
<div class="space-y-6">
    <!-- Back Button -->
    <div>
        <a href="{{ route('admin.books.index') }}" 
           class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            <span class="uppercase tracking-widest text-xs">Back to Books</span>
        </a>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-sm">
            <p class="text-sm font-medium mb-2">Please fix the following errors:</p>
            <ul class="list-disc list-inside text-sm font-light">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="grid lg:grid-cols-3 gap-6">
            <!-- Book Cover -->
            <div class="lg:col-span-1">
                <div class="bg-white border border-gray-100 rounded-sm p-6">
                    <label class="block text-xs font-medium uppercase tracking-widest text-gray-900 mb-4">Book Cover</label>
                    
                    <!-- Toggle Source -->
                    <div class="flex space-x-4 mb-4">
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="image_source" value="file" checked class="mr-2" onchange="toggleImageSource('file')">
                            <span class="text-xs uppercase tracking-widest text-gray-600">Upload File</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="image_source" value="url" class="mr-2" onchange="toggleImageSource('url')">
                            <span class="text-xs uppercase tracking-widest text-gray-600">Image URL</span>
                        </label>
                    </div>

                    <div class="mb-4">
                        <!-- Placeholder or Preview -->
                        <div id="image-placeholder" class="w-full aspect-[2/3] bg-gray-50 border border-dashed border-gray-300 flex flex-col items-center justify-center text-gray-400">
                            <i class="fas fa-image text-4xl mb-2"></i>
                            <span class="text-xs uppercase tracking-widest">No Image</span>
                        </div>
                        <img id="preview-img" 
                             src="" 
                             alt="Preview" 
                             class="hidden w-full aspect-[2/3] object-cover border border-gray-100 rounded-sm">
                    </div>
                    
                    <!-- File Input Section -->
                    <div id="file-input-section">
                        <input type="file" name="cover_photo" id="cover_photo" class="hidden" accept="image/*">
                        <button type="button" 
                                onclick="document.getElementById('cover_photo').click()" 
                                class="w-full bg-gray-50 hover:bg-gray-100 text-gray-900 px-4 py-3 transition-colors text-xs uppercase tracking-widest border border-gray-200">
                            Choose File
                        </button>
                        <p class="text-xs text-gray-500 font-light mt-2">PNG, JPG up to 2MB</p>
                    </div>

                    <!-- URL Input Section -->
                    <div id="url-input-section" class="hidden">
                        <input type="url" name="cover_url" id="cover_url" placeholder="https://example.com/image.jpg" 
                               class="w-full px-4 py-3 bg-white border border-gray-200 text-sm font-light focus:outline-none focus:border-gray-900 transition-all mb-2">
                        <button type="button" onclick="previewUrl()" class="w-full bg-gray-50 hover:bg-gray-100 text-gray-900 px-4 py-3 transition-colors text-xs uppercase tracking-widest border border-gray-200">
                            Preview URL
                        </button>
                    </div>
                </div>
            </div>

            <!-- Form Fields -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white border border-gray-100 rounded-sm p-8">
                    <div class="space-y-6">
                        <!-- Judul -->
                        <div>
                            <label class="block text-xs font-medium uppercase tracking-widest text-gray-900 mb-2">Title *</label>
                            <input type="text" 
                                   name="judul" 
                                   value="{{ old('judul') }}" 
                                   class="w-full px-4 py-3 bg-white border border-gray-200 text-sm font-light focus:outline-none focus:border-gray-900 transition-all"
                                   required>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- Pengarang -->
                            <div>
                                <label class="block text-xs font-medium uppercase tracking-widest text-gray-900 mb-2">Author *</label>
                                <input type="text" 
                                       name="pengarang" 
                                       value="{{ old('pengarang') }}" 
                                       class="w-full px-4 py-3 bg-white border border-gray-200 text-sm font-light focus:outline-none focus:border-gray-900 transition-all"
                                       required>
                            </div>

                            <!-- Penerbit -->
                            <div>
                                <label class="block text-xs font-medium uppercase tracking-widest text-gray-900 mb-2">Publisher *</label>
                                <input type="text" 
                                       name="penerbit" 
                                       value="{{ old('penerbit') }}" 
                                       class="w-full px-4 py-3 bg-white border border-gray-200 text-sm font-light focus:outline-none focus:border-gray-900 transition-all"
                                       required>
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- Category -->
                            <div>
                                <label class="block text-xs font-medium uppercase tracking-widest text-gray-900 mb-2">Category *</label>
                                <select name="category_id" 
                                        class="w-full px-4 py-3 bg-white border border-gray-200 text-sm font-light focus:outline-none focus:border-gray-900 transition-all"
                                        required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Tahun Terbit -->
                            <div>
                                <label class="block text-xs font-medium uppercase tracking-widest text-gray-900 mb-2">Year *</label>
                                <input type="number" 
                                       name="tahun_terbit" 
                                       value="{{ old('tahun_terbit') }}" 
                                       class="w-full px-4 py-3 bg-white border border-gray-200 text-sm font-light focus:outline-none focus:border-gray-900 transition-all"
                                       min="1900" 
                                       max="{{ date('Y') }}" 
                                       required>
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- ISBN -->
                            <div>
                                <label class="block text-xs font-medium uppercase tracking-widest text-gray-900 mb-2">ISBN</label>
                                <input type="text" 
                                       name="isbn" 
                                       value="{{ old('isbn') }}" 
                                       class="w-full px-4 py-3 bg-white border border-gray-200 text-sm font-light focus:outline-none focus:border-gray-900 transition-all">
                            </div>

                            <!-- Harga -->
                            <div>
                                <label class="block text-xs font-medium uppercase tracking-widest text-gray-900 mb-2">Price *</label>
                                <input type="number" 
                                       name="harga" 
                                       value="{{ old('harga') }}" 
                                       class="w-full px-4 py-3 bg-white border border-gray-200 text-sm font-light focus:outline-none focus:border-gray-900 transition-all"
                                       min="0" 
                                       required>
                            </div>
                        </div>

                        <!-- Stock -->
                        <div>
                            <label class="block text-xs font-medium uppercase tracking-widest text-gray-900 mb-2">Stock *</label>
                            <input type="number" 
                                   name="stok" 
                                   value="{{ old('stok') }}" 
                                   class="w-full px-4 py-3 bg-white border border-gray-200 text-sm font-light focus:outline-none focus:border-gray-900 transition-all"
                                   min="0" 
                                   required>
                        </div>

                        <!-- Sinopsis -->
                        <div>
                            <label class="block text-xs font-medium uppercase tracking-widest text-gray-900 mb-2">Synopsis *</label>
                            <textarea name="sinopsis" 
                                      rows="4" 
                                      class="w-full px-4 py-3 bg-white border border-gray-200 text-sm font-light focus:outline-none focus:border-gray-900 transition-all resize-none"
                                      required>{{ old('sinopsis') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end gap-3">
                    <a href="{{ route('admin.books.index') }}" 
                       class="px-6 py-3 bg-white border border-gray-200 hover:border-gray-900 text-gray-900 text-xs uppercase tracking-widest transition-colors">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="bg-gray-900 hover:bg-gray-800 text-white px-6 py-3 transition-colors text-xs uppercase tracking-widest shadow-xl shadow-gray-200">
                        Save Book
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function toggleImageSource(source) {
    const fileSection = document.getElementById('file-input-section');
    const urlSection = document.getElementById('url-input-section');
    const preview = document.getElementById('preview-img');
    const placeholder = document.getElementById('image-placeholder');
    
    if (source === 'file') {
        fileSection.classList.remove('hidden');
        urlSection.classList.add('hidden');
    } else {
        fileSection.classList.add('hidden');
        urlSection.classList.remove('hidden');
    }
}

function previewUrl() {
    const url = document.getElementById('cover_url').value;
    if (url) {
        const preview = document.getElementById('preview-img');
        const placeholder = document.getElementById('image-placeholder');
        
        preview.src = url;
        preview.classList.remove('hidden');
        placeholder.classList.add('hidden');
    }
}

// Image preview
document.getElementById('cover_photo').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('preview-img');
            const placeholder = document.getElementById('image-placeholder');
            
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
        }
        reader.readAsDataURL(file);
    }
});
</script>
@endsection
