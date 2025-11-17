<?php

namespace App\Http\Middleware;

use Closure;

class JWTFromCookie
{
    public function handle($request, Closure $next)
    {
        if ($request->hasCookie('jwt_token')) {

            // Ambil token dari cookie
            $token = $request->cookie('jwt_token');

            // SET token ke header (WAJIB)
            $request->headers->set('Authorization', 'Bearer ' . $token);
        }

        return $next($request);
    }
}
