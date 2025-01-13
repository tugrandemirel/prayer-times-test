<?php

namespace Tugrandemirel\PrayerTimes;

use Illuminate\Support\ServiceProvider;
use Tugrandemirel\PrayerTimes\Services\AladhanApiService;
use Tugrandemirel\PrayerTimes\Services\PrayerTimesService;

class PrayerTimesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Config dosyasını merge et
        $this->mergeConfigFrom(
            __DIR__ . '/Config/prayer-times.php', 'prayer-times'
        );

        $this->app->singleton(AladhanApiService::class, function ($app) {
            return new AladhanApiService();
        });

        // PrayerTimesService'i singleton olarak kaydet
        $this->app->singleton('prayer-times', function ($app) {
            return new PrayerTimesService($app->make(AladhanApiService::class));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Config dosyasını publish et
        $this->publishes([
            __DIR__ . '/Config/prayer-times.php' => config_path('prayer-times.php'),
        ], 'prayer-times-config');
    }
} 