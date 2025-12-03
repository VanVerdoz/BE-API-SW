# 🔐 Login Credentials untuk Testing

## ✅ Test User yang Tersedia (Password Sudah Di-Reset)

### 1. Owner (Full Access)
```
Username: Owner Sw
Password: owner123
Role: owner
```

**Atau:**
```
Username: testuser
Password: password
Role: owner
```

### 2. Admin (Finance)
```
Username: admin
Password: admin123
Role: admin
```

### 3. Admin Gudang (Warehouse)
```
Username: Admin Gudang
Password: gudang123
Role: kepala_gudang
```

### 4. Rider (Field Worker)
```
Username: Raider sw 1
Password: raider123
Role: raider
```

## Cara Login

1. Buka browser dan akses: `http://localhost:8000/login`
2. Masukkan username dan password
3. Klik tombol "Masuk"
4. Anda akan diarahkan ke dashboard

## Troubleshooting

### Error: "Maximum execution time exceeded"
**Penyebab**: Infinite loop saat memanggil API login
**Solusi**: ✅ Sudah diperbaiki! Sekarang menggunakan Auth::guard('web')->attempt() langsung tanpa HTTP request

### Error: "Username atau password salah"
**Penyebab**: 
- Username atau password tidak sesuai
- User tidak ada di database
- Password tidak di-hash dengan benar

**Solusi**:
1. Pastikan username dan password benar
2. Cek database apakah user ada
3. Gunakan credentials test user di atas

### Error: "Akun anda tidak aktif"
**Penyebab**: Status user di database adalah 'inactive'
**Solusi**: Update status user menjadi 'active' di database

## Membuat User Baru

### Via Tinker
```bash
php artisan tinker
```

```php
$user = new \App\Models\Pengguna();
$user->username = 'newuser';
$user->password = bcrypt('password123');
$user->nama_lengkap = 'New User Name';
$user->role = 'owner'; // owner, admin, kepala_gudang, raider
$user->status = 'active';
$user->save();
```

### Via Database
```sql
INSERT INTO pengguna (id, username, password, nama_lengkap, role, status)
VALUES ('USR20251124000001', 'newuser', '$2y$10$...', 'New User', 'owner', 'active');
```

**Note**: Password harus di-hash menggunakan bcrypt!

## Reset Password User

```bash
php artisan tinker
```

```php
$user = \App\Models\Pengguna::where('username', 'testuser')->first();
$user->password = bcrypt('newpassword');
$user->save();
```

## Cek User di Database

```bash
php artisan tinker
```

```php
\App\Models\Pengguna::select('id', 'username', 'role', 'status')->get();
```

---

**Last Updated**: 24 November 2025

