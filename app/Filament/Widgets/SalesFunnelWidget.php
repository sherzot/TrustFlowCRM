<?php

namespace App\Filament\Widgets;

use App\Models\Deal;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;
use App\Helpers\PermissionHelper;

class SalesFunnelWidget extends ChartWidget
{
    protected static ?string $heading = 'Sales Funnel';

    protected static ?int $sort = 1;

    public static function shouldBeVisibleInDashboards(): bool
    {
        // Super Admin, Admin, Manager, and Sales can see this widget
        return PermissionHelper::hasAnyRole(['super_admin', 'admin', 'manager', 'sales']);
    }

    protected function getData(): array
    {
        $tenantId = Auth::user()->tenant_id;

        $stages = ['new', 'qualified', 'discovery', 'proposal', 'negotiation', 'won'];
        $labels = ['New', 'Qualified', 'Discovery', 'Proposal', 'Negotiation', 'Won'];
        
        $data = [];
        foreach ($stages as $stage) {
            $query = Deal::where('stage', $stage);
            if ($tenantId !== null) {
                $query->where('tenant_id', $tenantId);
            }
            $data[] = $query->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Deals',
                    'data' => $data,
                    'backgroundColor' => [
                        'rgba(59, 130, 246, 0.5)',
                        'rgba(16, 185, 129, 0.5)',
                        'rgba(251, 191, 36, 0.5)',
                        'rgba(239, 68, 68, 0.5)',
                        'rgba(139, 92, 246, 0.5)',
                        'rgba(34, 197, 94, 0.5)',
                    ],
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}

