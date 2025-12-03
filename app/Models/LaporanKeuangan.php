<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanKeuangan extends Model
{
    public $timestamps = false;
    protected $table = 'laporan_keuangan';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'cabang_id',
        'periode_awal',
        'periode_akhir',
        'total_pendapatan',
        'dibuat_oleh'
    ];

    // Relasi ke cabang
    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'cabang_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function (LaporanKeuangan $lap) {
            if (empty($lap->id)) {
                $lastId = LaporanKeuangan::max('id');
                $lap->id = $lastId ? $lastId + 1 : 1;
            }
        });
    }
}
