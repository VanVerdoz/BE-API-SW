<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestStokDetail extends Model
{
    protected $table = 'request_stok_detail';
    protected $primaryKey = 'id_detail';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_detail',
        'id_permintaan',
        'id_produk',
        'jumlah',
    ];

    public function request()
    {
        return $this->belongsTo(RequestStok::class, 'id_permintaan', 'id_permintaan');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }
}
