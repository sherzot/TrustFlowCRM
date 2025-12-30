<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use App\Models\Invoice;
use App\Helpers\PermissionHelper;
use App\Helpers\PdfHelper;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoicePdfController extends Controller
{
    /**
     * Invoice PDF ni ko'rish
     */
    public function view(Request $request, Invoice $invoice)
    {
        // RBAC tekshiruvi - Super Admin, Admin, Manager, Sales
        if (!PermissionHelper::hasAnyRole(['super_admin', 'admin', 'manager', 'sales'])) {
            abort(403, __('filament.unauthorized'));
        }

        // Tenant isolation tekshiruvi
        $user = auth()->user();
        if ($user->tenant_id !== null && $invoice->tenant_id !== $user->tenant_id) {
            abort(403, __('filament.unauthorized'));
        }

        $invoice->load(['account', 'project', 'items']);

        // Locale'ni o'rnatish (session'dan yoki request'dan)
        $locale = session('locale', $request->get('locale', app()->getLocale()));
        App::setLocale($locale);
        app('translator')->setLocale($locale);
        
        // Translation key'larni oldindan yuklash va UTF-8 encoding bilan ishlatish
        $translations = [
            'invoice' => trans('filament.invoice', [], $locale),
            'invoice_number' => trans('filament.invoice_number', [], $locale),
            'account' => trans('filament.account', [], $locale),
            'project' => trans('filament.project', [], $locale),
            'issue_date' => trans('filament.issue_date', [], $locale),
            'due_date' => trans('filament.due_date', [], $locale),
            'status' => trans('filament.status', [], $locale),
            'subtotal' => trans('filament.subtotal', [], $locale),
            'tax_rate' => trans('filament.tax_rate', [], $locale),
            'tax_amount' => trans('filament.tax_amount', [], $locale),
            'total' => trans('filament.total', [], $locale),
            'currency' => trans('filament.currency', [], $locale),
            'notes' => trans('filament.notes', [], $locale),
            'description' => trans('filament.description', [], $locale),
            'quantity' => trans('filament.quantity', [], $locale),
            'unit_price' => trans('filament.unit_price', [], $locale),
            'amount' => trans('filament.amount', [], $locale),
            'items' => trans('filament.items', [], $locale),
            'generated_at' => trans('filament.generated_at', [], $locale),
            'invoice_document' => trans('filament.invoice_document', [], $locale),
        ];

        // Font tanlash: locale yoki matn ichidagi Yaponcha belgilarga qarab
        $defaultFont = PdfHelper::getFontForLocale($locale, $invoice);
        $hasJapanese = PdfHelper::modelHasJapaneseCharacters($invoice);

        // Agar Yaponcha belgilar bo'lsa, Noto Sans JP, aks holda DejaVu Sans
        $pdfDefaultFont = ($locale === 'ja' || $hasJapanese) ? 'noto sans jp' : 'dejavu sans';

        $pdf = Pdf::loadView('pdf.invoice', compact('invoice', 'hasJapanese', 'locale', 'translations'))
            ->setPaper('a4', 'portrait')
            ->setOption('enable-font-subsetting', true)
            ->setOption('isRemoteEnabled', true)
            ->setOption('defaultFont', $pdfDefaultFont)
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', false)
            ->setOption('chroot', realpath(base_path()))
            ->setOption('isUnicode', true)
            ->setOption('enableCssFloat', true);

        return $pdf->stream("invoice-{$invoice->invoice_number}.pdf");
    }

    /**
     * Invoice PDF ni yuklab olish
     */
    public function download(Request $request, Invoice $invoice)
    {
        // RBAC tekshiruvi - Super Admin, Admin, Manager, Sales
        if (!PermissionHelper::hasAnyRole(['super_admin', 'admin', 'manager', 'sales'])) {
            abort(403, __('filament.unauthorized'));
        }

        // Tenant isolation tekshiruvi
        $user = auth()->user();
        if ($user->tenant_id !== null && $invoice->tenant_id !== $user->tenant_id) {
            abort(403, __('filament.unauthorized'));
        }

        $invoice->load(['account', 'project', 'items']);

        // Locale'ni o'rnatish (session'dan yoki request'dan)
        $locale = session('locale', $request->get('locale', app()->getLocale()));
        App::setLocale($locale);
        app('translator')->setLocale($locale);
        
        // Translation key'larni oldindan yuklash va UTF-8 encoding bilan ishlatish
        $translations = [
            'invoice' => trans('filament.invoice', [], $locale),
            'invoice_number' => trans('filament.invoice_number', [], $locale),
            'account' => trans('filament.account', [], $locale),
            'project' => trans('filament.project', [], $locale),
            'issue_date' => trans('filament.issue_date', [], $locale),
            'due_date' => trans('filament.due_date', [], $locale),
            'status' => trans('filament.status', [], $locale),
            'subtotal' => trans('filament.subtotal', [], $locale),
            'tax_rate' => trans('filament.tax_rate', [], $locale),
            'tax_amount' => trans('filament.tax_amount', [], $locale),
            'total' => trans('filament.total', [], $locale),
            'currency' => trans('filament.currency', [], $locale),
            'notes' => trans('filament.notes', [], $locale),
            'description' => trans('filament.description', [], $locale),
            'quantity' => trans('filament.quantity', [], $locale),
            'unit_price' => trans('filament.unit_price', [], $locale),
            'amount' => trans('filament.amount', [], $locale),
            'items' => trans('filament.items', [], $locale),
            'generated_at' => trans('filament.generated_at', [], $locale),
            'invoice_document' => trans('filament.invoice_document', [], $locale),
        ];

        // Font tanlash: locale yoki matn ichidagi Yaponcha belgilarga qarab
        $defaultFont = PdfHelper::getFontForLocale($locale, $invoice);
        $hasJapanese = PdfHelper::modelHasJapaneseCharacters($invoice);

        // Agar Yaponcha belgilar bo'lsa, Noto Sans JP, aks holda DejaVu Sans
        $pdfDefaultFont = ($locale === 'ja' || $hasJapanese) ? 'noto sans jp' : 'dejavu sans';

        $pdf = Pdf::loadView('pdf.invoice', compact('invoice', 'hasJapanese', 'locale', 'translations'))
            ->setPaper('a4', 'portrait')
            ->setOption('enable-font-subsetting', true)
            ->setOption('isRemoteEnabled', true)
            ->setOption('defaultFont', $pdfDefaultFont)
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', false)
            ->setOption('chroot', realpath(base_path()))
            ->setOption('isUnicode', true)
            ->setOption('enableCssFloat', true);

        return $pdf->download("invoice-{$invoice->invoice_number}.pdf");
    }
}

