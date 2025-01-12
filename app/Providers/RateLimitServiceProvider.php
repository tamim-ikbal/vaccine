<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class RateLimitServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        RateLimiter::for('enroll.status', function (Request $request) {
            return Limit::perMinute(10)->by($request->input('nid'));
        });
        RateLimiter::for('verification.send', function (Request $request) {
            return Limit::perMinutes(1, 2)->by(
                $request->input('nid').$request->input('field_value')
            );
        });
        RateLimiter::for('verification.verify', function (Request $request) {
            return Limit::perMinute(5)->by(
                $request->input('nid').$request->input('field_value').$request->input('code')
            );
        });
    }
}
