<?php

namespace Tugrandemirel\PrayerTimes\Facades;

use Illuminate\Support\Facades\Facade;

class PrayerTimes extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'prayer-times';
    }
} 