<?php

namespace App\Filament\Pages;

use App\Models\Deal;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class KanbanBoard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-view-columns';

    protected static string $view = 'filament.pages.kanban-board';

    protected static ?string $navigationLabel = 'Kanban Board';

    protected static ?string $navigationGroup = 'Sales';

    protected static ?int $navigationSort = 2;

    public function getDealsByStage(): array
    {
        $tenantId = Auth::user()->tenant_id;
        
        $stages = [
            'new' => 'New',
            'qualified' => 'Qualified',
            'discovery' => 'Discovery',
            'proposal' => 'Proposal',
            'negotiation' => 'Negotiation',
            'won' => 'Won',
        ];

        $dealsByStage = [];
        foreach ($stages as $key => $label) {
            $dealsQuery = Deal::where('stage', $key)
                ->where('status', 'open');
            if ($tenantId !== null) {
                $dealsQuery->where('tenant_id', $tenantId);
            }
            $dealsByStage[$key] = [
                'label' => $label,
                'deals' => $dealsQuery->with(['account', 'contact'])
                    ->orderBy('created_at', 'desc')
                    ->get()
                    ->toArray(),
            ];
        }

        return $dealsByStage;
    }
}

