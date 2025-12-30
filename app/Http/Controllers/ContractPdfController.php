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
        app('translator')->setLocale($locale);
        
        // Translation key'larni oldindan yuklash va UTF-8 encoding bilan ishlatish
        $translations = [
            'contract' => trans('filament.contract', [], $locale),
            'contract_number' => trans('filament.contract_number', [], $locale),
            'title' => trans('filament.title', [], $locale),
            'account' => trans('filament.account', [], $locale),
            'deal' => trans('filament.deal', [], $locale),
            'project' => trans('filament.project', [], $locale),
            'status' => trans('filament.status', [], $locale),
            'signed_at' => trans('filament.signed_at', [], $locale),
            'signed_by' => trans('filament.signed_by', [], $locale),
            'content' => trans('filament.content', [], $locale),
            'signature' => trans('filament.signature', [], $locale),
            'generated_at' => trans('filament.generated_at', [], $locale),
            'contract_document' => trans('filament.contract_document', [], $locale),
        ];

        // Font tanlash: locale yoki matn ichidagi Yaponcha belgilarga qarab
        $defaultFont = PdfHelper::getFontForLocale($locale, $contract);
        $hasJapanese = PdfHelper::modelHasJapaneseCharacters($contract);

        // Agar Yaponcha belgilar bo'lsa, Noto Sans JP, aks holda DejaVu Sans
        // Lekin ikkala fontni ham yuklash uchun DejaVu Sans'ni default qilib qo'yamiz
        // CSS'da fallback fontlar ishlatiladi
        $pdfDefaultFont = ($locale === 'ja' || $hasJapanese) ? 'noto sans jp' : 'dejavu sans';

        $pdf = Pdf::loadView('pdf.contract', compact('contract', 'hasJapanese', 'locale', 'translations'))
            ->setPaper('a4', 'portrait')
            ->setOption('enable-font-subsetting', true)
            ->setOption('isRemoteEnabled', true)
            ->setOption('defaultFont', $pdfDefaultFont)
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', false)
            ->setOption('chroot', realpath(base_path()))
            ->setOption('isUnicode', true)
            ->setOption('enableCssFloat', true);

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
        app('translator')->setLocale($locale);
        
        // Translation key'larni oldindan yuklash va UTF-8 encoding bilan ishlatish
        $translations = [
            'contract' => trans('filament.contract', [], $locale),
            'contract_number' => trans('filament.contract_number', [], $locale),
            'title' => trans('filament.title', [], $locale),
            'account' => trans('filament.account', [], $locale),
            'deal' => trans('filament.deal', [], $locale),
            'project' => trans('filament.project', [], $locale),
            'status' => trans('filament.status', [], $locale),
            'signed_at' => trans('filament.signed_at', [], $locale),
            'signed_by' => trans('filament.signed_by', [], $locale),
            'content' => trans('filament.content', [], $locale),
            'signature' => trans('filament.signature', [], $locale),
            'generated_at' => trans('filament.generated_at', [], $locale),
            'contract_document' => trans('filament.contract_document', [], $locale),
        ];

        // Font tanlash: locale yoki matn ichidagi Yaponcha belgilarga qarab
        $defaultFont = PdfHelper::getFontForLocale($locale, $contract);
        $hasJapanese = PdfHelper::modelHasJapaneseCharacters($contract);

        // Agar Yaponcha belgilar bo'lsa, Noto Sans JP, aks holda DejaVu Sans
        // Lekin ikkala fontni ham yuklash uchun DejaVu Sans'ni default qilib qo'yamiz
        // CSS'da fallback fontlar ishlatiladi
        $pdfDefaultFont = ($locale === 'ja' || $hasJapanese) ? 'noto sans jp' : 'dejavu sans';

        $pdf = Pdf::loadView('pdf.contract', compact('contract', 'hasJapanese', 'locale', 'translations'))
            ->setPaper('a4', 'portrait')
            ->setOption('enable-font-subsetting', true)
            ->setOption('isRemoteEnabled', true)
            ->setOption('defaultFont', $pdfDefaultFont)
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', false)
            ->setOption('chroot', realpath(base_path()))
            ->setOption('isUnicode', true)
            ->setOption('enableCssFloat', true);

        return $pdf->download("contract-{$contract->contract_number}.pdf");
    }
}
