<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Helpers\PermissionHelper;
use App\Helpers\PdfHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Barryvdh\DomPDF\Facade\Pdf;

class ProjectPdfController extends Controller
{
    /**
     * Project PDF ni ko'rish
     */
    public function view(Request $request, Project $project)
    {
        // RBAC tekshiruvi
        if (!PermissionHelper::hasAnyRole(['super_admin', 'admin', 'manager', 'sales'])) {
            abort(403, __('filament.unauthorized'));
        }

        // Tenant isolation tekshiruvi
        $user = auth()->user();
        if ($user->tenant_id !== null && $project->tenant_id !== $user->tenant_id) {
            abort(403, __('filament.unauthorized'));
        }

        $project->load(['account', 'deal', 'tasks']);

        // Locale'ni o'rnatish (session'dan yoki request'dan)
        $locale = session('locale', $request->get('locale', app()->getLocale()));
        App::setLocale($locale);
        app('translator')->setLocale($locale);
        
        // Translation key'larni oldindan yuklash va UTF-8 encoding bilan ishlatish
        $translations = [
            'project' => trans('filament.project', [], $locale),
            'name' => trans('filament.name', [], $locale),
            'account' => trans('filament.account', [], $locale),
            'deal' => trans('filament.deal', [], $locale),
            'status' => trans('filament.status', [], $locale),
            'start_date' => trans('filament.start_date', [], $locale),
            'end_date' => trans('filament.end_date', [], $locale),
            'description' => trans('filament.description', [], $locale),
            'project_statistics' => trans('filament.project_statistics', [], $locale),
            'budget' => trans('filament.budget', [], $locale),
            'actual_cost' => trans('filament.actual_cost', [], $locale),
            'profit' => trans('filament.profit', [], $locale),
            'progress' => trans('filament.progress', [], $locale),
            'tasks' => trans('filament.tasks', [], $locale),
            'title' => trans('filament.title', [], $locale),
            'priority' => trans('filament.priority', [], $locale),
            'due_date' => trans('filament.due_date', [], $locale),
            'no_description' => trans('filament.no_description', [], $locale),
            'generated_at' => trans('filament.generated_at', [], $locale),
            'project_report' => trans('filament.project_report', [], $locale),
        ];

        // Font tanlash: locale yoki matn ichidagi Yaponcha belgilarga qarab
        $defaultFont = PdfHelper::getFontForLocale($locale, $project);
        $hasJapanese = PdfHelper::modelHasJapaneseCharacters($project);
        
        // Agar Yaponcha belgilar bo'lsa, Noto Sans JP, aks holda DejaVu Sans
        // Lekin ikkala fontni ham yuklash uchun DejaVu Sans'ni default qilib qo'yamiz
        // CSS'da fallback fontlar ishlatiladi
        $pdfDefaultFont = ($locale === 'ja' || $hasJapanese) ? 'noto sans jp' : 'dejavu sans';

        $pdf = Pdf::loadView('pdf.project', compact('project', 'hasJapanese', 'locale', 'translations'))
            ->setPaper('a4', 'portrait')
            ->setOption('enable-font-subsetting', true)
            ->setOption('isRemoteEnabled', true)
            ->setOption('defaultFont', $pdfDefaultFont)
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', false)
            ->setOption('chroot', realpath(base_path()))
            ->setOption('isUnicode', true)
            ->setOption('enableCssFloat', true);

        return $pdf->stream("project-{$project->id}.pdf");
    }

    /**
     * Project PDF ni yuklab olish
     */
    public function download(Request $request, Project $project)
    {
        // RBAC tekshiruvi
        if (!PermissionHelper::hasAnyRole(['super_admin', 'admin', 'manager', 'sales'])) {
            abort(403, __('filament.unauthorized'));
        }

        // Tenant isolation tekshiruvi
        $user = auth()->user();
        if ($user->tenant_id !== null && $project->tenant_id !== $user->tenant_id) {
            abort(403, __('filament.unauthorized'));
        }

        $project->load(['account', 'deal', 'tasks']);

        // Locale'ni o'rnatish (session'dan yoki request'dan)
        $locale = session('locale', $request->get('locale', app()->getLocale()));
        App::setLocale($locale);
        app('translator')->setLocale($locale);
        
        // Translation key'larni oldindan yuklash va UTF-8 encoding bilan ishlatish
        $translations = [
            'project' => trans('filament.project', [], $locale),
            'name' => trans('filament.name', [], $locale),
            'account' => trans('filament.account', [], $locale),
            'deal' => trans('filament.deal', [], $locale),
            'status' => trans('filament.status', [], $locale),
            'start_date' => trans('filament.start_date', [], $locale),
            'end_date' => trans('filament.end_date', [], $locale),
            'description' => trans('filament.description', [], $locale),
            'project_statistics' => trans('filament.project_statistics', [], $locale),
            'budget' => trans('filament.budget', [], $locale),
            'actual_cost' => trans('filament.actual_cost', [], $locale),
            'profit' => trans('filament.profit', [], $locale),
            'progress' => trans('filament.progress', [], $locale),
            'tasks' => trans('filament.tasks', [], $locale),
            'title' => trans('filament.title', [], $locale),
            'priority' => trans('filament.priority', [], $locale),
            'due_date' => trans('filament.due_date', [], $locale),
            'no_description' => trans('filament.no_description', [], $locale),
            'generated_at' => trans('filament.generated_at', [], $locale),
            'project_report' => trans('filament.project_report', [], $locale),
        ];

        // Font tanlash: locale yoki matn ichidagi Yaponcha belgilarga qarab
        $defaultFont = PdfHelper::getFontForLocale($locale, $project);
        $hasJapanese = PdfHelper::modelHasJapaneseCharacters($project);
        
        // Agar Yaponcha belgilar bo'lsa, Noto Sans JP, aks holda DejaVu Sans
        // Lekin ikkala fontni ham yuklash uchun DejaVu Sans'ni default qilib qo'yamiz
        // CSS'da fallback fontlar ishlatiladi
        $pdfDefaultFont = ($locale === 'ja' || $hasJapanese) ? 'noto sans jp' : 'dejavu sans';

        $pdf = Pdf::loadView('pdf.project', compact('project', 'hasJapanese', 'locale', 'translations'))
            ->setPaper('a4', 'portrait')
            ->setOption('enable-font-subsetting', true)
            ->setOption('isRemoteEnabled', true)
            ->setOption('defaultFont', $pdfDefaultFont)
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', false)
            ->setOption('chroot', realpath(base_path()))
            ->setOption('isUnicode', true)
            ->setOption('enableCssFloat', true);

        return $pdf->download("project-{$project->id}.pdf");
    }
}
