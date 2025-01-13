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
    */
    'calculation_method' => 4, // Umm Al-Qura

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
    | API Configuration
    |--------------------------------------------------------------------------
    */
    'api' => [
        'timeout' => 10,
        'retry_times' => 3,
        'retry_sleep' => 1000,
    ],

    /*
    |--------------------------------------------------------------------------
    | Language Settings
    |--------------------------------------------------------------------------
    */
    'language' => [
        'default' => 'tr',
        'available' => ['tr', 'en', 'ar'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Prayer Names Translations
    |--------------------------------------------------------------------------
    */
    'translations' => [
        'tr' => [
            'Fajr' => 'İmsak',
            'Sunrise' => 'Güneş',
            'Dhuhr' => 'Öğle',
            'Asr' => 'İkindi',
            'Maghrib' => 'Akşam',
            'Isha' => 'Yatsı',
            'days' => [
                'Monday' => 'Pazartesi',
                'Tuesday' => 'Salı',
                'Wednesday' => 'Çarşamba',
                'Thursday' => 'Perşembe',
                'Friday' => 'Cuma',
                'Saturday' => 'Cumartesi',
                'Sunday' => 'Pazar'
            ]
        ],
        'en' => [
            'Fajr' => 'Fajr',
            'Sunrise' => 'Sunrise',
            'Dhuhr' => 'Dhuhr',
            'Asr' => 'Asr',
            'Maghrib' => 'Maghrib',
            'Isha' => 'Isha',
            'days' => [
                'Monday' => 'Monday',
                'Tuesday' => 'Tuesday',
                'Wednesday' => 'Wednesday',
                'Thursday' => 'Thursday',
                'Friday' => 'Friday',
                'Saturday' => 'Saturday',
                'Sunday' => 'Sunday'
            ]
        ],
        'ar' => [
            'Fajr' => 'الفجر',
            'Sunrise' => 'الشروق',
            'Dhuhr' => 'الظهر',
            'Asr' => 'العصر',
            'Maghrib' => 'المغرب',
            'Isha' => 'العشاء',
            'days' => [
                'Monday' => 'الاثنين',
                'Tuesday' => 'الثلاثاء',
                'Wednesday' => 'الأربعاء',
                'Thursday' => 'الخميس',
                'Friday' => 'الجمعة',
                'Saturday' => 'السبت',
                'Sunday' => 'الأحد'
            ]
        ]
    ]
];
