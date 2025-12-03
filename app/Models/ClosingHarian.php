<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClosingHarian extends Model
{
    protected $table = 'closing_harian';
    public $timestamps = false;
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'cabang_id',
        'pengguna_id',
        'tanggal',
        'total_penjualan',
        'stok_akhir',
        'status',
        'created_at'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $today = date('Ymd');
            $last = ClosingHarian::where('id', 'LIKE', $today . '%')
                ->orderBy('id', 'desc')
                ->first();

            $num = $last ? intval(substr($last->id, -4)) + 1 : 1;
            $model->id = intval($today . str_pad($num, 4, '0', STR_PAD_LEFT));
        });
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class);
    }
}
