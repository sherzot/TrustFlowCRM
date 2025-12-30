<?php

namespace App\Domains\Analytics;

use App\Models\Deal;
use App\Models\Project;
use App\Models\Invoice;
use App\Models\Lead;
use Illuminate\Support\Facades\DB;

class AnalyticsService
{
    /**
     * Sales funnel statistikasi
     */
    public function getSalesFunnel(int $tenantId): array
    {
        $stages = [
            'new' => 'New Lead',
            'qualified' => 'Qualified',
            'discovery' => 'Discovery & Proposal',
            'proposal' => 'Proposal',
            'negotiation' => 'Negotiation',
            'won' => 'Won',
            'lost' => 'Lost',
        ];

        $funnel = [];
        foreach ($stages as $key => $label) {
            $count = Deal::where('tenant_id', $tenantId)
                ->where('stage', $key)
                ->count();
            
            $value = Deal::where('tenant_id', $tenantId)
                ->where('stage', $key)
                ->sum('value');

            $funnel[] = [
                'stage' => $key,
                'label' => $label,
                'count' => $count,
                'value' => $value,
            ];
        }

        return $funnel;
    }

    /**
     * Profit chart ma'lumotlari
     */
    public function getProfitChart(int $tenantId, int $months = 12): array
    {
        $data = [];
        
        for ($i = $months - 1; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            
            $revenue = Invoice::where('tenant_id', $tenantId)
                ->where('status', 'paid')
                ->whereYear('paid_at', $date->year)
                ->whereMonth('paid_at', $date->month)
                ->sum('total');

            $costs = Project::where('tenant_id', $tenantId)
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('actual_cost');

            $data[] = [
                'month' => $date->format('M Y'),
                'revenue' => $revenue,
                'costs' => $costs,
                'profit' => $revenue - $costs,
            ];
        }

        return $data;
    }

    /**
     * AI insights
     * @param int|null $tenantId If null, returns data for all tenants (Super Admin)
     */
    public function getAIInsights(?int $tenantId): array
    {
        $highScoreLeadsQuery = Lead::where('ai_score', '>', 70);
        $highScoreDealsQuery = Deal::where('ai_score', '>', 70)->where('status', 'open');
        $avgDealValueQuery = Deal::where('status', 'won');
        $totalLeadsQuery = Lead::query();
        $convertedLeadsQuery = Lead::whereNotNull('converted_at');

        if ($tenantId !== null) {
            $highScoreLeadsQuery->where('tenant_id', $tenantId);
            $highScoreDealsQuery->where('tenant_id', $tenantId);
            $avgDealValueQuery->where('tenant_id', $tenantId);
            $totalLeadsQuery->where('tenant_id', $tenantId);
            $convertedLeadsQuery->where('tenant_id', $tenantId);
        }

        $highScoreLeads = $highScoreLeadsQuery->count();
        $highScoreDeals = $highScoreDealsQuery->count();
        $avgDealValue = $avgDealValueQuery->avg('value');

        return [
            'high_score_leads' => $highScoreLeads,
            'high_score_deals' => $highScoreDeals,
            'average_deal_value' => round($avgDealValue ?? 0, 2),
            'conversion_rate' => $this->calculateConversionRate($tenantId),
        ];
    }

    protected function calculateConversionRate(?int $tenantId): float
    {
        $totalLeadsQuery = Lead::query();
        $convertedLeadsQuery = Lead::whereNotNull('converted_at');

        if ($tenantId !== null) {
            $totalLeadsQuery->where('tenant_id', $tenantId);
            $convertedLeadsQuery->where('tenant_id', $tenantId);
        }

        $totalLeads = $totalLeadsQuery->count();
        $convertedLeads = $convertedLeadsQuery->count();

        return $totalLeads > 0 ? ($convertedLeads / $totalLeads) * 100 : 0;
    }
}

