<?php

namespace App\Filament\Resources\InvoiceResource\Pages;

use App\Filament\Resources\InvoiceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
use App\Helpers\PermissionHelper;

class EditInvoice extends EditRecord
{
    protected static string $resource = InvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('view_pdf')
                ->label(__('filament.view_pdf'))
                ->icon('heroicon-o-document-text')
                ->url(fn () => route('invoices.pdf.view', $this->record))
                ->openUrlInNewTab()
                ->visible(fn (): bool => PermissionHelper::hasAnyRole(['super_admin', 'admin', 'manager', 'sales'])),
            Actions\Action::make('download_pdf')
                ->label(__('filament.download_pdf'))
                ->icon('heroicon-o-arrow-down-tray')
                ->url(fn () => route('invoices.pdf.download', $this->record))
                ->openUrlInNewTab()
                ->visible(fn (): bool => PermissionHelper::hasAnyRole(['super_admin', 'admin', 'manager', 'sales'])),
            Actions\DeleteAction::make()
                ->visible(fn () => PermissionHelper::can('delete invoices')),
        ];
    }

    public function canDelete(): bool
    {
        return PermissionHelper::can('delete invoices');
    }
}

