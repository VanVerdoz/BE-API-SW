<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\DetailPenjualanController;
use App\Http\Controllers\ClosingHarianController;



// ================= LOGIN =================
Route::post('/login', [AuthController::class, 'login']);


// ================= ROUTE PUBLIC (TIDAK PERLU TOKEN) =================
Route::get('/produk', [ProdukController::class, 'index']);
Route::get('/cabang', [CabangController::class, 'index']);
Route::get('/stok', [StokController::class, 'index']);



// ================= ROUTE PAKAI JWT COOKIE =================
Route::middleware(['jwt.cookie', 'jwt.auth'])->group(function () {

         // AUTH
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/profile', [AuthController::class, 'profile']);

        // ========== PENGGUNA (only owner, admin) ==========
        Route::get('/role', [PenggunaController::class, 'index']);
        Route::middleware('role:owner,admin')->group(function () {
        Route::post('/role', [PenggunaController::class, 'store']);
        Route::put('/role/{id}', [PenggunaController::class, 'update']);
        Route::delete('/role/{id}', [PenggunaController::class, 'destroy']);
        });

                                // PRODUK //
            
        // owner,admin,raider — hanya bisa GET
        
        Route::middleware('role:owner,raider,admin')->group(function () {
        Route::get('/produk', [ProdukController::class, 'index']);
        Route::get('/produk/{id}', [ProdukController::class, 'show']);
        });
        // KEPALA GUDANG — full akses
        Route::middleware('role:kepala_gudang')->group(function () {
        Route::post('/produk', [ProdukController::class, 'store']);
        Route::put('/produk/{id}', [ProdukController::class, 'update']);
        Route::delete('/produk/{id}', [ProdukController::class, 'destroy']);
        });
    
        // ========== owner,raider,kepala gudang - hanya bisa GET ==========
        Route::middleware('role:owner,raider,kepala_gudang')->group(function () {
        Route::get('/cabang/{id}', [CabangController::class, 'show']);
         });
        
         // ========== Admin -  bisa POST,DELETE,UPATE ==========
        Route::middleware('role:admin')->group(function () {
        Route::post('/cabang', [CabangController::class, 'store']);
        Route::delete('/cabang/{id}', [CabangController::class, 'destroy']);
        Route::put('/cabang/{id}', [CabangController::class, 'update']);
        });
                                    // STOK //

        // ========== OWNER,RAIDER,ADMIN KEPALA GUDANG -  HANYA BISA GET ==========
        Route::middleware('role:admin,owner,raider,kepala_gudang')->group(function () {
        Route::get('/stok', [StokController::class, 'index']);
         });

        // ========== KEPALA GUDANG -  HANYA BISA POST,DELETE,UPDATE ==========
        Route::middleware('role:kepala_gudang')->group(function () {
        Route::post('/stok', [StokController::class, 'store']);
        Route::put('/stok/{id}', [StokController::class, 'update']);
        Route::delete('/stok/{id}', [StokController::class, 'destroy']);
        });


        //==================== PENJUALAN================//
        Route::middleware('role:owner,admin,raider,kepala_gudang')->group(function () {
        Route::get('/penjualan', [PenjualanController::class, 'index']);
        });
        // ADMIN DAN KEPALA GUDANG DAN RAIDER BISA POST,DELETE,UPDATE
        Route::middleware('role:raider')->group(function () {
        Route::put('/penjualan/{id}', [PenjualanController::class, 'update']);
        Route::post('/penjualan', [PenjualanController::class, 'store']);
        Route::get('/penjualan/{id}', [PenjualanController::class, 'show']);
        Route::delete('/penjualan/{id}', [PenjualanController::class, 'destroy']);
        });

        //========== DETAIL PENJUALAN=========\\

        // GET DETAIL PENJUALAN ALL
        Route::middleware('role:owner,admin,raider,kepala_gudang')->group(function () {
        Route::get('/detail-penjualan', [DetailPenjualanController::class, 'index']);
        });

        //  RAIDER BISA POST,UPDATE
        Route::middleware('role:raider,admin')->group(function () {
        Route::post('/detail-penjualan', [DetailPenjualanController::class, 'store']);
        Route::put('/detail-penjualan/{id}', [DetailPenjualanController::class, 'update']);
        });
        // HANYA ADMIN BISA DELETE
        Route::middleware('role:admin')->group(function () {
        Route::delete('/detail-penjualan/{id}', [DetailPenjualanController::class, 'destroy']);
        });

        //=======CLOSING HARIAN======\\

        // GET DETAIL PENJUALAN ALL
        Route::middleware('role:owner,admin,kepala_gudang')->group(function () {
        Route::get('/closing-harian', [ClosingHarianController::class, 'index']);
        });
        // POST UPDATE DELETE UPDATE KEPALA GUDANG,ADMIN
        Route::middleware('role:kepala_gudang,admin')->group(function () {
        Route::post('/closing-harian', [ClosingHarianController::class, 'store']);
        Route::put('/closing-harian/{id}', [ClosingHarianController::class, 'update']);
        Route::delete('/closing-harian/{id}', [ClosingHarianController::class, 'destroy']);
        });  

    });   
