<?php

namespace App\Domains\Delivery;

use App\Models\Project;
use App\Models\Task;
use App\Models\TimeEntry;
use Illuminate\Support\Facades\DB;

class DeliveryService
{
    /**
     * Project yaratish Deal dan
     */
    public function createProjectFromDeal(int $dealId, array $data): Project
    {
        $deal = \App\Models\Deal::findOrFail($dealId);
        
        $project = Project::create([
            'tenant_id' => $deal->tenant_id,
            'deal_id' => $dealId,
            'account_id' => $deal->account_id,
            'name' => $data['name'] ?? $deal->name,
            'description' => $data['description'] ?? $deal->description,
            'budget' => $deal->value,
            'currency' => $deal->currency,
            'status' => 'planning',
            'start_date' => $data['start_date'] ?? now(),
        ]);

        return $project;
    }

    /**
     * Task yaratish
     */
    public function createTask(array $data): Task
    {
        return Task::create($data);
    }

    /**
     * Time entry yaratish
     */
    public function createTimeEntry(array $data): TimeEntry
    {
        $entry = TimeEntry::create($data);

        // Project progress ni yangilash
        $this->updateProjectProgress($entry->project_id);

        return $entry;
    }

    /**
     * Time entry ni to'xtatish
     */
    public function stopTimeEntry(TimeEntry $entry): TimeEntry
    {
        $entry->update([
            'end_time' => now(),
            'duration' => $entry->start_time->diffInHours(now()),
        ]);

        $this->updateProjectProgress($entry->project_id);

        return $entry;
    }

    /**
     * Project progress ni yangilash
     */
    protected function updateProjectProgress(int $projectId): void
    {
        $project = Project::findOrFail($projectId);
        
        $totalHours = TimeEntry::where('project_id', $projectId)
            ->sum('duration');
        
        $estimatedHours = Task::where('project_id', $projectId)
            ->sum('estimated_hours');
        
        $progress = $estimatedHours > 0 
            ? min(100, ($totalHours / $estimatedHours) * 100)
            : 0;

        $project->update(['progress' => (int) $progress]);
    }

    /**
     * Project profit ni hisoblash
     */
    public function calculateProjectProfit(Project $project): Project
    {
        $totalCost = TimeEntry::where('project_id', $project->id)
            ->where('is_billable', true)
            ->sum(DB::raw('duration * hourly_rate'));

        $profit = $project->budget - $totalCost;

        $project->update([
            'actual_cost' => $totalCost,
            'profit' => $profit,
        ]);

        return $project;
    }
}

