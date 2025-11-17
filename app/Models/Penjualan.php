<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = 'penjualan';

    public $timestamps = false;

    protected $fillable = [
        'cabang_id',
        'pengguna_id',
        'tanggal',
        'total',
        'metode_pembayaran',
        'keterangan'
    ];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class);
    }
    public function detail_penjualan()
    {
        return $this->hasMany(DetailPenjualan::class, 'penjualan_id');
    }
}
