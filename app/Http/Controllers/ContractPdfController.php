<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Helpers\PermissionHelper;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ContractPdfController extends Controller
{
    /**
     * Contract PDF ni ko'rish
     */
    public function view(Request $request, Contract $contract)
    {
        // RBAC tekshiruvi
        if (!PermissionHelper::hasAnyRole(['super_admin', 'admin', 'manager', 'sales'])) {
            abort(403, __('filament.unauthorized'));
        }

        // Tenant isolation tekshiruvi
        $user = auth()->user();
        if ($user->tenant_id !== null && $contract->tenant_id !== $user->tenant_id) {
            abort(403, __('filament.unauthorized'));
        }

        $contract->load(['account', 'deal', 'project']);

        $pdf = Pdf::loadView('pdf.contract', compact('contract'));

        return $pdf->stream("contract-{$contract->contract_number}.pdf");
    }

    /**
     * Contract PDF ni yuklab olish
     */
    public function download(Request $request, Contract $contract)
    {
        // RBAC tekshiruvi
        if (!PermissionHelper::hasAnyRole(['super_admin', 'admin', 'manager', 'sales'])) {
            abort(403, __('filament.unauthorized'));
        }

        // Tenant isolation tekshiruvi
        $user = auth()->user();
        if ($user->tenant_id !== null && $contract->tenant_id !== $user->tenant_id) {
            abort(403, __('filament.unauthorized'));
        }

        $contract->load(['account', 'deal', 'project']);

        $pdf = Pdf::loadView('pdf.contract', compact('contract'));

        return $pdf->download("contract-{$contract->contract_number}.pdf");
    }
}

