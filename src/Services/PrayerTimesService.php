<?php

namespace Tugrandemirel\PrayerTimes\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class PrayerTimesService
{
    protected array $config;
    protected string $cachePrefix = 'prayer_times_';
    protected AladhanApiService $apiService;
    protected string $currentLanguage;

    public function __construct(AladhanApiService $apiService)
    {
        $this->config = config('prayer-times');
        $this->apiService = $apiService;
        $this->currentLanguage = $this->config['language']['default'];
    }

    public function setLanguage(string $language): self
    {
        if (!in_array($language, $this->config['language']['available'])) {
            throw new \InvalidArgumentException("Language {$language} is not supported.");
        }

        $this->currentLanguage = $language;
        return $this;
    }

    public function getLanguage(): string
    {
        return $this->currentLanguage;
    }

    protected function translatePrayerName(string $name): string
    {
        return $this->config['translations'][$this->currentLanguage][$name] ?? $name;
    }

    protected function translateDayName(string $dayName): string
    {
        return $this->config['translations'][$this->currentLanguage]['days'][$dayName] ?? $dayName;
    }

    public function getDailyPrayerTimes(?string $date = null): array
    {
        $date = $date ?? now()->format('Y-m-d');
        $cacheKey = $this->cachePrefix . 'daily_' . $date . '_' . $this->currentLanguage;

        return Cache::remember($cacheKey, $this->getCacheDuration(), function () use ($date) {
            $times = $this->apiService->getDailyPrayerTimes($date);
            return collect($times)->mapWithKeys(function ($time, $name) {
                return [$this->translatePrayerName($name) => $time];
            })->toArray();
        });
    }

    public function getMonthlyPrayerTimes(int $month, int $year): array
    {
        $cacheKey = $this->cachePrefix . "monthly_{$year}_{$month}_{$this->currentLanguage}";

        return Cache::remember($cacheKey, $this->getCacheDuration(), function () use ($month, $year) {
            $data = $this->apiService->getMonthlyPrayerTimes($month, $year);
            return collect($data)->map(function ($day) {
                $times = collect($day['timings'])->mapWithKeys(function ($time, $name) {
                    return [$this->translatePrayerName($name) => $time];
                })->toArray();

                return array_merge($day, ['timings' => $times]);
            })->toArray();
        });
    }

    public function getFirstFiveDays(): array
    {
        $startDate = now()->startOfMonth();
        $endDate = now()->startOfMonth()->addDays(4);
        $cacheKey = $this->cachePrefix . "first_five_" . $startDate->format('Y-m') . "_" . $this->currentLanguage;

        return Cache::remember($cacheKey, $this->getCacheDuration(), function () use ($startDate, $endDate) {
            $dates = [];
            $currentDate = $startDate->copy();

            while ($currentDate->lte($endDate)) {
                $times = $this->getDailyPrayerTimes($currentDate->format('Y-m-d'));
                $dates[$currentDate->format('Y-m-d')] = [
                    'date' => $currentDate->format('d.m.Y'),
                    'day_name' => $this->translateDayName($currentDate->format('l')),
                    'times' => $times
                ];
                $currentDate->addDay();
            }

            return $dates;
        });
    }

    public function getPrayerTimesByDateRange(?string $startDate = null, ?string $endDate = null): array
    {
        $startDate = $startDate ? Carbon::parse($startDate) : now();
        $endDate = $endDate ? Carbon::parse($endDate) : $startDate;

        $cacheKey = $this->cachePrefix . "range_{$startDate->format('Y-m-d')}_{$endDate->format('Y-m-d')}_{$this->currentLanguage}";

        return Cache::remember($cacheKey, $this->getCacheDuration(), function () use ($startDate, $endDate) {
            $dates = [];
            $currentDate = $startDate->copy();

            while ($currentDate->lte($endDate)) {
                $dates[$currentDate->format('Y-m-d')] = [
                    'date' => $currentDate->format('d.m.Y'),
                    'day_name' => $this->translateDayName($currentDate->format('l')),
                    'times' => $this->getDailyPrayerTimes($currentDate->format('Y-m-d'))
                ];
                $currentDate->addDay();
            }

            return $dates;
        });
    }

    public function getNextDaysPrayerTimes(int $days = 7): array
    {
        $startDate = now();
        $endDate = now()->addDays($days - 1);
        return $this->getPrayerTimesByDateRange($startDate, $endDate);
    }

    public function getPreviousDaysPrayerTimes(int $days = 7): array
    {
        $startDate = now()->subDays($days - 1);
        $endDate = now();
        return $this->getPrayerTimesByDateRange($startDate, $endDate);
    }

    protected function getCacheDuration(): int
    {
        return $this->config['cache']['ttl'] ?? 1440;
    }
}
