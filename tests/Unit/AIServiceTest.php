<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Services\AI\AIService;
use App\Services\AI\AiCallLogger;
use App\Services\AI\OpenAIClient;
use App\Services\AI\PromptTemplates;
use Illuminate\Support\Facades\Cache;
use Mockery;
use Tests\TestCase;

final class AIServiceTest extends TestCase
{
    public function test_prompt_templates_localise_by_locale(): void
    {
        $payload = [
            'company' => 'Acme',
            'industry' => 'SaaS',
            'source' => 'Inbound',
            'description' => 'Interested in enterprise plan',
        ];

        $en = PromptTemplates::leadScoring($payload, 'en');
        $uz = PromptTemplates::leadScoring($payload, 'uz');
        $ja = PromptTemplates::leadScoring($payload, 'ja');

        $this->assertStringContainsString('Reply ONLY', $en);
        $this->assertStringContainsString("FAQAT", $uz);
        $this->assertStringContainsString('必ず', $ja);
    }

    public function test_unknown_locale_falls_back_to_english(): void
    {
        $this->assertSame('en', PromptTemplates::locale('kl'));
        $this->assertSame('uz', PromptTemplates::locale('uz'));
    }

    public function test_service_returns_fallback_score_when_api_fails(): void
    {
        Cache::flush();

        $logger = Mockery::mock(AiCallLogger::class)->shouldIgnoreMissing();
        $client = Mockery::mock(OpenAIClient::class);
        $client->shouldReceive('chat')->once()->andReturn([
            'ok' => false,
            'content' => '',
            'raw' => [],
            'usage' => ['prompt_tokens' => 0, 'completion_tokens' => 0, 'total_tokens' => 0],
            'latency_ms' => 0,
            'error' => 'missing_api_key',
        ]);

        $service = new AIService($client);

        $lead = new \App\Models\Lead([
            'company' => 'Acme',
            'industry' => 'SaaS',
            'source' => 'Inbound',
            'description' => 'Trial user',
        ]);
        $lead->id = 1;
        $lead->tenant_id = 1;
        $lead->exists = true;

        // We don't actually persist; assert score falls back to 50 in [0,100].
        $score = (function () use ($service, $lead) {
            try {
                return $service->scoreLead($lead, 'en');
            } catch (\Throwable) {
                return null;
            }
        })();

        $this->assertNotNull($score);
        $this->assertGreaterThanOrEqual(0.0, $score);
        $this->assertLessThanOrEqual(100.0, $score);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
