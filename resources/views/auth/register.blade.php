<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Z3LF</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .serif { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="bg-[#fcfcfc] text-gray-900 antialiased min-h-screen flex items-center justify-center p-6">
    
    <div class="w-full max-w-md">
        <!-- Logo -->
        <div class="text-center mb-12">
            <h1 class="text-2xl font-bold tracking-widest text-gray-900 serif mb-3">Z3LF BOOKSTORE.</h1>
            <p class="text-sm text-gray-500 font-light">Buat akun baru</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white border border-gray-100 rounded-sm p-10">
            
            <!-- Error Messages -->
            @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-100 text-red-800 px-4 py-3 text-sm rounded-sm">
                @foreach ($errors->all() as $error)
                    <p class="font-light">{{ $error }}</p>
                @endforeach
            </div>
            @endif

            <!-- Register Form -->
            <form action="{{ route('register') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Username -->
                <div>
                    <label class="block text-xs font-medium uppercase tracking-widest text-gray-900 mb-3">Username</label>
                    <input type="text" 
                           name="username" 
                           value="{{ old('username') }}"
                           class="w-full px-4 py-4 bg-white border border-gray-200 text-sm font-light focus:outline-none focus:border-gray-900 transition-all"
                           placeholder="johndoe"
                           required
                           autofocus>
                </div>

                <!-- Name -->
                <div>
                    <label class="block text-xs font-medium uppercase tracking-widest text-gray-900 mb-3">Nama Lengkap</label>
                    <input type="text" 
                           name="name" 
                           value="{{ old('name') }}"
                           class="w-full px-4 py-4 bg-white border border-gray-200 text-sm font-light focus:outline-none focus:border-gray-900 transition-all"
                           placeholder="John Doe"
                           required>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-xs font-medium uppercase tracking-widest text-gray-900 mb-3">Email</label>
                    <input type="email" 
                           name="email" 
                           value="{{ old('email') }}"
                           class="w-full px-4 py-4 bg-white border border-gray-200 text-sm font-light focus:outline-none focus:border-gray-900 transition-all"
                           placeholder="email@example.com"
                           required>
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-xs font-medium uppercase tracking-widest text-gray-900 mb-3">Password</label>
                    <input type="password" 
                           name="password"
                           class="w-full px-4 py-4 bg-white border border-gray-200 text-sm font-light focus:outline-none focus:border-gray-900 transition-all"
                           placeholder="••••••••"
                           required>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="block text-xs font-medium uppercase tracking-widest text-gray-900 mb-3">Konfirmasi Password</label>
                    <input type="password" 
                           name="password_confirmation"
                           class="w-full px-4 py-4 bg-white border border-gray-200 text-sm font-light focus:outline-none focus:border-gray-900 transition-all"
                           placeholder="••••••••"
                           required>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-gray-900 hover:bg-gray-800 text-white font-medium py-4 px-4 transition-colors text-xs uppercase tracking-widest shadow-xl shadow-gray-200">
                    Daftar
                </button>
            </form>

            <!-- Divider -->
            <div class="my-8 flex items-center">
                <div class="flex-1 border-t border-gray-100"></div>
                <span class="px-4 text-xs text-gray-400 uppercase tracking-wider font-light">atau</span>
                <div class="flex-1 border-t border-gray-100"></div>
            </div>

            <!-- Login Link -->
            <div class="text-center space-y-4">
                <p class="text-sm text-gray-500 font-light">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-gray-900 font-medium hover:underline decoration-1 underline-offset-4">Masuk</a>
                </p>
                <a href="{{ route('landing') }}" class="inline-block text-sm text-gray-400 hover:text-gray-900 transition-colors font-light">
                    ← Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>

</body>
</html>
