<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\Deal;
use App\Models\Invoice;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

/**
 * TrustFlowKpiWidget
 * ----------------------------------------------------------------------
 * Primary KPI band on the dashboard. Renders four stat cards:
 *   - Revenue MTD
 *   - Pipeline Value (open deals)
 *   - Win Rate (last 30 days)
 *   - Open Invoices
 *
 * Tenant semantics:
 *   Super Admin (tenant_id = null) → aggregates across all tenants.
 *   Regular user                   → scoped to own tenant_id.
 */
class TrustFlowKpiWidget extends BaseWidget
{
    protected static ?int $sort = 0;

    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        $tenantId = Auth::user()?->tenant_id;

        $revenueMtd = $this->revenueMtd($tenantId);
        $pipeline   = $this->pipelineValue($tenantId);
        $winRate    = $this->winRate($tenantId);
        $openInv    = $this->openInvoices($tenantId);

        return [
            Stat::make(__('filament.kpi.revenue_mtd'), '$' . number_format($revenueMtd, 0))
                ->description(__('filament.kpi.revenue_mtd_desc'))
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),

            Stat::make(__('filament.kpi.pipeline_value'), '$' . number_format($pipeline['value'], 0))
                ->description($pipeline['count'] . ' ' . __('filament.kpi.open_deals'))
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('primary'),

            Stat::make(__('filament.kpi.win_rate'), number_format($winRate, 1) . '%')
                ->description(__('filament.kpi.win_rate_desc'))
                ->descriptionIcon('heroicon-m-trophy')
                ->color($winRate >= 50 ? 'success' : ($winRate >= 25 ? 'warning' : 'danger')),

            Stat::make(__('filament.kpi.open_invoices'), (string) $openInv['count'])
                ->description('$' . number_format($openInv['amount'], 0) . ' ' . __('filament.kpi.outstanding'))
                ->descriptionIcon('heroicon-m-document-currency-dollar')
                ->color($openInv['overdue'] > 0 ? 'danger' : 'info'),
        ];
    }

    private function revenueMtd(?int $tenantId): float
    {
        $q = Invoice::where('status', 'paid')
            ->whereYear('paid_at', now()->year)
            ->whereMonth('paid_at', now()->month);

        if ($tenantId !== null) {
            $q->where('tenant_id', $tenantId);
        }

        return (float) $q->sum('total');
    }

    /**
     * @return array{value: float, count: int}
     */
    private function pipelineValue(?int $tenantId): array
    {
        $q = Deal::where('status', 'open');
        if ($tenantId !== null) {
            $q->where('tenant_id', $tenantId);
        }

        return [
            'value' => (float) (clone $q)->sum('value'),
            'count' => (int) (clone $q)->count(),
        ];
    }

    private function winRate(?int $tenantId): float
    {
        $base = Deal::whereIn('status', ['won', 'lost'])
            ->where('updated_at', '>=', now()->subDays(30));

        if ($tenantId !== null) {
            $base->where('tenant_id', $tenantId);
        }

        $total = (clone $base)->count();
        if ($total === 0) {
            return 0.0;
        }

        $won = (clone $base)->where('status', 'won')->count();

        return ($won / $total) * 100;
    }

    /**
     * @return array{count: int, amount: float, overdue: int}
     */
    private function openInvoices(?int $tenantId): array
    {
        $q = Invoice::whereIn('status', ['draft', 'sent', 'overdue']);
        if ($tenantId !== null) {
            $q->where('tenant_id', $tenantId);
        }

        return [
            'count'   => (int) (clone $q)->count(),
            'amount'  => (float) (clone $q)->sum('total'),
            'overdue' => (int) (clone $q)->where('status', 'overdue')->count(),
        ];
    }
}
