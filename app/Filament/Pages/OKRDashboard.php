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
        $dealsWon = Deal::where('tenant_id', $tenantId)
            ->where('status', 'won')
            ->whereMonth('won_at', $currentMonth)
            ->whereYear('won_at', $currentYear)
            ->count();

        $dealsValue = Deal::where('tenant_id', $tenantId)
            ->where('status', 'won')
            ->whereMonth('won_at', $currentMonth)
            ->whereYear('won_at', $currentYear)
            ->sum('value');

        // Revenue Objectives
        $revenue = Invoice::where('tenant_id', $tenantId)
            ->where('status', 'paid')
            ->whereMonth('paid_at', $currentMonth)
            ->whereYear('paid_at', $currentYear)
            ->sum('total');

        // Project Completion
        $projectsCompleted = Project::where('tenant_id', $tenantId)
            ->where('status', 'completed')
            ->whereMonth('updated_at', $currentMonth)
            ->whereYear('updated_at', $currentYear)
            ->count();

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

