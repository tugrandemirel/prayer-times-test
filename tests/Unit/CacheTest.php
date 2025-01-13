<?php

namespace Tugrandemirel\PrayerTimes\Tests\Unit;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tugrandemirel\PrayerTimes\Facades\PrayerTimes;
use Tugrandemirel\PrayerTimes\Tests\TestCase;

class CacheTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
    }

    /** @test */
    public function it_caches_daily_prayer_times()
    {
        $date = '2024-05-01';
        
        // İlk istek
        $times1 = PrayerTimes::getDailyPrayerTimes($date);
        
        // API'yi değiştir
        Http::fake([
            'api.aladhan.com/v1/*' => Http::response([
                'data' => [
                    'timings' => [
                        'Fajr' => '05:30', // Farklı saat
                    ]
                ]
            ], 200),
        ]);
        
        // İkinci istek (cache'den gelmeli)
        $times2 = PrayerTimes::getDailyPrayerTimes($date);
        
        $this->assertEquals($times1, $times2);
    }

    /** @test */
    public function it_respects_cache_ttl()
    {
        $date = '2024-05-01';
        
        // İlk istek
        $times1 = PrayerTimes::getDailyPrayerTimes($date);
        
        // Cache'i temizle
        Cache::flush();
        
        // API'yi değiştir
        Http::fake([
            'api.aladhan.com/v1/*' => Http::response([
                'data' => [
                    'timings' => [
                        'Fajr' => '05:30', // Farklı saat
                    ]
                ]
            ], 200),
        ]);
        
        // Yeni istek (yeni API response'u gelmeli)
        $times2 = PrayerTimes::getDailyPrayerTimes($date);
        
        $this->assertNotEquals($times1, $times2);
    }
} 