<?php

namespace App\Filament\Pages;

use App\Models\Deal;
use App\Models\Project;
use App\Models\Invoice;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class OKRDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static string $view = 'filament.pages.okr-dashboard';

    protected static ?string $navigationLabel = 'OKR Dashboard';

    protected static ?string $navigationGroup = 'Analytics';

    public function getObjectives(): array
    {
        $tenantId = Auth::user()->tenant_id;
        
        $currentMonth = now()->month;
        $currentYear = now()->year;

        // Sales Objectives
        $dealsWonQuery = Deal::where('status', 'won')
            ->whereMonth('won_at', $currentMonth)
            ->whereYear('won_at', $currentYear);
        if ($tenantId !== null) {
            $dealsWonQuery->where('tenant_id', $tenantId);
        }
        $dealsWon = $dealsWonQuery->count();

        $dealsValueQuery = Deal::where('status', 'won')
            ->whereMonth('won_at', $currentMonth)
            ->whereYear('won_at', $currentYear);
        if ($tenantId !== null) {
            $dealsValueQuery->where('tenant_id', $tenantId);
        }
        $dealsValue = $dealsValueQuery->sum('value');

        // Revenue Objectives
        $revenueQuery = Invoice::where('status', 'paid')
            ->whereMonth('paid_at', $currentMonth)
            ->whereYear('paid_at', $currentYear);
        if ($tenantId !== null) {
            $revenueQuery->where('tenant_id', $tenantId);
        }
        $revenue = $revenueQuery->sum('total');

        // Project Completion
        $projectsQuery = Project::where('status', 'completed')
            ->whereMonth('updated_at', $currentMonth)
            ->whereYear('updated_at', $currentYear);
        if ($tenantId !== null) {
            $projectsQuery->where('tenant_id', $tenantId);
        }
        $projectsCompleted = $projectsQuery->count();

        return [
            'deals_won' => [
                'current' => $dealsWon,
                'target' => 20,
                'percentage' => min(100, ($dealsWon / 20) * 100),
            ],
            'deals_value' => [
                'current' => $dealsValue,
                'target' => 500000,
                'percentage' => min(100, ($dealsValue / 500000) * 100),
            ],
            'revenue' => [
                'current' => $revenue,
                'target' => 1000000,
                'percentage' => min(100, ($revenue / 1000000) * 100),
            ],
            'projects_completed' => [
                'current' => $projectsCompleted,
                'target' => 15,
                'percentage' => min(100, ($projectsCompleted / 15) * 100),
            ],
        ];
    }
}

