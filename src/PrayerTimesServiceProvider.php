<?php

namespace Tugrandemirel\PrayerTimes;

use Illuminate\Support\ServiceProvider;
use Tugrandemirel\PrayerTimes\Services\AladhanApiService;
use Tugrandemirel\PrayerTimes\Services\PrayerTimesService;

class PrayerTimesServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/Config/prayer-times.php', 'prayer-times'
        );

        $this->app->singleton(AladhanApiService::class, function ($app) {
            return new AladhanApiService();
        });

        $this->app->singleton('prayer-times', function ($app) {
            return new PrayerTimesService($app->make(AladhanApiService::class));
        });
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/Config/prayer-times.php' => config_path('prayer-times.php'),
        ], 'prayer-times-config');
    }
}
