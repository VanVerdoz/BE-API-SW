<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestStok extends Model
{
    protected $table = 'request_stok';
    protected $primaryKey = 'id_permintaan';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_permintaan',
        'id_raider',
        'id_cabang',
        'status_permintaan',
        'keterangan',
        'disetujui_oleh',
        'waktu_disetujui',
        'dibuat_pada',
        'diperbarui_pada',
    ];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'id_cabang');
    }

    public function raider()
    {
        return $this->belongsTo(Pengguna::class, 'id_raider');
    }

    public function details()
    {
        return $this->hasMany(RequestStokDetail::class, 'id_permintaan', 'id_permintaan');
    }
}
