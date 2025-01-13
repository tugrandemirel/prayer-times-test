<?php

namespace Tugrandemirel\PrayerTimes\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Tugrandemirel\PrayerTimes\PrayerTimesServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            PrayerTimesServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        // Test için config ayarları
        $app['config']->set('prayer-times.default_location', [
            'city' => 'Yozgat',
            'country' => 'Turkey',
            'latitude' => 39.8181,
            'longitude' => 34.8147,
        ]);
    }
} 