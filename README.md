# Toko Buku Online - Laravel & MySQL

Website toko buku online berbasis Laravel dengan fitur lengkap untuk admin dan pelanggan.

## 🚀 Fitur Utama

### Fitur Admin
- ✅ Dashboard dengan grafik statistik (Chart.js)
- ✅ CRUD Buku lengkap dengan upload cover
- ✅ Manajemen User
- ✅ Manajemen Pesanan & konfirmasi pembayaran
- ✅ Laporan pemasukan/pengeluaran dengan grafik
- ✅ Export invoice ke PDF
- ✅ Notifikasi pesanan baru

### Fitur Pelanggan
- ✅ Registrasi dengan upload foto profil
- ✅ Katalog buku dengan filter kategori & pencarian
- ✅ Keranjang belanja
- ✅ Checkout dengan alamat lengkap
- ✅ Kalkulasi ongkir otomatis
- ✅ Metode pembayaran (COD, Transfer, E-Wallet)
- ✅ Review & rating buku
- ✅ Tracking status pesanan
- ✅ Profil user

### Fitur Umum
- ✅ Landing page animated dengan GSAP
- ✅ About Us page
- ✅ Dark/Light mode
- ✅ Responsive design (TailwindCSS)
- ✅ WhatsApp chat bubble ke admin
- ✅ Animasi smooth dengan CSS3

## 📋 Requirement

- PHP >= 8.2
- Composer
- XAMPP (MySQL + Apache)
- Node.js & NPM

## 🛠️ Instalasi di XAMPP

### 1. Install Dependencies

```bash
cd C:/xampp/htdocs/tokobuku
composer install
npm install
```

### 2. Setup Environment

File `.env` sudah dikonfigurasi. Pastikan settingnya sesuai:

```env
APP_NAME="Toko Buku Online"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tokobuku
DB_USERNAME=root
DB_PASSWORD=

WHATSAPP_NUMBER=082211599226
```

### 3. Buat Database

Database `tokobuku` sudah dibuat. Jika belum, jalankan:

```bash
C:/xampp/mysql/bin/mysql -u root -e "CREATE DATABASE tokobuku CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### 4. Jalankan Migrasi & Seeder

```bash
# Jalankan migrasi
php artisan migrate

# Jalankan seeder untuk data awal
php artisan db:seed --class=AdminSeeder
php artisan db:seed --class=CategorySeeder
php artisan db:seed --class=BookSeeder
```

### 5. Setup Storage

```bash
php artisan storage:link
```

### 6. Compile Assets

```bash
npm run build
```

### 7. Jalankan Server

```bash
php artisan serve
```

Website tersedia di: **http://localhost:8000**

## 👤 Login Credentials

### Admin
- **URL**: http://localhost:8000/login
- **Email**: admin@tokobuku.com
- **Password**: admin123

### User
- **URL**: http://localhost:8000/login
- **Email**: user@tokobuku.com
- **Password**: user123

## 📁 Struktur Database

Database memiliki 9 tabel utama:
- **users** - Data pengguna (admin & user)
- **categories** - Kategori buku
- **books** - Data buku
- **orders** - Pesanan
- **order_items** - Detail item pesanan
- **payments** - Pembayaran
- **reviews** - Review & rating buku
- **cart** - Keranjang belanja
- **expenses_income** - Laporan keuangan

## 🎨 Technology Stack

- **Backend**: Laravel 12, MySQL
- **Frontend**: TailwindCSS, Alpine.js
- **Animation**: GSAP, CSS3
- **Charts**: Chart.js
- **PDF**: DomPDF

## 📞 Support

WhatsApp: 082211599226

---

Developed with ❤️ using Laravel & TailwindCSS

