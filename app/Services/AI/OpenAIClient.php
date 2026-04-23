<?php

declare(strict_types=1);

namespace App\Services\AI;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Low-level HTTP client for the OpenAI REST API.
 *
 * Responsibilities:
 *  - Build chat/completions payloads
 *  - Retry on transient failures (429, 5xx, connection errors)
 *  - Persist each call through {@see AiCallLogger}
 *  - Return a normalised response structure
 *
 * Configuration keys (config/services.php):
 *  - services.openai.api_key
 *  - services.openai.model        (default: gpt-4o-mini)
 *  - services.openai.timeout      (default: 30)
 *  - services.openai.max_retries  (default: 3)
 *  - services.openai.base_url     (default: https://api.openai.com/v1)
 */
final class OpenAIClient
{
    public function __construct(
        private readonly AiCallLogger $logger,
    ) {
    }

    /**
     * @return array{
     *     ok: bool,
     *     content: string,
     *     raw: array<string, mixed>,
     *     usage: array{prompt_tokens:int,completion_tokens:int,total_tokens:int},
     *     latency_ms: int,
     *     error: ?string
     * }
     */
    public function chat(
        string $prompt,
        string $feature,
        ?string $model = null,
        float $temperature = 0.4,
        int $maxTokens = 600,
        array $metadata = [],
    ): array {
        $apiKey = (string) config('services.openai.api_key', '');
        $baseUrl = (string) config('services.openai.base_url', 'https://api.openai.com/v1');
        $model = $model ?? (string) config('services.openai.model', 'gpt-4o-mini');
        $timeout = (int) config('services.openai.timeout', 30);
        $retries = (int) config('services.openai.max_retries', 3);

        if ($apiKey === '') {
            $this->logger->log(
                feature: $feature,
                model: $model,
                prompt: $prompt,
                response: null,
                usage: null,
                latencyMs: 0,
                error: 'missing_api_key',
                metadata: $metadata,
            );

            return $this->emptyResponse('missing_api_key');
        }

        $started = microtime(true);

        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$apiKey}",
                'Content-Type' => 'application/json',
            ])
                ->timeout($timeout)
                ->retry($retries, 250, function ($exception) {
                    if ($exception instanceof ConnectionException) {
                        return true;
                    }
                    if ($exception instanceof RequestException) {
                        $status = $exception->response?->status();

                        return $status === 429 || ($status !== null && $status >= 500);
                    }

                    return false;
                }, throw: false)
                ->post("{$baseUrl}/chat/completions", [
                    'model' => $model,
                    'messages' => [
                        ['role' => 'user', 'content' => $prompt],
                    ],
                    'temperature' => $temperature,
                    'max_tokens' => $maxTokens,
                ]);
        } catch (\Throwable $e) {
            $latency = (int) round((microtime(true) - $started) * 1000);
            Log::error('OpenAI request threw', ['feature' => $feature, 'error' => $e->getMessage()]);
            $this->logger->log(
                feature: $feature,
                model: $model,
                prompt: $prompt,
                response: null,
                usage: null,
                latencyMs: $latency,
                error: $e->getMessage(),
                metadata: $metadata,
            );

            return $this->emptyResponse($e->getMessage(), $latency);
        }

        $latency = (int) round((microtime(true) - $started) * 1000);

        if ($response->failed()) {
            $message = 'http_' . $response->status();
            Log::warning('OpenAI request failed', [
                'feature' => $feature,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            $this->logger->log(
                feature: $feature,
                model: $model,
                prompt: $prompt,
                response: $response->json(),
                usage: null,
                latencyMs: $latency,
                error: $message,
                metadata: $metadata,
            );

            return $this->emptyResponse($message, $latency);
        }

        $json = $response->json();
        $content = (string) ($json['choices'][0]['message']['content'] ?? '');
        $usage = [
            'prompt_tokens' => (int) ($json['usage']['prompt_tokens'] ?? 0),
            'completion_tokens' => (int) ($json['usage']['completion_tokens'] ?? 0),
            'total_tokens' => (int) ($json['usage']['total_tokens'] ?? 0),
        ];

        $this->logger->log(
            feature: $feature,
            model: $model,
            prompt: $prompt,
            response: $json,
            usage: $usage,
            latencyMs: $latency,
            error: null,
            metadata: $metadata,
        );

        return [
            'ok' => true,
            'content' => $content,
            'raw' => $json,
            'usage' => $usage,
            'latency_ms' => $latency,
            'error' => null,
        ];
    }

    /**
     * @return array{ok:bool,content:string,raw:array,usage:array,latency_ms:int,error:?string}
     */
    private function emptyResponse(string $error, int $latency = 0): array
    {
        return [
            'ok' => false,
            'content' => '',
            'raw' => [],
            'usage' => ['prompt_tokens' => 0, 'completion_tokens' => 0, 'total_tokens' => 0],
            'latency_ms' => $latency,
            'error' => $error,
        ];
    }
}
