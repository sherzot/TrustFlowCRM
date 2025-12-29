<?php

namespace App\Helpers;

use Illuminate\Support\Facades\App;
use Carbon\Carbon;

class DateHelper
{
    /**
     * Get date format based on current locale
     * Japanese: 2025年12月29日
     * English/Russian: 2025.12.29
     */
    public static function getDateFormat(): string
    {
        $locale = App::getLocale();
        
        if ($locale === 'ja') {
            return 'Y年m月d日';
        }
        
        return 'Y.m.d';
    }

    /**
     * Format date according to locale
     */
    public static function formatDate($date): ?string
    {
        if (!$date) {
            return null;
        }

        if (is_string($date)) {
            $date = Carbon::parse($date);
        }

        $locale = App::getLocale();
        
        if ($locale === 'ja') {
            return $date->format('Y年m月d日');
        }
        
        return $date->format('Y.m.d');
    }

    /**
     * Get date format for Filament DatePicker display
     */
    public static function getDatePickerDisplayFormat(): string
    {
        $locale = App::getLocale();
        
        if ($locale === 'ja') {
            return 'Y年m月d日';
        }
        
        return 'Y.m.d';
    }

    /**
     * Get date format for Filament DatePicker native format
     */
    public static function getDatePickerFormat(): string
    {
        return 'Y-m-d'; // Always use ISO format for storage
    }
}

