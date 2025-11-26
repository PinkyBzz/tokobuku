<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku - BookHaven Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'inter': ['Inter', 'sans-serif'],
                    },
                    colors: {
                        'primary': '#3B82F6',
                        'primary-dark': '#1E40AF',
                        'secondary': '#64748B',
                        'accent': '#F1F5F9',
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="font-inter bg-slate-50">

    <!-- Sidebar -->
    <div class="flex h-screen">
        <aside class="w-64 bg-white border-r border-slate-200 flex-shrink-0 shadow-sm">
            <div class="p-6 border-b border-slate-200">
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center">
                        <i class="fas fa-book-open text-white text-sm"></i>
                    </div>
                    <h1 class="text-xl font-bold text-slate-900">BookHaven</h1>
                </div>
                <p class="text-sm text-slate-500 mt-1">Admin Panel</p>
            </div>
            
            <nav class="p-4">
                <div class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2 text-slate-700 hover:bg-slate-100 hover:text-primary transition-colors rounded-lg">
                        <i class="fas fa-home mr-3"></i> 
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('admin.books.index') }}" class="flex items-center px-3 py-2 bg-primary/10 text-primary rounded-lg border-l-2 border-primary">
                        <i class="fas fa-book mr-3"></i> 
                        <span class="font-medium">Manage Books</span>
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="flex items-center px-3 py-2 text-slate-700 hover:bg-slate-100 hover:text-primary transition-colors rounded-lg">
                        <i class="fas fa-tags mr-3"></i> 
                        <span>Categories</span>
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="flex items-center px-3 py-2 text-slate-700 hover:bg-slate-100 hover:text-primary transition-colors rounded-lg">
                        <i class="fas fa-shopping-cart mr-3"></i> 
                        <span>Orders</span>
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="flex items-center px-3 py-2 text-slate-700 hover:bg-slate-100 hover:text-primary transition-colors rounded-lg">
                        <i class="fas fa-users mr-3"></i> 
                        <span>Users</span>
                    </a>
                    <a href="{{ route('admin.reports.index') }}" class="flex items-center px-3 py-2 text-slate-700 hover:bg-slate-100 hover:text-primary transition-colors rounded-lg">
                        <i class="fas fa-chart-line mr-3"></i> 
                        <span>Reports</span>
                    </a>
                </div>
                
                <div class="mt-8 pt-4 border-t border-slate-200">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-3 py-2 text-red-600 hover:bg-red-50 transition-colors rounded-lg">
                            <i class="fas fa-sign-out-alt mr-3"></i> 
                            <span>Sign Out</span>
                        </button>
                    </form>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-auto">
            <!-- Header -->
            <header class="bg-white border-b border-slate-200">
                <div class="px-6 py-4 flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900">Add New Book</h2>
                        <p class="text-slate-600">Fill in the details to add a new book to your collection</p>
                    </div>
                    <a href="{{ route('admin.books.index') }}" class="px-4 py-2 text-slate-600 hover:text-primary transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i> Back to Books
                    </a>
                </div>
            </header>
            <!-- Content -->
            <div class="p-6">
                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-lg mb-6">
                        <div class="flex items-start">
                            <i class="fas fa-exclamation-circle mt-0.5 mr-2"></i>
                            <div>
                                <p class="font-semibold mb-1">Please fix the following errors:</p>
                                <ul class="list-disc list-inside text-sm">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="bg-white rounded-lg border border-slate-200 p-6">
                    <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                            <!-- Left Column - Image Upload -->
                            <div class="lg:col-span-1">
                                <label class="block text-sm font-semibold text-slate-700 mb-3">
                                    <i class="fas fa-image text-primary mr-2"></i>
                                    Book Cover
                                </label>
                                <div class="border-2 border-dashed border-slate-300 rounded-lg p-6 text-center hover:border-primary transition-colors">
                                    <div id="image-preview" class="hidden">
                                        <img id="preview-img" class="max-w-full h-64 mx-auto rounded-lg shadow-lg mb-4 object-cover" />
                                        <p class="text-sm text-slate-600">Preview</p>
                                    </div>
                                    <div id="upload-placeholder">
                                        <i class="fas fa-cloud-upload-alt text-5xl text-slate-400 mb-4"></i>
                                        <p class="text-lg font-semibold text-slate-700 mb-1">Click or drag & drop</p>
                                        <p class="text-sm text-slate-500">PNG, JPG, GIF up to 2MB</p>
                                    </div>
                                    <input type="file" name="cover_photo" id="cover_photo" class="hidden" accept="image/*">
                                    <button type="button" onclick="document.getElementById('cover_photo').click()" class="mt-4 px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors">
                                        Choose File
                                    </button>
                                </div>
                            </div>

                            <!-- Right Columns - Form Fields -->
                            <div class="lg:col-span-2 space-y-6">
                                <!-- Judul -->
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                                        Title *
                                    </label>
                                    <input type="text" name="judul" value="{{ old('judul') }}" 
                                           class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                           placeholder="Enter book title" required>
                                </div>

                                <div class="grid grid-cols-2 gap-6">
                                    <!-- Pengarang -->
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                                            Author *
                                        </label>
                                        <input type="text" name="pengarang" value="{{ old('pengarang') }}" 
                                               class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                               placeholder="Author name" required>
                                    </div>

                                    <!-- Penerbit -->
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                                            Publisher *
                                        </label>
                                        <input type="text" name="penerbit" value="{{ old('penerbit') }}" 
                                               class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                               placeholder="Publisher name" required>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-6">
                                    <!-- Kategori -->
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                                            Category *
                                        </label>
                                        <select name="category_id" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors" required>
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
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                                            Year Published *
                                        </label>
                                        <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit') }}" 
                                               class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                               placeholder="2024" min="1900" max="{{ date('Y') }}" required>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-6">
                                    <!-- ISBN -->
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                                            ISBN
                                        </label>
                                        <input type="text" name="isbn" value="{{ old('isbn') }}" 
                                               class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                               placeholder="978-xxx-xxx-xxx-x">
                                    </div>

                                    <!-- Jumlah Halaman -->
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                                            Pages
                                        </label>
                                        <input type="number" name="jumlah_halaman" value="{{ old('jumlah_halaman') }}" 
                                               class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                               placeholder="250" min="1">
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-6">
                                    <!-- Harga -->
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                                            Price *
                                        </label>
                                        <input type="number" name="harga" value="{{ old('harga') }}" 
                                               class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                               placeholder="50000" min="0" required>
                                    </div>

                                    <!-- Stok -->
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                                            Stock *
                                        </label>
                                        <input type="number" name="stok" value="{{ old('stok') }}" 
                                               class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                               placeholder="10" min="0" required>
                                    </div>
                                </div>

                                <!-- Sinopsis -->
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                                        Synopsis
                                    </label>
                                    <textarea name="sinopsis" rows="4" 
                                              class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors resize-none"
                                              placeholder="Enter book synopsis...">{{ old('sinopsis') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex justify-end space-x-3 pt-6 mt-6 border-t border-slate-200">
                            <a href="{{ route('admin.books.index') }}" class="px-6 py-2.5 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition-colors">
                                Cancel
                            </a>
                            <button type="submit" class="px-6 py-2.5 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors">
                                <i class="fas fa-save mr-2"></i>
                                Save Book
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Image preview
        document.getElementById('cover_photo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-img').src = e.target.result;
                    document.getElementById('image-preview').classList.remove('hidden');
                    document.getElementById('upload-placeholder').classList.add('hidden');
                }
                reader.readAsDataURL(file);
            }
        });
    </script>

</body>
</html>
