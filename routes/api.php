<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\DetailPenjualanController;
use App\Http\Controllers\ClosingHarianController;
use App\Http\Controllers\LaporanKeuanganController;



// ================= LOGIN =================
Route::post('/login', [AuthController::class, 'login']);


// ================= ROUTE PUBLIC =================
Route::get('/produk', [ProdukController::class, 'index']);
Route::get('/cabang', [CabangController::class, 'index']);
Route::get('/stok', [StokController::class, 'index']);


// ================= ROUTE PAKAI JWT COOKIE =================
Route::middleware(['jwt.cookie', 'jwt.auth'])->group(function () {

    // AUTH
    Route::post('/logout', [AuthController::class, 'logout']);

    // PROFILE
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::put('/profile/password', [ProfileController::class, 'updatePassword']);
    Route::post('/profile/logout', [ProfileController::class, 'logout']);


    // ==================== PENGGUNA ====================
    Route::get('/role', [PenggunaController::class, 'index']);
    Route::middleware('role:owner,admin')->group(function () {
        Route::post('/role', [PenggunaController::class, 'store']);
        Route::put('/role/{id}', [PenggunaController::class, 'update']);
        Route::delete('/role/{id}', [PenggunaController::class, 'destroy']);
    });


    // ==================== PRODUK ====================
    Route::middleware('role:owner,raider,admin')->group(function () {
        Route::get('/produk/{id}', [ProdukController::class, 'show']);
    });
    Route::middleware('role:kepala_gudang')->group(function () {
        Route::post('/produk', [ProdukController::class, 'store']);
        Route::put('/produk/{id}', [ProdukController::class, 'update']);
        Route::delete('/produk/{id}', [ProdukController::class, 'destroy']);
    });


    // ==================== CABANG ====================
    Route::middleware('role:owner,raider,kepala_gudang')->group(function () {
        Route::get('/cabang/{id}', [CabangController::class, 'show']);
    });
    Route::middleware('role:admin')->group(function () {
        Route::post('/cabang', [CabangController::class, 'store']);
        Route::delete('/cabang/{id}', [CabangController::class, 'destroy']);
        Route::put('/cabang/{id}', [CabangController::class, 'update']);
    });


    // ==================== STOK ====================
    Route::middleware('role:kepala_gudang')->group(function () {
        Route::post('/stok', [StokController::class, 'store']);
        Route::put('/stok/{id}', [StokController::class, 'update']);
        Route::delete('/stok/{id}', [StokController::class, 'destroy']);
    });


    // ==================== PENJUALAN ====================
    Route::middleware('role:owner,admin,raider,kepala_gudang')->group(function () {
        Route::get('/penjualan', [PenjualanController::class, 'index']);
    });
    Route::middleware('role:raider')->group(function () {
        Route::post('/penjualan', [PenjualanController::class, 'store']);
        Route::get('/penjualan/{id}', [PenjualanController::class, 'show']);
        Route::put('/penjualan/{id}', [PenjualanController::class, 'update']);
        Route::delete('/penjualan/{id}', [PenjualanController::class, 'destroy']);
    });


    // ================= DETAIL PENJUALAN =================
    Route::middleware('role:owner,admin,raider,kepala_gudang')->group(function () {
        Route::get('/detail-penjualan', [DetailPenjualanController::class, 'index']);
    });
    Route::middleware('role:raider,admin')->group(function () {
        Route::post('/detail-penjualan', [DetailPenjualanController::class, 'store']);
        Route::put('/detail-penjualan/{id}', [DetailPenjualanController::class, 'update']);
    });
    Route::middleware('role:admin')->group(function () {
        Route::delete('/detail-penjualan/{id}', [DetailPenjualanController::class, 'destroy']);
    });


    // ================= CLOSING HARIAN =================
    Route::middleware('role:owner,admin,kepala_gudang')->group(function () {
        Route::get('/closing-harian', [ClosingHarianController::class, 'index']);
    });
    Route::middleware('role:kepala_gudang,admin')->group(function () {
        Route::post('/closing-harian', [ClosingHarianController::class, 'store']);
        Route::put('/closing-harian/{id}', [ClosingHarianController::class, 'update']);
        Route::delete('/closing-harian/{id}', [ClosingHarianController::class, 'destroy']);
    });


    // ================= LAPORAN KEUANGAN =================
    Route::middleware('role:kepala_gudang,admin,raider,owner')->group(function () {
        Route::get('/laporan-keuangan', [LaporanKeuanganController::class, 'index']);
    });
    Route::middleware('role:admin')->group(function () {
        Route::post('/laporan-keuangan', [LaporanKeuanganController::class, 'store']);
        Route::put('/laporan-keuangan/{id}', [LaporanKeuanganController::class, 'update']);
        Route::delete('/laporan-keuangan/{id}', [LaporanKeuanganController::class, 'destroy']);
        Route::get('/laporan-keuangan/{id}', [LaporanKeuanganController::class, 'show']);
    });

});
