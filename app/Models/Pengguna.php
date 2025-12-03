<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Pengguna extends Authenticatable implements JWTSubject
{
    public $timestamps = false;
    protected $table = 'pengguna';

    // Pakai ID integer auto-increment standar Laravel (sesuai migration `$table->id()`)
    // -> tidak perlu override primaryKey / incrementing / keyType di sini.

    protected $fillable = [
        'username',
        'password',
        'nama_lengkap',
        'role',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Pengguna $user) {
            $username = strtolower($user->username ?? '');

            $crc = sprintf('%u', crc32($username));
            $digits = preg_replace('/\D/', '', $crc);
            $prefixStr = substr(str_pad($digits, 5, '0', STR_PAD_LEFT), 0, 5);
            $prefix = (int) $prefixStr;

            $min = $prefix * 1000;
            $max = $min + 999;

            $lastId = Pengguna::whereBetween('id', [$min, $max])->max('id');
            if ($lastId) {
                $suffix = ($lastId - $min) + 1;
            } else {
                $suffix = 1;
            }

            if ($suffix > 999) {
                throw new \RuntimeException('Kapasitas ID untuk prefix ini sudah penuh');
            }

            $user->id = $min + $suffix;
        });
    }

    // === JWT ===
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
