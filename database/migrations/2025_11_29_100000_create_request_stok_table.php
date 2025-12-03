<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('request_stok', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cabang_id')->nullable();
            $table->integer('raider_id')->nullable();
            $table->timestamp('tanggal')->nullable()->useCurrent();
            $table->string('status', 20)->nullable()->default('pending');
            $table->text('catatan')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('request_stok');
    }
};

