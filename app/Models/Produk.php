<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';
    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'nama_produk',
        'harga',
        'kategori',
        'status',
        'deskripsi'
    ];

    // Relasi ke stok
    public function stok()
    {
        return $this->hasMany(Stok::class, 'produk_id');
    }

    // Relasi ke detail penjualan
    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class, 'produk_id');
    }

    // Accessor untuk nama (karena di database nama_produk)
    public function getNamaAttribute()
    {
        return $this->nama_produk;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Produk $produk) {
            if (empty($produk->id)) {
                $lastId = Produk::max('id');
                $produk->id = $lastId ? $lastId + 1 : 1;
            }
        });
    }
}
