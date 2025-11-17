<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Pengguna extends Authenticatable implements JWTSubject
{
    public $timestamps = false;
    protected $table = 'pengguna';

    protected $fillable = [
        'username',
        'password',
        'nama_lengkap',
        'role',
        'status',
    ];

    // === Wajib untuk JWT ===
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
