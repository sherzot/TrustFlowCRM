<?php

namespace App\Observers;

use App\Models\Lead;
use App\Services\AIService;
use Illuminate\Support\Facades\Log;

class LeadObserver
{
    protected AIService $aiService;

    public function __construct(AIService $aiService)
    {
        $this->aiService = $aiService;
    }

    public function created(Lead $lead): void
    {
        // AI scoring
        try {
            $this->aiService->scoreLead($lead);
        } catch (\Exception $e) {
            Log::error('AI scoring failed for lead: ' . $e->getMessage());
        }
    }
}

