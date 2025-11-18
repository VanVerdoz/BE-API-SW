<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Pengguna extends Authenticatable implements JWTSubject
{
    public $timestamps = false;
    protected $table = 'pengguna';

    // === ID CUSTOM ===
    protected $primaryKey = 'id';
    public $incrementing = false;     // TIDAK autoincrement
    protected $keyType = 'string';    // ID berupa string

    protected $fillable = [
        'username',
        'password',
        'nama_lengkap',
        'role',
    ];

    // === AUTO GENERATE ID ===
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            // Ambil 3 huruf pertama dari nama lengkap
            $prefix = strtoupper(substr($model->nama_lengkap, 0, 3));

            // Timestamp: YYYYMMDDHHMMSS
            $timestamp = now()->format('YmdHis');

            // Set ID
            $model->id = $prefix . $timestamp;
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
