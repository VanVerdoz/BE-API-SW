<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanKeuangan extends Model
{
    public $timestamps = false;
    protected $table = 'laporan_keuangan';

    protected $fillable = [
        'cabang_id',
        'periode_awal',
        'periode_akhir',
        'total_pendapatan',
        'total_pengeluaran',
        'dibuat_oleh'
    ];
}
