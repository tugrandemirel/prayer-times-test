<?php

namespace Tugrandemirel\PrayerTimes\Tests\Unit;

use Illuminate\Support\Facades\Http;
use Tugrandemirel\PrayerTimes\Exceptions\ApiException;
use Tugrandemirel\PrayerTimes\Services\AladhanApiService;
use Tugrandemirel\PrayerTimes\Tests\TestCase;

class AladhanApiServiceTest extends TestCase
{
    protected AladhanApiService $apiService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->apiService = new AladhanApiService();
    }

    /** @test */
    public function it_handles_api_errors_correctly()
    {
        Http::fake([
            'api.aladhan.com/v1/*' => Http::response(null, 500),
        ]);

        $this->expectException(ApiException::class);
        
        $this->apiService->getDailyPrayerTimes('2024-05-01');
    }

    /** @test */
    public function it_handles_timeout_correctly()
    {
        Http::fake([
            'api.aladhan.com/v1/*' => function() {
                throw new \Illuminate\Http\Client\ConnectionException();
            },
        ]);

        $this->expectException(ApiException::class);
        
        $this->apiService->getDailyPrayerTimes('2024-05-01');
    }

    /** @test */
    public function it_returns_correct_data_structure()
    {
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
        ]);

        $times = $this->apiService->getDailyPrayerTimes('2024-05-01');

        $this->assertIsArray($times);
        $this->assertArrayHasKey('Fajr', $times);
        $this->assertMatchesRegularExpression('/^\d{2}:\d{2}$/', $times['Fajr']);
    }
} 