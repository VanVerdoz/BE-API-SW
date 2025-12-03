# 🚀 Quick Start Guide - Dashboard Sidewalk.Go

## 📌 Langkah Cepat Memulai

### 1️⃣ Pastikan Server Berjalan

```bash
# Di terminal, jalankan:
php artisan serve
```

Anda akan melihat output seperti:
```
Starting Laravel development server: http://127.0.0.1:8000
```

### 2️⃣ Buka Browser

Akses URL berikut di browser:
```
http://localhost:8000
```

Anda akan otomatis diarahkan ke halaman login.

### 3️⃣ Login

**Halaman Login** akan menampilkan:
- Logo Sidewalk.Go di sebelah kiri
- Form login di sebelah kanan dengan background orange
- Input Username
- Input Password
- Tombol "Masuk"

**Gunakan credentials** yang ada di database sesuai role:
- Owner
- Admin Gudang (kepala_gudang)
- Admin Finance (admin)
- Riders (raider)

### 4️⃣ Setelah Login Berhasil

Anda akan diarahkan ke **Dashboard Overview** yang menampilkan:

#### A. Sidebar (Kiri)
- Logo Sidewalk.Go
- Menu navigasi:
  - 🏠 Dashboard
  - 📦 Stok Produk (jika role: owner, admin, kepala_gudang)
  - 🛒 Transaksi (jika role: owner, raider, admin)
  - 📊 Laporan Keuangan (jika role: owner, admin)
  - 🏪 Cabang (jika role: owner, admin)
  - 👥 Pengguna (jika role: owner, admin)
- User info & tombol Logout di bawah

#### B. Header (Atas)
- Greeting: "Hello, Welcome"
- Tanggal hari ini
- Icon notifikasi
- User avatar & info

#### C. Content Area (Tengah)
**3 Kartu Statistik:**
1. 💰 Total Penjualan (Rp)
2. 📦 Stok Tersedia (%)
3. 🧾 Transaksi Harian (count)

**Grafik Penjualan:**
- Bar chart dengan 2 dataset (Target & Penjualan)
- Filter: Mingguan / Bulanan
- Data real-time dari database

## 🎯 Navigasi Menu

### 📦 Stok Produk

**Akses**: Klik "Stok Produk" di sidebar

**Tampilan**:
- Tabel list produk
- Kolom: No, Nama Produk, Harga, Stok, Status, Aksi
- Badge status: Tersedia (hijau), Menipis (kuning), Habis (merah)

**Aksi** (jika role: kepala_gudang):
- ➕ Tambah Produk: Klik tombol "Tambah Produk"
- 👁️ Lihat Detail: Klik icon mata
- ✏️ Edit: Klik icon pensil
- 🗑️ Hapus: Klik icon trash (dengan konfirmasi)

### 🛒 Transaksi

**Akses**: Klik "Transaksi" di sidebar

**Tampilan**:
- Tabel list transaksi penjualan
- Kolom: No, Tanggal, Cabang, Total Harga, Aksi

**Aksi** (jika role: raider):
- ➕ Tambah Transaksi: Klik tombol "Tambah Transaksi"
- 👁️ Lihat Detail: Klik icon mata
- ✏️ Edit: Klik icon pensil
- 🗑️ Hapus: Klik icon trash (dengan konfirmasi)

### 📊 Laporan Keuangan

**Akses**: Klik "Laporan Keuangan" di sidebar

**Tampilan**:
- Tabel list laporan keuangan
- Kolom: No, Tanggal, Cabang, Total Pemasukan, Aksi

**Aksi** (jika role: admin):
- ➕ Tambah Laporan: Klik tombol "Tambah Laporan"
- 👁️ Lihat Detail: Klik icon mata
- ✏️ Edit: Klik icon pensil
- 🗑️ Hapus: Klik icon trash (dengan konfirmasi)

### 🏪 Cabang

**Akses**: Klik "Cabang" di sidebar (jika role: owner, admin)

**Fitur**: CRUD lengkap untuk data cabang

### 👥 Pengguna

**Akses**: Klik "Pengguna" di sidebar (jika role: owner, admin)

**Fitur**: CRUD lengkap untuk manajemen user

## 💡 Tips Penggunaan

### 1. Menambah Data Baru
1. Klik menu yang diinginkan (misal: Stok Produk)
2. Klik tombol "Tambah [Nama Module]"
3. Isi form yang tersedia
4. Klik tombol "Simpan"
5. Anda akan diarahkan kembali ke list dengan pesan sukses

### 2. Mengedit Data
1. Di tabel, klik icon pensil (✏️) pada baris yang ingin diedit
2. Form edit akan muncul dengan data existing
3. Ubah data yang diinginkan
4. Klik tombol "Update"
5. Data akan terupdate dan muncul pesan sukses

### 3. Menghapus Data
1. Di tabel, klik icon trash (🗑️) pada baris yang ingin dihapus
2. Konfirmasi akan muncul
3. Klik "OK" untuk menghapus
4. Data akan terhapus dan muncul pesan sukses

### 4. Melihat Detail
1. Di tabel, klik icon mata (👁️) pada baris yang ingin dilihat
2. Halaman detail akan muncul dengan informasi lengkap
3. Klik tombol "Kembali" untuk kembali ke list

### 5. Logout
1. Scroll ke bawah sidebar
2. Klik tombol "Logout" berwarna merah
3. Anda akan diarahkan kembali ke halaman login

## ⚠️ Troubleshooting

### Masalah: Tidak bisa login
**Solusi**:
- Pastikan username dan password benar
- Check database apakah user sudah ada
- Clear browser cache

### Masalah: Grafik tidak muncul
**Solusi**:
- Refresh halaman (F5)
- Check console browser untuk error
- Pastikan ada data di database

### Masalah: Menu tidak muncul
**Solusi**:
- Check role user di session
- Pastikan middleware berfungsi
- Logout dan login kembali

### Masalah: Form tidak bisa submit
**Solusi**:
- Check validasi form
- Pastikan semua field required terisi
- Check console untuk error

## 📱 Akses dari Mobile

Dashboard sudah responsive dan bisa diakses dari mobile:
1. Buka browser di HP
2. Akses URL yang sama: `http://[IP-SERVER]:8000`
3. Login seperti biasa
4. Sidebar akan otomatis menyesuaikan untuk mobile

## 🎨 Fitur UI/UX

- **Hover Effects**: Semua button dan row tabel punya hover effect
- **Smooth Transitions**: Animasi smooth 0.3s
- **Color Coding**: Badge status dengan warna berbeda
- **Icons**: Font Awesome untuk visual yang jelas
- **Responsive**: Otomatis menyesuaikan ukuran layar

## 📞 Butuh Bantuan?

Jika mengalami kesulitan:
1. Baca dokumentasi lengkap di `DASHBOARD_README.md`
2. Check struktur di `DASHBOARD_STRUCTURE.md`
3. Ikuti testing guide di `TESTING_GUIDE.md`

---

**Selamat menggunakan Dashboard Sidewalk.Go! ☕🚴**

