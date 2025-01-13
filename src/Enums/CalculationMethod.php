<?php

namespace Tugrandemirel\PrayerTimes\Enums;

enum CalculationMethod: int
{
    case MUSLIM_WORLD_LEAGUE = 1;
    case ISLAMIC_SOCIETY_NORTH_AMERICA = 2;
    case EGYPTIAN_AUTHORITY = 3;
    case UMM_AL_QURA = 4;
    case KARACHI = 5;

    public function label(): string
    {
        return match($this) {
            self::MUSLIM_WORLD_LEAGUE => 'Muslim World League',
            self::ISLAMIC_SOCIETY_NORTH_AMERICA => 'Islamic Society of North America',
            self::EGYPTIAN_AUTHORITY => 'Egyptian General Authority of Survey',
            self::UMM_AL_QURA => 'Umm Al-Qura University, Makkah',
            self::KARACHI => 'University of Islamic Sciences, Karachi',
        };
    }
} 