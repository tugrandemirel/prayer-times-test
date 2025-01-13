<?php

namespace App\Http\Controllers;

use Tugrandemirel\PrayerTimes\Facades\PrayerTimes;

class PrayerTimesController extends Controller
{
    public function index()
    {
        $data = [
            'daily' => PrayerTimes::getDailyPrayerTimes(),
            'monthly' => PrayerTimes::getMonthlyPrayerTimes(date('m'), date('Y')),
            'qibla' => PrayerTimes::getQiblaDirection(),
            'isSpecialDay' => PrayerTimes::isSpecialDay()
        ];

        return view('prayer-times', $data);
    }
} 