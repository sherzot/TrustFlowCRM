<?php

namespace App\Filament\Resources\ContractResource\Pages;

use App\Filament\Resources\ContractResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Helpers\PermissionHelper;

class EditContract extends EditRecord
{
    protected static string $resource = ContractResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('view_pdf')
                ->label(__('filament.view_pdf'))
                ->icon('heroicon-o-document-text')
                ->url(fn () => route('contracts.pdf.view', $this->record))
                ->openUrlInNewTab()
                ->visible(fn (): bool => PermissionHelper::hasAnyRole(['super_admin', 'admin', 'manager', 'sales'])),
            Actions\Action::make('download_pdf')
                ->label(__('filament.download_pdf'))
                ->icon('heroicon-o-arrow-down-tray')
                ->url(fn () => route('contracts.pdf.download', $this->record))
                ->openUrlInNewTab()
                ->visible(fn (): bool => PermissionHelper::hasAnyRole(['super_admin', 'admin', 'manager', 'sales'])),
            Actions\DeleteAction::make(),
        ];
    }
}
