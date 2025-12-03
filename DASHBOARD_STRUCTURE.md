# Struktur Dashboard Sidewalk.Go

## 📁 File Structure

```
Be FIx/
├── app/
│   └── Http/
│       ├── Controllers/
│       │   ├── DashboardController.php          # Dashboard utama dengan grafik
│       │   ├── WebAuthController.php            # Login & Logout
│       │   └── Web/
│       │       ├── ProdukController.php         # CRUD Produk
│       │       ├── StokController.php           # CRUD Stok
│       │       ├── PenjualanController.php      # CRUD Transaksi
│       │       ├── LaporanKeuanganController.php # CRUD Laporan
│       │       ├── CabangController.php         # CRUD Cabang
│       │       └── PenggunaController.php       # CRUD Pengguna
│       └── Middleware/
│           └── WebAuthMiddleware.php            # Auth middleware untuk web
│
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php                    # Layout utama dengan sidebar
│       ├── auth/
│       │   └── login.blade.php                  # Halaman login
│       ├── dashboard/
│       │   └── index.blade.php                  # Dashboard dengan chart
│       ├── produk/
│       │   ├── index.blade.php                  # List produk
│       │   ├── create.blade.php                 # Form tambah produk
│       │   ├── edit.blade.php                   # Form edit produk
│       │   └── show.blade.php                   # Detail produk
│       ├── penjualan/
│       │   └── index.blade.php                  # List transaksi
│       └── laporan-keuangan/
│           └── index.blade.php                  # List laporan
│
└── routes/
    └── web.php                                  # Web routes
```

## 🎯 Halaman & Fitur

### 1. Login Page (`/login`)
**File**: `resources/views/auth/login.blade.php`
- Desain modern dengan gradient orange
- Logo Sidewalk.Go
- Form username & password
- Responsive design

### 2. Dashboard Overview (`/dashboard`)
**File**: `resources/views/dashboard/index.blade.php`
**Controller**: `DashboardController.php`

**Fitur**:
- 3 Kartu statistik:
  - Total Penjualan (Rp)
  - Stok Tersedia (%)
  - Transaksi Harian (count)
- Grafik Bar Chart penjualan produk
- Filter Mingguan/Bulanan
- Data real-time dari database

### 3. Stok Produk (`/produk`)
**Files**: `resources/views/produk/*.blade.php`
**Controller**: `Web/ProdukController.php`

**Fitur**:
- **Index**: Tabel list produk dengan stok
- **Create**: Form tambah produk baru (Admin Gudang)
- **Edit**: Form edit produk (Admin Gudang)
- **Show**: Detail produk
- **Delete**: Hapus produk (Admin Gudang)

**Kolom Tabel**:
- No
- Nama Produk
- Harga
- Stok (total dari tabel stok)
- Status (badge: Tersedia/Menipis/Habis)
- Aksi (View/Edit/Delete)

### 4. Transaksi Penjualan (`/penjualan`)
**Files**: `resources/views/penjualan/*.blade.php`
**Controller**: `Web/PenjualanController.php`

**Fitur**:
- **Index**: Tabel list transaksi
- **Create**: Form tambah transaksi (Riders)
- **Edit**: Form edit transaksi (Riders)
- **Show**: Detail transaksi
- **Delete**: Hapus transaksi (Riders)

**Kolom Tabel**:
- No
- Tanggal
- Cabang
- Total Harga
- Aksi

### 5. Laporan Keuangan (`/laporan-keuangan`)
**Files**: `resources/views/laporan-keuangan/*.blade.php`
**Controller**: `Web/LaporanKeuanganController.php`

**Fitur**:
- **Index**: Tabel list laporan
- **Create**: Form tambah laporan (Admin Finance)
- **Edit**: Form edit laporan (Admin Finance)
- **Show**: Detail laporan
- **Delete**: Hapus laporan (Admin Finance)

**Kolom Tabel**:
- No
- Tanggal
- Cabang
- Total Pemasukan
- Aksi

### 6. Cabang (`/cabang`)
**Controller**: `Web/CabangController.php`
**Role**: Owner, Admin

**Fitur**: CRUD lengkap untuk data cabang

### 7. Pengguna (`/pengguna`)
**Controller**: `Web/PenggunaController.php`
**Role**: Owner, Admin

**Fitur**: CRUD lengkap untuk manajemen user

## 🔐 Role & Permissions

### Owner
- ✅ Dashboard Overview
- ✅ View Stok Produk
- ✅ View Transaksi
- ✅ View Laporan Keuangan
- ✅ CRUD Cabang
- ✅ CRUD Pengguna

### Admin Gudang (kepala_gudang)
- ✅ Dashboard Overview
- ✅ CRUD Stok Produk
- ✅ CRUD Produk
- ✅ View Closing Harian

### Admin Finance (admin)
- ✅ Dashboard Overview
- ✅ CRUD Laporan Keuangan
- ✅ View Transaksi
- ✅ CRUD Cabang
- ✅ CRUD Pengguna

### Riders (raider)
- ✅ Dashboard Overview
- ✅ CRUD Transaksi Penjualan
- ✅ View Produk
- ✅ Input Detail Penjualan

## 🎨 Design System

### Colors
```css
Primary Orange: #ff6b35
Secondary Orange: #f7931e
Dark Orange: #8b2500
Background Cream: #fff5f0
Light Orange: #ffd4c4
```

### Components
- **Sidebar**: Fixed, gradient orange, width 250px
- **Cards**: Border-radius 20px, shadow
- **Buttons**: Border-radius 12px, gradient
- **Tables**: Rounded header, hover effects
- **Forms**: Border-radius 10px, focus states

### Typography
- **Font Family**: Segoe UI, Tahoma, Geneva, Verdana, sans-serif
- **Headings**: 28px (page title), 20px (section)
- **Body**: 14px
- **Small**: 12px

## 📊 Chart Configuration

**Library**: Chart.js
**Type**: Bar Chart
**Data Source**: DetailPenjualan model
**Features**:
- Dual dataset (Target vs Penjualan)
- Responsive
- Custom colors (orange theme)
- Tooltips
- Legend

## 🔄 Data Flow

1. **Login** → Session storage (token + user data)
2. **Dashboard** → Query database → Display stats & chart
3. **CRUD Operations** → Validate → Save to DB → Redirect with message
4. **Logout** → Clear session → Redirect to login

## 🚀 Quick Start

1. Akses `/login`
2. Login dengan credentials
3. Redirect ke `/dashboard`
4. Navigasi via sidebar
5. Perform CRUD sesuai role

## 📝 Notes

- Semua form menggunakan CSRF protection
- Validation di controller
- Error handling dengan try-catch
- Success/Error messages via session flash
- Responsive untuk mobile & desktop

