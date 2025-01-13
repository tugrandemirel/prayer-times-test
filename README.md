# Laravel Prayer Times Package

Islamic Prayer Times package for Laravel applications using Aladhan API.

## Installation

You can install the package via composer:
bash
composer require tugrandemirel/prayer-times
## Configuration

Publish the config file:
bash
php artisan vendor:publish --tag=prayer-times-config
## Usage
php
use Tugrandemirel\PrayerTimes\Facades\PrayerTimes;
// Get daily prayer times
$times = PrayerTimes::getDailyPrayerTimes();
// Get monthly prayer times
$calendar = PrayerTimes::getMonthlyPrayerTimes(5, 2024);
// Get first five days of current month
$firstFive = PrayerTimes::getFirstFiveDays();
// Get prayer times with different language
$times = PrayerTimes::setLanguage('ar')->getDailyPrayerTimes();
// Get prayer times for date range
$times = PrayerTimes::getPrayerTimesByDateRange('2024-01-01', '2024-01-07');
// Get next 7 days
$nextWeek = PrayerTimes::getNextDaysPrayerTimes(7);
// Get previous 7 days
$lastWeek = PrayerTimes::getPreviousDaysPrayerTimes(7);

## Available Languages

- Turkish (tr)
- English (en)
- Arabic (ar)

## Testing
bash
composer test
## License

The MIT License (MIT).
