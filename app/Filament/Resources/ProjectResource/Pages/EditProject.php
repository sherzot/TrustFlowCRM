<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\ProjectResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
use App\Helpers\PermissionHelper;

class EditProject extends EditRecord
{
    protected static string $resource = ProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('view_pdf')
                ->label(__('filament.view_pdf'))
                ->icon('heroicon-o-document-text')
                ->url(fn () => route('projects.pdf.view', $this->record))
                ->openUrlInNewTab()
                ->visible(fn (): bool => PermissionHelper::hasAnyRole(['super_admin', 'admin', 'manager', 'sales'])),
            Actions\Action::make('download_pdf')
                ->label(__('filament.download_pdf'))
                ->icon('heroicon-o-arrow-down-tray')
                ->url(fn () => route('projects.pdf.download', $this->record))
                ->openUrlInNewTab()
                ->visible(fn (): bool => PermissionHelper::hasAnyRole(['super_admin', 'admin', 'manager', 'sales'])),
            Actions\DeleteAction::make()
                ->visible(fn () => PermissionHelper::can('delete projects')),
        ];
    }

    public function canDelete(): bool
    {
        return PermissionHelper::can('delete projects');
    }
}

