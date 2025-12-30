<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use App\Models\Contract;
use App\Helpers\PermissionHelper;
use App\Helpers\PdfHelper;
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

        // Locale'ni o'rnatish (session'dan yoki request'dan)
        $locale = session('locale', $request->get('locale', app()->getLocale()));
        App::setLocale($locale);

        // Font tanlash: locale yoki matn ichidagi Yaponcha belgilarga qarab
        $defaultFont = PdfHelper::getFontForLocale($locale, $contract);
        $hasJapanese = PdfHelper::modelHasJapaneseCharacters($contract);

        $pdf = Pdf::loadView('pdf.contract', compact('contract', 'hasJapanese'))
            ->setPaper('a4', 'portrait')
            ->setOption('enable-font-subsetting', true)
            ->setOption('isRemoteEnabled', true)
            ->setOption('defaultFont', $defaultFont)
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', false)
            ->setOption('chroot', realpath(base_path()));

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

        // Locale'ni o'rnatish (session'dan yoki request'dan)
        $locale = session('locale', $request->get('locale', app()->getLocale()));
        App::setLocale($locale);

        // Font tanlash: locale yoki matn ichidagi Yaponcha belgilarga qarab
        $defaultFont = PdfHelper::getFontForLocale($locale, $contract);
        $hasJapanese = PdfHelper::modelHasJapaneseCharacters($contract);

        $pdf = Pdf::loadView('pdf.contract', compact('contract', 'hasJapanese'))
            ->setPaper('a4', 'portrait')
            ->setOption('enable-font-subsetting', true)
            ->setOption('isRemoteEnabled', true)
            ->setOption('defaultFont', $defaultFont)
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', false)
            ->setOption('chroot', realpath(base_path()));

        return $pdf->download("contract-{$contract->contract_number}.pdf");
    }
}
