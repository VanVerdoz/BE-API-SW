<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    public $timestamps = false;
    public $incrementing = false;      // WAJIB! karena ID diisi manual
    protected $keyType = 'string';

    protected $table = 'produk';

    protected $fillable = [
        'nama_produk',
        'harga',
        'kategori',
        'status',
        'deskripsi'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            // Format tanggal: YYYYMMDD
            $today = date('Ymd'); // contoh: 20251115

            // Cari ID terakhir hari ini
            $last = Produk::where('id', 'LIKE', $today . '%')
                ->orderBy('id', 'desc')
                ->first();

            // Hitung nomor urut
            if ($last) {
                $num = intval(substr($last->id, -4)) + 1;
            } else {
                $num = 1;
            }

            // Gabungkan YYYYMMDD + nomor urut 4 digit
            $generatedId = $today . str_pad($num, 4, '0', STR_PAD_LEFT);

            // Convert ke integer
            $model->id = intval($generatedId);
        });
    }
}
