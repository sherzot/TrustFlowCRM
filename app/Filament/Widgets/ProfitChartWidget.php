<?php

namespace App\Filament\Widgets;

use App\Models\Invoice;
use App\Models\Project;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;

class ProfitChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Profit Chart';

    protected static ?int $sort = 2;

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

            $monthRevenue = Invoice::where('tenant_id', $tenantId)
                ->where('status', 'paid')
                ->whereYear('paid_at', $date->year)
                ->whereMonth('paid_at', $date->month)
                ->sum('total');

            $monthCosts = Project::where('tenant_id', $tenantId)
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('actual_cost');

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

