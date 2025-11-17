<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    public function handle($request, Closure $next)
    {
        try {
            // Ambil token dari cookie
            $token = $request->cookie('jwt_token');

            if (!$token) {
                return response()->json(['message' => 'Token tidak ditemukan (cookie kosong)'], 401);
            }

            // Set token ke JWTAuth
            JWTAuth::setToken($token);

            // Auth user
            $user = JWTAuth::authenticate();
            if (!$user) {
                return response()->json(['message' => 'User tidak ditemukan'], 401);
            }

            // Simpan user ke request (opsional)
            $request->merge(['auth_user' => $user]);

        } catch (Exception $e) {

            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['message' => 'Token tidak valid'], 401);
            }

            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['message' => 'Token expired'], 401);
            }

            return response()->json(['message' => 'Token tidak ditemukan'], 401);
        }

        return $next($request);
    }
}
