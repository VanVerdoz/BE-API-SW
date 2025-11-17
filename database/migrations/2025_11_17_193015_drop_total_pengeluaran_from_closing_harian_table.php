<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('closing_harian', function (Blueprint $table) {
            if (Schema::hasColumn('closing_harian', 'total_pengeluaran')) {
                $table->dropColumn('total_pengeluaran');
            }
        });
    }

    public function down()
    {
        Schema::table('closing_harian', function (Blueprint $table) {
            $table->decimal('total_pengeluaran', 15, 2)->nullable();
        });
    }
};
