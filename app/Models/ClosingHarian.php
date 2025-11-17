<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClosingHarian extends Model
{
    protected $table = 'closing_harian';
    public $timestamps = false;

    protected $fillable = [
        'cabang_id',
        'pengguna_id',
        'tanggal',
        'total_penjualan',
        'stok_akhir',
        'status',
        'created_at'
    ];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class);
    }
}
