<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('closing_harian', function (Blueprint $table) {
            $table->bigInteger('id');
            $table->unsignedbigInteger('cabang_id');
            $table->unsignedBigInteger('pengguna_id');
            $table->date('tanggal');
            $table->decimal('total_penjualan', 12)->nullable();
            $table->decimal('total_pengeluaran', 12)->nullable();
            $table->jsonb('stok_akhir')->nullable();
            $table->string('status', 30)->nullable();
            $table->timestamp('created_at')->nullable()->default(DB::raw("now()"));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('closing_harian');
    }
};
