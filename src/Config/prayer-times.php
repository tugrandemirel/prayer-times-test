<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Location Settings
    |--------------------------------------------------------------------------
    */
    'default_location' => [
        'city' => 'Yozgat',
        'country' => 'Turkey',
        'latitude' => 39.8181, // Yozgat'ın koordinatları
        'longitude' => 34.8147,
    ],

    /*
    |--------------------------------------------------------------------------
    | Calculation Method
    |--------------------------------------------------------------------------
    | Available methods:
    | 1 - Muslim World League
    | 2 - Islamic Society of North America
    | 3 - Egyptian General Authority of Survey
    | 4 - Umm Al-Qura University, Makkah
    | 5 - University of Islamic Sciences, Karachi
    */
    'calculation_method' => 4,

    /*
    |--------------------------------------------------------------------------
    | Cache Configuration
    |--------------------------------------------------------------------------
    */
    'cache' => [
        'enabled' => true,
        'driver' => env('PRAYER_TIMES_CACHE_DRIVER', 'file'),
        'ttl' => 60 * 24, // 24 saat
    ],

    /*
    |--------------------------------------------------------------------------
    | Special Days
    |--------------------------------------------------------------------------
    */
    'special_days' => [
        'ramazan_bayrami' => [
            'name' => 'Ramazan Bayramı',
            'date' => '2024-04-10', // Örnek tarih
            'duration' => 3
        ],
        'kurban_bayrami' => [
            'name' => 'Kurban Bayramı',
            'date' => '2024-06-16', // Örnek tarih
            'duration' => 4
        ],
        // Diğer özel günler...
    ],

    /*
    |--------------------------------------------------------------------------
    | API Configuration
    |--------------------------------------------------------------------------
    */
    'api' => [
        'timeout' => 10,
        'retry_times' => 3,
        'retry_sleep' => 1000,
    ],
]; 