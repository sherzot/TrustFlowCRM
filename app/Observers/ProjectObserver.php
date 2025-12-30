<?php

namespace App\Observers;

use App\Models\Project;
use App\Models\Activity;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use App\Domains\Finance\FinanceService;

class ProjectObserver
{
    public function created(Project $project): void
    {
        Activity::create([
            'tenant_id' => $project->tenant_id,
            'user_id' => Auth::id(),
            'subject_type' => Project::class,
            'subject_id' => $project->id,
            'type' => 'created',
            'description' => "Project '{$project->name}' created",
        ]);
    }

    public function updated(Project $project): void
    {
        Activity::create([
            'tenant_id' => $project->tenant_id,
            'user_id' => Auth::id(),
            'subject_type' => Project::class,
            'subject_id' => $project->id,
            'type' => 'updated',
            'description' => "Project '{$project->name}' updated",
        ]);

        // Project tugaganda avtomatik Invoice yaratish
        if ($project->isDirty('status') && $project->status === 'completed' && !$project->invoice) {
            $financeService = app(FinanceService::class);
            $invoice = $financeService->createInvoiceFromProject($project, [
                'issue_date' => now(),
                'due_date' => now()->addDays(30),
                'tax_rate' => 0,
            ]);

            // Invoice ni avtomatik yuborish
            $invoice->update(['status' => 'sent']);
        }
    }

    public function deleted(Project $project): void
    {
        Activity::create([
            'tenant_id' => $project->tenant_id,
            'user_id' => Auth::id(),
            'subject_type' => Project::class,
            'subject_id' => $project->id,
            'type' => 'deleted',
            'description' => "Project '{$project->name}' deleted",
        ]);
    }
}

