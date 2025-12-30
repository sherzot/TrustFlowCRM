<?php

namespace App\Filament\Pages;

use App\Models\Deal;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use App\Helpers\PermissionHelper;

class KanbanBoard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-view-columns';

    protected static string $view = 'filament.pages.kanban-board';

    protected static ?string $navigationLabel = 'Kanban Board';

    protected static ?string $navigationGroup = 'Sales';

    protected static ?int $navigationSort = 2;

    public static function getNavigationLabel(): string
    {
        return __('filament.kanban_board');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('filament.sales');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return PermissionHelper::can('view deals');
    }

    public function getDealsByStage(): array
    {
        $tenantId = Auth::user()->tenant_id;
        
        $stages = [
            'new' => __('filament.new'),
            'qualified' => __('filament.qualified'),
            'discovery' => __('filament.discovery'),
            'proposal' => __('filament.proposal'),
            'negotiation' => __('filament.negotiation'),
            'won' => __('filament.won'),
        ];

        $dealsByStage = [];
        foreach ($stages as $key => $label) {
            $dealsQuery = Deal::where('stage', $key)
                ->where('status', 'open'); // Faqat ochiq Deal'lar
            if ($tenantId !== null) {
                $dealsQuery->where('tenant_id', $tenantId);
            } else {
                // Super Admin uchun barcha tenant'lardan Deal'lar
                // Lekin faqat ochiq Deal'lar
            }
            $dealsByStage[$key] = [
                'label' => $label,
                'deals' => $dealsQuery->with(['account', 'contact', 'tenant']) // Eager load relationships
                    ->orderBy('created_at', 'desc')
                    ->get()
                    ->toArray(),
            ];
        }

        return $dealsByStage;
    }
}

