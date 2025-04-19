<?php

namespace App\Providers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\{
    URL,
    RateLimiter
};
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // setup https
        if (Str::contains(URL::to('/'), ['ngrok', 'rangminangdev', 'sabrinaermayanti'])) {
            URL::forceScheme('https');
        }

        // RateLimiter::for('api', function (Request $request) {
        //     return Limit::perMinute(300)->by($request->user()?->id ?: $request->ip());
        // });

        RateLimiter::for('uploads', function (Request $request) {
            return $request->user()
                ? Limit::perMinute(300)->by($request->user()->id)
                : Limit::perMinute(20)->by($request->ip());
        });
    }
}
