<?php

namespace Tugrandemirel\PrayerTimes\Services;

use Illuminate\Support\Facades\Cache;
use Tugrandemirel\PrayerTimes\Exceptions\PrayerTimesException;

class PrayerTimesService
{
    protected array $config;
    protected string $cachePrefix = 'prayer_times_';
    protected AladhanApiService $apiService;

    public function __construct(AladhanApiService $apiService)
    {
        $this->config = config('prayer-times');
        $this->apiService = $apiService;
    }

    /**
     * Get daily prayer times for default location
     */
    public function getDailyPrayerTimes(?string $date = null): array
    {
        $date = $date ?? now()->format('Y-m-d');
        $cacheKey = $this->cachePrefix . 'daily_' . $date;

        return Cache::remember($cacheKey, $this->getCacheDuration(), function () use ($date) {
            return $this->apiService->getDailyPrayerTimes($date);
        });
    }

    /**
     * Get monthly prayer times
     */
    public function getMonthlyPrayerTimes(int $month, int $year): array
    {
        $cacheKey = $this->cachePrefix . "monthly_{$year}_{$month}";

        return Cache::remember($cacheKey, $this->getCacheDuration(), function () use ($month, $year) {
            return $this->apiService->getMonthlyPrayerTimes($month, $year);
        });
    }

    /**
     * Get qibla direction
     */
    public function getQiblaDirection(): float
    {
        $cacheKey = $this->cachePrefix . 'qibla_direction';

        return Cache::remember($cacheKey, $this->getCacheDuration(), function () {
            return $this->apiService->getQiblaDirection();
        });
    }

    /**
     * Get special days
     */
    public function getSpecialDays(): array
    {
        return $this->config['special_days'];
    }

    /**
     * Check if today is a special day
     */
    public function isSpecialDay(): bool
    {
        $today = now()->format('Y-m-d');
        
        foreach ($this->getSpecialDays() as $day) {
            $startDate = \Carbon\Carbon::parse($day['date']);
            $endDate = $startDate->copy()->addDays($day['duration'] - 1);
            
            if (now()->between($startDate, $endDate)) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Get cache duration from config
     */
    protected function getCacheDuration(): int
    {
        return $this->config['cache']['ttl'] ?? 1440; // Default 24 saat
    }
} 