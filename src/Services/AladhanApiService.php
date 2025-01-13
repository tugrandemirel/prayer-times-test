<?php

namespace Tugrandemirel\PrayerTimes\Services;

use Illuminate\Support\Facades\Http;
use Tugrandemirel\PrayerTimes\Exceptions\ApiException;

class AladhanApiService
{
    protected const BASE_URL = 'http://api.aladhan.com/v1';
    protected array $config;

    public function __construct()
    {
        $this->config = config('prayer-times');
    }

    public function getDailyPrayerTimes(string $date): array
    {
        try {
            $response = Http::timeout($this->config['api']['timeout'])
                ->get(self::BASE_URL . '/timings/' . $date, [
                    'latitude' => $this->config['default_location']['latitude'],
                    'longitude' => $this->config['default_location']['longitude'],
                    'method' => $this->config['calculation_method']
                ]);

            if ($response->failed()) {
                throw new ApiException('API request failed: ' . $response->body());
            }

            return $response->json()['data']['timings'];
        } catch (\Exception $e) {
            throw new ApiException('API error: ' . $e->getMessage());
        }
    }

    public function getMonthlyPrayerTimes(int $month, int $year): array
    {
        try {
            $response = Http::timeout($this->config['api']['timeout'])
                ->get(self::BASE_URL . '/calendar/' . $year . '/' . $month, [
                    'latitude' => $this->config['default_location']['latitude'],
                    'longitude' => $this->config['default_location']['longitude'],
                    'method' => $this->config['calculation_method']
                ]);

            if ($response->failed()) {
                throw new ApiException('API request failed: ' . $response->body());
            }

            return $response->json()['data'];
        } catch (\Exception $e) {
            throw new ApiException('API error: ' . $e->getMessage());
        }
    }

    public function getQiblaDirection(): float
    {
        try {
            $response = Http::timeout($this->config['api']['timeout'])
                ->get(self::BASE_URL . '/qibla/' . 
                    $this->config['default_location']['latitude'] . '/' . 
                    $this->config['default_location']['longitude']
                );

            if ($response->failed()) {
                throw new ApiException('API request failed: ' . $response->body());
            }

            return (float) $response->json()['data']['direction'];
        } catch (\Exception $e) {
            throw new ApiException('API error: ' . $e->getMessage());
        }
    }
}
