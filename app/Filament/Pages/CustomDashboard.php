<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class CustomDashboard extends BaseDashboard
{
    public static function getNavigationLabel(): string
    {
        return __('filament.dashboard');
    }
}

