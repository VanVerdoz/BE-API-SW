<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Kolom "deskripsi" sekarang sudah didefinisikan di migration
        // create_produk_table. Agar migrate:fresh tidak error karena
        // duplikat kolom, kita cek dulu apakah kolom ini sudah ada.
        if (!Schema::hasColumn('produk', 'deskripsi')) {
            Schema::table('produk', function (Blueprint $table) {
                $table->text('deskripsi')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Hanya drop kolom jika memang ada, supaya aman saat rollback.
        if (Schema::hasColumn('produk', 'deskripsi')) {
            Schema::table('produk', function (Blueprint $table) {
                $table->dropColumn('deskripsi');
            });
        }
    }
};
