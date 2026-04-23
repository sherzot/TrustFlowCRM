<?php

declare(strict_types=1);

namespace App\Services\AI;

use App\Models\Account;
use App\Models\Deal;
use App\Models\Lead;
use Illuminate\Support\Facades\Cache;

/**
 * High-level, tenant-aware facade over the OpenAI client.
 *
 * Each public method:
 *   - builds a locale-aware prompt via {@see PromptTemplates}
 *   - dispatches the request through {@see OpenAIClient} (retry + telemetry)
 *   - caches the result per tenant/feature for a configurable TTL
 *   - degrades gracefully to deterministic fallback values if the API fails
 *
 * This is the service new callers should depend on. The legacy
 * App\Services\AIService remains in place for backwards compatibility.
 */
final class AIService
{
    public function __construct(
        private readonly OpenAIClient $client,
    ) {
    }

    public function scoreLead(Lead $lead, ?string $locale = null): float
    {
        $payload = [
            'company' => (string) $lead->company,
            'industry' => (string) $lead->industry,
            'source' => (string) $lead->source,
            'description' => (string) $lead->description,
        ];

        $result = $this->remember(
            "ai:lead_scoring:{$lead->getKey()}",
            fn () => $this->client->chat(
                prompt: PromptTemplates::leadScoring($payload, $locale),
                feature: 'lead_scoring',
                temperature: 0.2,
                maxTokens: 200,
                metadata: ['lead_id' => $lead->getKey()],
            ),
        );

        $score = $this->jsonField($result['content'] ?? '', 'score', 50.0);
        $score = (float) max(0, min(100, $score));

        $lead->forceFill(['ai_score' => $score])->save();

        return $score;
    }

    /**
     * @return array{score:float,probability:int,reason:string}
     */
    public function predictDeal(Deal $deal, ?string $locale = null): array
    {
        $payload = [
            'name' => (string) $deal->name,
            'value' => (string) $deal->value,
            'currency' => (string) $deal->currency,
            'stage' => (string) $deal->stage,
            'description' => (string) $deal->description,
        ];

        $result = $this->remember(
            "ai:deal_prediction:{$deal->getKey()}",
            fn () => $this->client->chat(
                prompt: PromptTemplates::dealPrediction($payload, $locale),
                feature: 'deal_prediction',
                temperature: 0.2,
                maxTokens: 250,
                metadata: ['deal_id' => $deal->getKey()],
            ),
        );

        $decoded = $this->jsonDecode($result['content'] ?? '');
        $score = (float) max(0, min(100, $decoded['score'] ?? 50));
        $probability = (int) max(0, min(100, $decoded['probability'] ?? 50));

        $deal->forceFill(['ai_score' => $score])->save();

        return [
            'score' => $score,
            'probability' => $probability,
            'reason' => (string) ($decoded['reason'] ?? ''),
        ];
    }

    /**
     * @return array{risk_level:string,factors:array<int,string>}
     */
    public function detectRisk(Deal $deal, ?string $locale = null): array
    {
        $payload = [
            'name' => (string) $deal->name,
            'value' => (string) $deal->value,
            'stage' => (string) $deal->stage,
            'expected_close_date' => (string) $deal->expected_close_date,
        ];

        $result = $this->remember(
            "ai:deal_risk:{$deal->getKey()}",
            fn () => $this->client->chat(
                prompt: PromptTemplates::risk($payload, $locale),
                feature: 'risk_detection',
                temperature: 0.1,
                maxTokens: 250,
                metadata: ['deal_id' => $deal->getKey()],
            ),
        );

        $decoded = $this->jsonDecode($result['content'] ?? '');

        return [
            'risk_level' => (string) ($decoded['risk_level'] ?? 'low'),
            'factors' => array_values(array_map('strval', (array) ($decoded['factors'] ?? []))),
        ];
    }

    /**
     * @return array{risk_level:string,probability:int,reason:string}
     */
    public function detectChurn(Account $account, ?string $locale = null): array
    {
        $payload = [
            'name' => (string) $account->name,
            'industry' => (string) $account->industry,
            'status' => (string) $account->status,
            'updated_at' => (string) $account->updated_at,
        ];

        $result = $this->remember(
            "ai:account_churn:{$account->getKey()}",
            fn () => $this->client->chat(
                prompt: PromptTemplates::churn($payload, $locale),
                feature: 'churn_detection',
                temperature: 0.1,
                maxTokens: 250,
                metadata: ['account_id' => $account->getKey()],
            ),
        );

        $decoded = $this->jsonDecode($result['content'] ?? '');

        return [
            'risk_level' => (string) ($decoded['risk_level'] ?? 'low'),
            'probability' => (int) max(0, min(100, $decoded['probability'] ?? 0)),
            'reason' => (string) ($decoded['reason'] ?? ''),
        ];
    }

    public function generateEmail(string $context, string $tone = 'professional', ?string $locale = null): string
    {
        $result = $this->client->chat(
            prompt: PromptTemplates::email($context, $tone, $locale),
            feature: 'email_generation',
            temperature: 0.7,
            maxTokens: 700,
            metadata: ['tone' => $tone],
        );

        return (string) ($result['content'] ?? '');
    }

    public function askQuestion(string $question, array $context = [], ?string $locale = null): string
    {
        $result = $this->client->chat(
            prompt: PromptTemplates::nlp($question, $context, $locale),
            feature: 'nlp',
            temperature: 0.3,
            maxTokens: 500,
        );

        return (string) ($result['content'] ?? '');
    }

    private function remember(string $key, \Closure $callback): array
    {
        $ttl = (int) config('ai.cache_ttl', 900);

        if ($ttl <= 0) {
            return $callback();
        }

        $tenantKey = $this->tenantCacheKey();

        return Cache::remember("{$tenantKey}:{$key}", $ttl, $callback);
    }

    private function tenantCacheKey(): string
    {
        if (! app()->bound(\App\Models\Tenant::class)) {
            return 'global';
        }
        try {
            $tenant = app(\App\Models\Tenant::class);

            return 'tenant:' . ($tenant?->getKey() ?? 'none');
        } catch (\Throwable) {
            return 'global';
        }
    }

    private function jsonDecode(string $content): array
    {
        $content = trim($content);
        // Strip ```json fences if present.
        $content = preg_replace('/^```(?:json)?|```$/m', '', $content) ?? $content;
        $decoded = json_decode(trim($content), true);

        return is_array($decoded) ? $decoded : [];
    }

    private function jsonField(string $content, string $field, float|int $default): float
    {
        $decoded = $this->jsonDecode($content);

        if (isset($decoded[$field]) && is_numeric($decoded[$field])) {
            return (float) $decoded[$field];
        }

        // Last resort: extract first number from free-form response.
        if (preg_match('/\d+(?:\.\d+)?/', $content, $m)) {
            return (float) $m[0];
        }

        return (float) $default;
    }
}
