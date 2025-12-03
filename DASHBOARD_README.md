# Dashboard Sidewalk.Go - Sistem Pencatatan Keuangan & Stok Produk

Dashboard web modern untuk sistem manajemen kopi keliling Sidewalk.Go dengan fitur lengkap untuk 4 role berbeda.

## 🎨 Fitur Utama

### 1. **Dashboard Overview**
- Grafik penjualan produk (Bar Chart)
- Statistik real-time:
  - Total Penjualan
  - Stok Tersedia
  - Transaksi Harian
- Visualisasi data dengan Chart.js

### 2. **Role-Based Access Control**

#### 👑 Owner
- Akses penuh ke semua fitur
- Melihat dashboard overview
- Melihat stok produk
- Melihat transaksi penjualan
- Melihat laporan keuangan
- Mengelola cabang
- Mengelola pengguna

#### 📦 Admin Gudang (Kepala Gudang)
- Mengelola stok produk (CRUD)
- Mengelola data produk
- Melihat laporan stok
- Closing harian

#### 💰 Admin Finance
- Mengelola laporan keuangan (CRUD)
- Melihat transaksi penjualan
- Mengelola cabang
- Closing harian
- Mengelola pengguna

#### 🚴 Riders (Raider)
- Mencatat transaksi penjualan (CRUD)
- Melihat produk
- Input detail penjualan

## 🚀 Cara Menggunakan

### 1. Login
- Buka browser dan akses: `http://localhost:8000/login`
- Masukkan username dan password
- Klik tombol "Masuk"

### 2. Dashboard
Setelah login, Anda akan diarahkan ke halaman dashboard yang menampilkan:
- Statistik penjualan
- Grafik penjualan produk
- Informasi stok

### 3. Menu Navigasi

#### Stok Produk
- **Lihat Produk**: Klik menu "Stok Produk" di sidebar
- **Tambah Produk**: Klik tombol "Tambah Produk" (hanya Admin Gudang)
- **Edit Produk**: Klik icon pensil pada tabel
- **Hapus Produk**: Klik icon trash pada tabel

#### Transaksi
- **Lihat Transaksi**: Klik menu "Transaksi" di sidebar
- **Tambah Transaksi**: Klik tombol "Tambah Transaksi" (hanya Riders)
- **Edit Transaksi**: Klik icon pensil pada tabel
- **Hapus Transaksi**: Klik icon trash pada tabel

#### Laporan Keuangan
- **Lihat Laporan**: Klik menu "Laporan Keuangan" di sidebar
- **Tambah Laporan**: Klik tombol "Tambah Laporan" (hanya Admin Finance)
- **Edit Laporan**: Klik icon pensil pada tabel
- **Hapus Laporan**: Klik icon trash pada tabel

## 🎨 Desain & UI/UX

### Color Scheme
- **Primary**: Orange (#ff6b35, #f7931e)
- **Background**: Cream (#fff5f0)
- **Accent**: Dark Orange (#8b2500)

### Komponen
- **Sidebar**: Navigasi fixed dengan gradient orange
- **Cards**: Rounded corners dengan shadow
- **Tables**: Modern dengan hover effects
- **Buttons**: Gradient dengan smooth transitions
- **Forms**: Clean dengan focus states

## 📱 Responsive Design
Dashboard sudah responsive dan dapat diakses dari:
- Desktop (1920px+)
- Laptop (1366px - 1920px)
- Tablet (768px - 1366px)
- Mobile (< 768px)

## 🔐 Keamanan
- Session-based authentication
- CSRF protection
- Role-based middleware
- Input validation

## 📊 Teknologi yang Digunakan
- **Backend**: Laravel 12
- **Frontend**: Blade Templates
- **Styling**: Custom CSS
- **Charts**: Chart.js
- **Icons**: Font Awesome 6.4.0

## 🛠️ Setup & Instalasi

1. **Clone Repository**
```bash
git clone <repository-url>
cd "Be FIx"
```

2. **Install Dependencies**
```bash
composer install
```

3. **Setup Environment**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Database Migration**
```bash
php artisan migrate
```

5. **Run Server**
```bash
php artisan serve
```

6. **Akses Dashboard**
```
http://localhost:8000/login
```

## 📝 Default Credentials

Gunakan credentials yang sudah ada di database untuk login sesuai role masing-masing.

## 🎯 Fitur Mendatang
- Export laporan ke PDF/Excel
- Notifikasi real-time
- Dark mode
- Multi-language support
- Advanced analytics

## 📞 Support
Untuk bantuan lebih lanjut, hubungi tim development Sidewalk.Go

---

**Dibuat dengan ❤️ untuk Sidewalk.Go**

