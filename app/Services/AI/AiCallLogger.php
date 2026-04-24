<?php

declare(strict_types=1);

namespace App\Services\AI;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Persists every AI call to the `ai_calls` table (tokens, cost, latency, error).
 *
 * The table is tenant-aware but optional: if the Tenant is not bound (e.g. inside
 * a queued job without context) the column is simply left null and logging still
 * proceeds — we never fail the user-facing flow because the logger could not
 * persist a row.
 *
 * Cost pricing (per 1K tokens) is pulled from config/ai.php so it can be tuned
 * per deployment without code changes.
 *
 * NOTE: intentionally NOT `final`. Tests (Tests\Unit\AIServiceTest) build a
 * Mockery mock of this class to isolate the AI service from the DB, and
 * Mockery cannot replace methods on `final` classes. Keeping the class
 * extendable is a test-only concession; production code should not subclass
 * it.
 */
class AiCallLogger
{
    /**
     * @param  array<string, mixed>|null  $response
     * @param  array{prompt_tokens:int,completion_tokens:int,total_tokens:int}|null  $usage
     * @param  array<string, mixed>  $metadata
     */
    public function log(
        string $feature,
        string $model,
        string $prompt,
        ?array $response,
        ?array $usage,
        int $latencyMs,
        ?string $error,
        array $metadata = [],
    ): void {
        $usage ??= ['prompt_tokens' => 0, 'completion_tokens' => 0, 'total_tokens' => 0];

        $cost = $this->calculateCost($model, $usage);

        try {
            DB::table('ai_calls')->insert([
                'tenant_id' => $this->resolveTenantId(),
                'user_id' => auth()->id(),
                'feature' => $feature,
                'model' => $model,
                'prompt_tokens' => $usage['prompt_tokens'],
                'completion_tokens' => $usage['completion_tokens'],
                'total_tokens' => $usage['total_tokens'],
                'cost_usd' => $cost,
                'latency_ms' => $latencyMs,
                'error' => $error,
                'metadata' => json_encode($metadata, JSON_UNESCAPED_UNICODE),
                'prompt_preview' => mb_substr($prompt, 0, 500),
                'response_preview' => mb_substr(
                    (string) ($response['choices'][0]['message']['content'] ?? ''),
                    0,
                    500,
                ),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Throwable $e) {
            // Swallow — telemetry must never break business logic.
            Log::warning('ai_call_logger_failed', [
                'error' => $e->getMessage(),
                'feature' => $feature,
            ]);
        }
    }

    /**
     * @param  array{prompt_tokens:int,completion_tokens:int,total_tokens:int}  $usage
     */
    private function calculateCost(string $model, array $usage): float
    {
        /** @var array<string, array{input:float,output:float}> $pricing */
        $pricing = (array) config('ai.pricing', []);
        $entry = $pricing[$model] ?? $pricing['default'] ?? ['input' => 0.0, 'output' => 0.0];

        $input = ($usage['prompt_tokens'] / 1000) * ($entry['input'] ?? 0);
        $output = ($usage['completion_tokens'] / 1000) * ($entry['output'] ?? 0);

        return round($input + $output, 6);
    }

    private function resolveTenantId(): ?int
    {
        if (! app()->bound(\App\Models\Tenant::class)) {
            return null;
        }

        try {
            $tenant = app(\App\Models\Tenant::class);

            return $tenant?->getKey();
        } catch (\Throwable) {
            return null;
        }
    }
}
