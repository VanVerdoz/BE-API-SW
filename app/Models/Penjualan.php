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
        'keterangan',
        'dibuat_oleh'
    ];

    // Accessor untuk total_harga (karena di database kolom 'total')
    public function getTotalHargaAttribute()
    {
        return $this->total;
    }

    // Mutator untuk total_harga
    public function setTotalHargaAttribute($value)
    {
        $this->attributes['total'] = $value;
    }

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
