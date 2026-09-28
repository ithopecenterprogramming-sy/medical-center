<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
       RateLimiter::for('login', function (Request $request) {
            return Limit::perMinutes(5, 5)->by(
                $request->input('email', 'guest') . '|' . $request->ip()
            );
        });
    }
}