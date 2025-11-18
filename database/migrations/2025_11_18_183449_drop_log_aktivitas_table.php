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
    Schema::dropIfExists('log_aktivitas');
}

public function down()
{
    Schema::create('log_aktivitas', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('pengguna_id');
        $table->string('aksi');
        $table->timestamp('waktu')->useCurrent();
    });
}

};
