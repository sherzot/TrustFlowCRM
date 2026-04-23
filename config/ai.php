<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| TrustFlow AI Configuration
|--------------------------------------------------------------------------
|
| Central configuration for the app/Services/AI layer. Pricing numbers are
| USD per 1,000 tokens and are used by AiCallLogger to compute a running
| cost estimate per tenant / feature.
|
*/

return [

    // Seconds to cache AI responses per tenant + feature + entity id.
    // Set to 0 to disable caching (useful in tests).
    'cache_ttl' => env('AI_CACHE_TTL', 900),

    // Per-1K-token prices (USD). Override via env or update directly.
    // "default" is used when the model name isn't listed.
    'pricing' => [
        'default'      => ['input' => 0.005, 'output' => 0.015],
        'gpt-4o'       => ['input' => 0.005, 'output' => 0.015],
        'gpt-4o-mini'  => ['input' => 0.00015, 'output' => 0.0006],
        'gpt-4-turbo'  => ['input' => 0.01, 'output' => 0.03],
        'gpt-4'        => ['input' => 0.03, 'output' => 0.06],
        'gpt-3.5-turbo'=> ['input' => 0.0005, 'output' => 0.0015],
    ],

    // Per-feature rate limit (calls per minute per tenant). 0 = unlimited.
    'rate_limits' => [
        'lead_scoring'     => (int) env('AI_RL_LEAD_SCORING', 60),
        'deal_prediction'  => (int) env('AI_RL_DEAL_PREDICTION', 60),
        'risk_detection'   => (int) env('AI_RL_RISK_DETECTION', 60),
        'churn_detection'  => (int) env('AI_RL_CHURN_DETECTION', 60),
        'email_generation' => (int) env('AI_RL_EMAIL_GENERATION', 30),
        'nlp'              => (int) env('AI_RL_NLP', 30),
    ],

];
