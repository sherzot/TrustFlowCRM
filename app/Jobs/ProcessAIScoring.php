<?php

namespace App\Jobs;

use App\Models\Lead;
use App\Services\AIService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessAIScoring implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Lead $lead
    ) {}

    public function handle(AIService $aiService): void
    {
        $aiService->scoreLead($this->lead);
    }
}

