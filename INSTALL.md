# 📖 PANDUAN INSTALASI TOKO BUKU ONLINE

## Langkah-langkah Instalasi di XAMPP

### 1️⃣ Persiapan Awal

**Pastikan sudah terinstall:**
- XAMPP (dengan MySQL dan Apache)
- PHP >= 8.2
- Composer
- Node.js & NPM

**Download project ini ke:**
```
C:\xampp\htdocs\tokobuku
```

---

### 2️⃣ Install Dependencies

Buka **Command Prompt** atau **Git Bash**, lalu jalankan:

```bash
cd C:\xampp\htdocs\tokobuku

# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

---

### 3️⃣ Setup Environment

File `.env` sudah ada dan sudah dikonfigurasi. Pastikan settingnya seperti ini:

```env
APP_NAME="Toko Buku Online"
APP_ENV=local
APP_KEY=base64:xxxxx (sudah ada)
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tokobuku
DB_USERNAME=root
DB_PASSWORD=

WHATSAPP_NUMBER=082211599226
```

---

### 4️⃣ Buat Database

**Opsi A: Via phpMyAdmin**
1. Buka browser, akses: http://localhost/phpmyadmin
2. Klik "New" untuk database baru
3. Nama database: `tokobuku`
4. Collation: `utf8mb4_unicode_ci`
5. Klik "Create"

**Opsi B: Via Command Line**
```bash
C:\xampp\mysql\bin\mysql -u root

# Setelah masuk ke MySQL, ketik:
CREATE DATABASE tokobuku CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
exit;
```

**Opsi C: Import SQL yang sudah ada**
```bash
# Import file SQL yang sudah disediakan
C:\xampp\mysql\bin\mysql -u root tokobuku < tokobuku_database.sql
```

---

### 5️⃣ Jalankan Migrasi & Seeder

**Jika belum import SQL**, jalankan migrasi dan seeder:

```bash
# Jalankan migrasi untuk membuat tabel
php artisan migrate

# Jalankan seeder untuk data awal
php artisan db:seed --class=AdminSeeder
php artisan db:seed --class=CategorySeeder
php artisan db:seed --class=BookSeeder
```

**Atau jalankan semuanya sekaligus:**
```bash
php artisan migrate:fresh --seed
```

---

### 6️⃣ Setup Storage

```bash
php artisan storage:link
```

Perintah ini membuat symbolic link dari `storage/app/public` ke `public/storage` untuk upload file.

---

### 7️⃣ Compile Assets (Opsional)

Jika ingin menggunakan asset yang sudah dikompilasi:

```bash
# Development mode (file tidak diminify)
npm run dev

# Production mode (file diminify)
npm run build
```

**Note:** Kita sudah menggunakan CDN untuk TailwindCSS dan library lainnya, jadi step ini opsional.

---

### 8️⃣ Jalankan Server Laravel

```bash
php artisan serve
```

Server akan berjalan di: **http://localhost:8000**

---

## 🔐 Akun Login Default

### Admin
- **URL**: http://localhost:8000/login
- **Email**: `admin@tokobuku.com`
- **Password**: `admin123`

### User/Pelanggan
- **URL**: http://localhost:8000/login
- **Email**: `user@tokobuku.com`
- **Password**: `user123`

---

## 📂 Struktur Project

```
tokobuku/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # Controller untuk admin
│   │   │   ├── User/           # Controller untuk user
│   │   │   └── AuthController.php
│   │   └── Middleware/
│   │       ├── AdminMiddleware.php
│   │       └── UserMiddleware.php
│   └── Models/                 # Model database
├── database/
│   ├── migrations/             # File migrasi database
│   └── seeders/                # Seeder data awal
├── resources/
│   └── views/
│       ├── auth/               # Halaman login/register
│       ├── admin/              # Halaman admin
│       ├── user/               # Halaman user
│       ├── landing.blade.php   # Landing page
│       └── about.blade.php     # About page
├── routes/
│   └── web.php                 # Route aplikasi
└── public/
    └── storage/                # Link ke storage (upload files)
```

---

## 🎯 Fitur yang Sudah Dibuat

✅ **Database & Models**
- 9 tabel lengkap dengan relasi
- User, Books, Orders, Cart, Reviews, dll

✅ **Authentication**
- Login/Register
- Role (Admin & User)
- Middleware protection

✅ **Landing Page**
- Responsive design dengan TailwindCSS
- Animasi GSAP
- WhatsApp floating button

✅ **About Page**
- Animated sections
- Team showcase

✅ **Routes**
- Routes untuk admin dan user sudah lengkap
- Protected dengan middleware

---

## 🚀 Next Steps (Lanjutan Development)

Untuk melengkapi project, Anda perlu membuat:

1. **Admin Dashboard** - `resources/views/admin/dashboard.blade.php`
2. **CRUD Buku** - Views untuk create, edit, delete buku
3. **Manajemen Order** - Halaman daftar dan detail order
4. **User Catalog** - Halaman katalog buku untuk user
5. **Cart & Checkout** - Keranjang dan proses checkout
6. **Reports** - Laporan keuangan dengan Chart.js
7. **PDF Invoice** - Generate invoice menggunakan DomPDF

Controller sudah dibuat, tinggal isi logicnya di:
- `app/Http/Controllers/Admin/`
- `app/Http/Controllers/User/`

---

## ❓ Troubleshooting

### Error: SQLSTATE[HY000] [1045] Access denied
- Cek username/password database di `.env`
- Pastikan MySQL XAMPP sudah running

### Error: Class not found
```bash
composer dump-autoload
php artisan clear-cache
```

### Error: Permission denied (storage)
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### Assets tidak muncul
```bash
php artisan storage:link
npm run build
```

### Port 8000 sudah digunakan
```bash
# Gunakan port lain
php artisan serve --port=8080
```

---

## 📞 Bantuan & Support

- WhatsApp: 082211599226
- Email: admin@tokobuku.com

---

## 📝 Catatan Penting

1. **Jangan lupa** jalankan XAMPP (Apache & MySQL) sebelum menjalankan project
2. **File .env** jangan di-upload ke GitHub (sudah ada di .gitignore)
3. **Password default** harus diganti saat production
4. **Folder storage** harus writable
5. **Database backup** ada di file `tokobuku_database.sql`

---

**Happy Coding! 🚀**
