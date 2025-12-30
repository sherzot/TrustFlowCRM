<?php

namespace App\Filament\Resources\ContractResource\Pages;

use App\Filament\Resources\ContractResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Helpers\TenantHelper;
use Illuminate\Support\Str;

class CreateContract extends CreateRecord
{
    protected static string $resource = ContractResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['tenant_id'] = TenantHelper::getTenantId();
        
        // Avtomatik contract_number generatsiya qilish
        if (empty($data['contract_number'])) {
            $data['contract_number'] = $this->generateContractNumber($data['tenant_id']);
        }

        return $data;
    }

    protected function generateContractNumber(int $tenantId): string
    {
        $year = now()->year;
        $month = now()->format('m');
        $lastContract = \App\Models\Contract::where('tenant_id', $tenantId)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', now()->month)
            ->orderBy('id', 'desc')
            ->first();

        $number = $lastContract ? ((int) substr($lastContract->contract_number, -4)) + 1 : 1;

        return sprintf('CNT-%s%s-%04d', $year, $month, $number);
    }
}
