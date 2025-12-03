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
	    // Di schema awal (create_cabang_table) kolom "telepon" sudah tidak ada.
	    // Agar migrate:fresh tidak error, pastikan kolom ini memang ada
	    // sebelum dicoba di-drop.
	    if (Schema::hasColumn('cabang', 'telepon')) {
	        Schema::table('cabang', function (Blueprint $table) {
	            $table->dropColumn('telepon');
	        });
	    }
	}

	public function down(): void
	{
	    // Jika rollback, tambahkan kembali kolom hanya jika belum ada.
	    if (!Schema::hasColumn('cabang', 'telepon')) {
	        Schema::table('cabang', function (Blueprint $table) {
	            $table->string('telepon', 20)->nullable();
	        });
	    }
	}

};
