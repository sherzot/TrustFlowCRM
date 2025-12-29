<?php

namespace App\Filament\Widgets;

use App\Models\Invoice;
use App\Models\Project;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;
use App\Helpers\PermissionHelper;

class ProfitChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Profit Chart';

    protected static ?int $sort = 2;

    public static function shouldBeVisibleInDashboards(): bool
    {
        // Super Admin, Admin, Manager, and Finance can see this widget
        return PermissionHelper::hasAnyRole(['super_admin', 'admin', 'manager', 'finance']);
    }

    protected function getData(): array
    {
        $tenantId = Auth::user()->tenant_id;

        $months = [];
        $revenue = [];
        $costs = [];
        $profit = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M');

            $revenueQuery = Invoice::where('status', 'paid')
                ->whereYear('paid_at', $date->year)
                ->whereMonth('paid_at', $date->month);
            if ($tenantId !== null) {
                $revenueQuery->where('tenant_id', $tenantId);
            }
            $monthRevenue = $revenueQuery->sum('total');

            $costsQuery = Project::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month);
            if ($tenantId !== null) {
                $costsQuery->where('tenant_id', $tenantId);
            }
            $monthCosts = $costsQuery->sum('actual_cost');

            $revenue[] = $monthRevenue;
            $costs[] = $monthCosts;
            $profit[] = $monthRevenue - $monthCosts;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Revenue',
                    'data' => $revenue,
                    'backgroundColor' => 'rgba(34, 197, 94, 0.5)',
                ],
                [
                    'label' => 'Costs',
                    'data' => $costs,
                    'backgroundColor' => 'rgba(239, 68, 68, 0.5)',
                ],
                [
                    'label' => 'Profit',
                    'data' => $profit,
                    'backgroundColor' => 'rgba(59, 130, 246, 0.5)',
                ],
            ],
            'labels' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}

