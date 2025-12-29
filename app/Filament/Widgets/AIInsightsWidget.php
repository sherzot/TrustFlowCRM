<?php

namespace App\Filament\Widgets;

use App\Models\Lead;
use App\Models\Deal;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;
use App\Domains\Analytics\AnalyticsService;
use App\Helpers\PermissionHelper;

class AIInsightsWidget extends BaseWidget
{
    protected static ?int $sort = 3;

    public static function shouldBeVisibleInDashboards(): bool
    {
        // Super Admin, Admin, Manager, and Sales can see this widget
        return PermissionHelper::hasAnyRole(['super_admin', 'admin', 'manager', 'sales']);
    }

    protected function getStats(): array
    {
        $tenantId = Auth::user()->tenant_id;
        
        // Super Admin uchun bo'sh ma'lumot qaytarish
        if ($tenantId === null) {
            return [
                Stat::make('High Score Leads', 0)
                    ->description('AI score > 70')
                    ->descriptionIcon('heroicon-m-arrow-trending-up')
                    ->color('success'),
                Stat::make('High Score Deals', 0)
                    ->description('AI score > 70')
                    ->descriptionIcon('heroicon-m-arrow-trending-up')
                    ->color('success'),
                Stat::make('Avg Deal Value', '$0.00')
                    ->description('Won deals average')
                    ->descriptionIcon('heroicon-m-currency-dollar')
                    ->color('info'),
                Stat::make('Conversion Rate', '0.0%')
                    ->description('Lead to Account')
                    ->descriptionIcon('heroicon-m-arrow-trending-up')
                    ->color('warning'),
            ];
        }

        $analyticsService = app(AnalyticsService::class);
        $insights = $analyticsService->getAIInsights($tenantId);

        return [
            Stat::make('High Score Leads', $insights['high_score_leads'])
                ->description('AI score > 70')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('High Score Deals', $insights['high_score_deals'])
                ->description('AI score > 70')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Avg Deal Value', '$' . number_format($insights['average_deal_value'], 2))
                ->description('Won deals average')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('info'),
            Stat::make('Conversion Rate', number_format($insights['conversion_rate'], 1) . '%')
                ->description('Lead to Account')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('warning'),
        ];
    }
}

