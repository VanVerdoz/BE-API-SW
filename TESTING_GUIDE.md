# Panduan Testing Dashboard Sidewalk.Go

## 🧪 Cara Testing Dashboard

### 1. Persiapan

#### A. Pastikan Server Berjalan
```bash
php artisan serve
```

#### B. Pastikan Database Sudah Migrate
```bash
php artisan migrate
```

#### C. Seed Data (Opsional)
Jika belum ada data, buat data dummy untuk testing:
```bash
php artisan db:seed
```

### 2. Testing Login Page

#### URL: `http://localhost:8000/login`

**Test Cases**:
1. ✅ Halaman login tampil dengan desain orange theme
2. ✅ Logo Sidewalk.Go muncul
3. ✅ Form username dan password ada
4. ✅ Tombol "Masuk" berfungsi
5. ✅ Error message muncul jika login gagal
6. ✅ Redirect ke dashboard jika login berhasil

**Test Data**:
- Gunakan username dan password yang ada di database
- Test dengan credentials yang salah untuk validasi error

### 3. Testing Dashboard Overview

#### URL: `http://localhost:8000/dashboard`

**Test Cases**:
1. ✅ Sidebar muncul dengan menu navigasi
2. ✅ Header dengan user info tampil
3. ✅ 3 Kartu statistik muncul:
   - Total Penjualan
   - Stok Tersedia
   - Transaksi Harian
4. ✅ Grafik bar chart penjualan tampil
5. ✅ Data grafik sesuai dengan database
6. ✅ Filter Mingguan/Bulanan berfungsi
7. ✅ Responsive di mobile dan desktop

**Expected Results**:
- Semua data real-time dari database
- Chart.js render dengan benar
- Warna sesuai theme orange

### 4. Testing Stok Produk

#### URL: `http://localhost:8000/produk`

**Test Cases - Index**:
1. ✅ Tabel produk tampil
2. ✅ Data produk dari database muncul
3. ✅ Kolom: No, Nama, Harga, Stok, Status, Aksi
4. ✅ Badge status (Tersedia/Menipis/Habis) sesuai stok
5. ✅ Tombol "Tambah Produk" muncul (jika role kepala_gudang)
6. ✅ Icon aksi (View/Edit/Delete) berfungsi

**Test Cases - Create** (Role: kepala_gudang):
1. ✅ Form tambah produk tampil
2. ✅ Input: Nama, Harga, Deskripsi
3. ✅ Validasi form berfungsi
4. ✅ Data tersimpan ke database
5. ✅ Redirect ke index dengan success message
6. ✅ Tombol "Batal" kembali ke index

**Test Cases - Edit** (Role: kepala_gudang):
1. ✅ Form edit tampil dengan data existing
2. ✅ Update data berfungsi
3. ✅ Validasi form berfungsi
4. ✅ Data terupdate di database
5. ✅ Redirect dengan success message

**Test Cases - Delete** (Role: kepala_gudang):
1. ✅ Konfirmasi delete muncul
2. ✅ Data terhapus dari database
3. ✅ Redirect dengan success message

### 5. Testing Transaksi Penjualan

#### URL: `http://localhost:8000/penjualan`

**Test Cases - Index**:
1. ✅ Tabel transaksi tampil
2. ✅ Data dari database muncul
3. ✅ Kolom: No, Tanggal, Cabang, Total Harga, Aksi
4. ✅ Format tanggal: dd/mm/yyyy
5. ✅ Format harga: Rp. xxx.xxx
6. ✅ Tombol "Tambah Transaksi" (jika role raider)

**Test Cases - CRUD** (Role: raider):
- Similar dengan testing Produk
- Pastikan validasi cabang_id, tanggal, total_harga

### 6. Testing Laporan Keuangan

#### URL: `http://localhost:8000/laporan-keuangan`

**Test Cases - Index**:
1. ✅ Tabel laporan tampil
2. ✅ Data dari database muncul
3. ✅ Kolom: No, Tanggal, Cabang, Total Pemasukan, Aksi
4. ✅ Tombol "Tambah Laporan" (jika role admin)

**Test Cases - CRUD** (Role: admin):
- Similar dengan testing Produk
- Pastikan validasi cabang_id, tanggal, total_pemasukan

### 7. Testing Role-Based Access

**Test untuk setiap role**:

#### Owner
```
✅ Akses dashboard
✅ View produk
✅ View transaksi
✅ View laporan
✅ CRUD cabang
✅ CRUD pengguna
❌ CRUD produk (hanya view)
❌ CRUD transaksi (hanya view)
❌ CRUD laporan (hanya view)
```

#### Admin Gudang (kepala_gudang)
```
✅ Akses dashboard
✅ CRUD produk
✅ CRUD stok
❌ CRUD transaksi
❌ CRUD laporan
```

#### Admin Finance (admin)
```
✅ Akses dashboard
✅ CRUD laporan keuangan
✅ View transaksi
✅ CRUD cabang
✅ CRUD pengguna
❌ CRUD produk
```

#### Riders (raider)
```
✅ Akses dashboard
✅ CRUD transaksi
✅ View produk
❌ CRUD produk
❌ CRUD laporan
```

### 8. Testing Responsive Design

**Breakpoints**:
- Desktop: 1920px ✅
- Laptop: 1366px ✅
- Tablet: 768px ✅
- Mobile: 375px ✅

**Test di setiap breakpoint**:
1. ✅ Sidebar responsive
2. ✅ Tabel scrollable di mobile
3. ✅ Form responsive
4. ✅ Chart responsive
5. ✅ Cards stack di mobile

### 9. Testing Security

**Test Cases**:
1. ✅ Akses `/dashboard` tanpa login → redirect ke login
2. ✅ CSRF token di semua form
3. ✅ Session timeout berfungsi
4. ✅ Logout clear session
5. ✅ Role middleware block unauthorized access

### 10. Testing UI/UX

**Checklist**:
1. ✅ Warna konsisten (orange theme)
2. ✅ Font readable
3. ✅ Spacing konsisten
4. ✅ Hover effects smooth
5. ✅ Transitions smooth (0.3s)
6. ✅ Icons dari Font Awesome muncul
7. ✅ Success/Error messages tampil
8. ✅ Loading states (jika ada)

## 🐛 Common Issues & Solutions

### Issue 1: Chart tidak muncul
**Solution**: 
- Pastikan Chart.js CDN loaded
- Check console untuk errors
- Pastikan data dari controller ada

### Issue 2: Session tidak persist
**Solution**:
- Check `.env` SESSION_DRIVER
- Clear cache: `php artisan cache:clear`
- Check session config

### Issue 3: CSRF token mismatch
**Solution**:
- Pastikan `@csrf` di semua form
- Clear browser cache
- Check middleware

### Issue 4: Role middleware tidak berfungsi
**Solution**:
- Check session('user.role')
- Pastikan middleware registered di bootstrap/app.php
- Check route middleware

## ✅ Testing Checklist

```
[ ] Login page design sesuai mockup
[ ] Dashboard dengan 3 cards statistik
[ ] Grafik bar chart penjualan
[ ] CRUD Produk (Admin Gudang)
[ ] CRUD Transaksi (Riders)
[ ] CRUD Laporan (Admin Finance)
[ ] Role-based access control
[ ] Responsive design
[ ] Security (CSRF, Auth)
[ ] UI/UX sesuai design system
```

## 📝 Test Report Template

```
Date: [DD/MM/YYYY]
Tester: [Nama]
Browser: [Chrome/Firefox/Safari]
Device: [Desktop/Mobile]

Test Results:
- Login: ✅/❌
- Dashboard: ✅/❌
- Produk: ✅/❌
- Transaksi: ✅/❌
- Laporan: ✅/❌
- Responsive: ✅/❌
- Security: ✅/❌

Issues Found:
1. [Deskripsi issue]
2. [Deskripsi issue]

Notes:
[Catatan tambahan]
```

