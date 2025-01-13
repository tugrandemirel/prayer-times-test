<?php

namespace Tugrandemirel\PrayerTimes\Tests\Unit;

use Illuminate\Support\Facades\Http;
use Tugrandemirel\PrayerTimes\Facades\PrayerTimes;
use Tugrandemirel\PrayerTimes\Tests\TestCase;

class PrayerTimesTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        
        // Her test öncesi fake HTTP responses hazırla
        Http::fake([
            'api.aladhan.com/v1/timingsByCity*' => Http::response([
                'data' => [
                    'timings' => [
                        'Fajr' => '04:30',
                        'Sunrise' => '06:15',
                        'Dhuhr' => '13:00',
                        'Asr' => '16:30',
                        'Maghrib' => '19:45',
                        'Isha' => '21:15'
                    ]
                ]
            ], 200),
            
            'api.aladhan.com/v1/calendar*' => Http::response([
                'data' => [
                    [
                        'date' => ['readable' => '01 May 2024'],
                        'timings' => [
                            'Fajr' => '04:30',
                            'Sunrise' => '06:15',
                            'Dhuhr' => '13:00',
                            'Asr' => '16:30',
                            'Maghrib' => '19:45',
                            'Isha' => '21:15'
                        ]
                    ]
                ]
            ], 200),
            
            'api.aladhan.com/v1/qibla*' => Http::response([
                'data' => [
                    'direction' => 145.57
                ]
            ], 200),
        ]);
    }

    /** @test */
    public function it_can_get_daily_prayer_times()
    {
        $times = PrayerTimes::getDailyPrayerTimes('2024-05-01');

        $this->assertIsArray($times);
        $this->assertArrayHasKey('Fajr', $times);
        $this->assertArrayHasKey('Dhuhr', $times);
        $this->assertArrayHasKey('Asr', $times);
        $this->assertArrayHasKey('Maghrib', $times);
        $this->assertArrayHasKey('Isha', $times);
    }

    /** @test */
    public function it_can_get_monthly_prayer_times()
    {
        $times = PrayerTimes::getMonthlyPrayerTimes(5, 2024);

        $this->assertIsArray($times);
        $this->assertNotEmpty($times);
    }

    /** @test */
    public function it_can_get_qibla_direction()
    {
        $direction = PrayerTimes::getQiblaDirection();

        $this->assertIsFloat($direction);
        $this->assertEquals(145.57, $direction);
    }

    /** @test */
    public function it_can_check_special_days()
    {
        // Config'den özel günleri al
        $specialDays = config('prayer-times.special_days');
        
        // Bugün özel gün olup olmadığını kontrol et
        $isSpecialDay = PrayerTimes::isSpecialDay();
        
        $this->assertIsBool($isSpecialDay);
    }
} 