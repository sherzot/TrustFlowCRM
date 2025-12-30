<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Helpers\PermissionHelper;
use Illuminate\Http\Request;
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

        $pdf = Pdf::loadView('pdf.project', compact('project'));

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

        $pdf = Pdf::loadView('pdf.project', compact('project'));

        return $pdf->download("project-{$project->id}.pdf");
    }
}
