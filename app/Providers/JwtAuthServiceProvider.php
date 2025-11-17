<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Tymon\JWTAuth\JWTGuard;
use Tymon\JWTAuth\Contracts\Providers\Auth;
use Tymon\JWTAuth\Contracts\Providers\JWT;
use Tymon\JWTAuth\JWTAuth;

class JwtAuthServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register JWT driver untuk guard API
        auth()->extend('jwt', function ($app, $name, array $config) {

            $guard = new JWTGuard(
                $app['tymon.jwt'],
                $app['auth']->createUserProvider($config['provider']),
                $app['request']
            );

            $app['request']->setUserResolver(function () use ($guard) {
                return $guard->user();
            });

            return $guard;
        });
    }

    public function boot()
    {
        //
    }
}
