<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('cabang', function (Blueprint $table) {
        $table->unsignedBigInteger('id')->change();
    });

    Schema::table('produk', function (Blueprint $table) {
        $table->unsignedBigInteger('id')->change();
    });

    Schema::table('pengguna', function (Blueprint $table) {
        $table->unsignedBigInteger('id')->change();
    });

    Schema::table('penjualan', function (Blueprint $table) {
        $table->unsignedBigInteger('cabang_id')->change();
        $table->unsignedBigInteger('pengguna_id')->change();
    });

    Schema::table('stok', function (Blueprint $table) {
        $table->unsignedBigInteger('cabang_id')->change();
        $table->unsignedBigInteger('produk_id')->change();
    });

    Schema::table('detail_penjualan', function (Blueprint $table) {
        $table->unsignedBigInteger('penjualan_id')->change();
        $table->unsignedBigInteger('produk_id')->change();
    });
}

};
