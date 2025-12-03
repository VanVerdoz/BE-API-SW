<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('request_stok_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('request_id')->nullable();
            $table->integer('produk_id')->nullable();
            $table->integer('jumlah');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('request_stok_detail');
    }
};

