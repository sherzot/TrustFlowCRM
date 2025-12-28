<?php

namespace App\Services;

use App\Models\Lead;
use App\Models\Deal;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIService
{
    protected string $apiKey;
    protected string $baseUrl = 'https://api.openai.com/v1';

    public function __construct()
    {
        $this->apiKey = config('services.openai.api_key', '');
    }

    /**
     * Lead scoring - AI orqali lead ballini hisoblash
     */
    public function scoreLead(Lead $lead): float
    {
        try {
            $prompt = $this->buildLeadScoringPrompt($lead);
            $response = $this->callOpenAI($prompt);
            
            $score = $this->extractScore($response);
            $lead->update(['ai_score' => $score]);
            
            return $score;
        } catch (\Exception $e) {
            Log::error('AI Lead Scoring Error: ' . $e->getMessage());
            return 50.0; // Default score
        }
    }

    /**
     * Deal prediction - Deal yutish ehtimolini bashorat qilish
     */
    public function predictDeal(Deal $deal): array
    {
        try {
            $prompt = $this->buildDealPredictionPrompt($deal);
            $response = $this->callOpenAI($prompt);
            
            $prediction = $this->extractPrediction($response);
            $deal->update(['ai_score' => $prediction['score']]);
            
            return $prediction;
        } catch (\Exception $e) {
            Log::error('AI Deal Prediction Error: ' . $e->getMessage());
            return ['score' => 50.0, 'probability' => 50];
        }
    }

    /**
     * Email generation - Email yaratish
     */
    public function generateEmail(string $context, string $tone = 'professional'): string
    {
        try {
            $prompt = "以下のコンテキストに基づいて、{$tone}なトーンでメールを生成してください:\n\n{$context}";
            $response = $this->callOpenAI($prompt);
            
            return $this->extractText($response);
        } catch (\Exception $e) {
            Log::error('AI Email Generation Error: ' . $e->getMessage());
            return '';
        }
    }

    /**
     * Natural Language Processing - Savollarga javob berish
     */
    public function askQuestion(string $question, array $context = []): string
    {
        try {
            $contextText = implode("\n", $context);
            $prompt = "以下の情報に基づいて質問に答えてください:\n\n{$contextText}\n\n質問: {$question}";
            $response = $this->callOpenAI($prompt);
            
            return $this->extractText($response);
        } catch (\Exception $e) {
            Log::error('AI NLP Error: ' . $e->getMessage());
            return '申し訳ございませんが、回答を生成できませんでした。';
        }
    }

    /**
     * Risk detection - Xavfni aniqlash
     */
    public function detectRisk(Deal $deal): array
    {
        try {
            $prompt = $this->buildRiskDetectionPrompt($deal);
            $response = $this->callOpenAI($prompt);
            
            return $this->extractRisk($response);
        } catch (\Exception $e) {
            Log::error('AI Risk Detection Error: ' . $e->getMessage());
            return ['risk_level' => 'low', 'factors' => []];
        }
    }

    protected function buildLeadScoringPrompt(Lead $lead): string
    {
        return "以下のリード情報を分析し、0-100のスコアを付けてください:\n\n" .
               "会社名: {$lead->company}\n" .
               "業界: {$lead->industry}\n" .
               "説明: {$lead->description}\n" .
               "ソース: {$lead->source}\n\n" .
               "スコアのみを数値で返してください。";
    }

    protected function buildDealPredictionPrompt(Deal $deal): string
    {
        return "以下の取引情報を分析し、成功確率を予測してください:\n\n" .
               "取引名: {$deal->name}\n" .
               "価値: {$deal->value} {$deal->currency}\n" .
               "ステージ: {$deal->stage}\n" .
               "説明: {$deal->description}\n\n" .
               "スコア(0-100)と確率(0-100%)をJSON形式で返してください。";
    }

    protected function buildRiskDetectionPrompt(Deal $deal): string
    {
        return "以下の取引のリスク要因を分析してください:\n\n" .
               "取引名: {$deal->name}\n" .
               "価値: {$deal->value}\n" .
               "ステージ: {$deal->stage}\n" .
               "期待クローズ日: {$deal->expected_close_date}\n\n" .
               "リスクレベル(low/medium/high)と要因をJSON形式で返してください。";
    }

    protected function callOpenAI(string $prompt): array
    {
        if (empty($this->apiKey)) {
            throw new \Exception('OpenAI API key not configured');
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post("{$this->baseUrl}/chat/completions", [
            'model' => 'gpt-4',
            'messages' => [
                ['role' => 'user', 'content' => $prompt]
            ],
            'temperature' => 0.7,
            'max_tokens' => 500,
        ]);

        if ($response->failed()) {
            throw new \Exception('OpenAI API request failed: ' . $response->body());
        }

        return $response->json();
    }

    protected function extractScore(array $response): float
    {
        $content = $response['choices'][0]['message']['content'] ?? '';
        preg_match('/\d+/', $content, $matches);
        return (float) ($matches[0] ?? 50.0);
    }

    protected function extractPrediction(array $response): array
    {
        $content = $response['choices'][0]['message']['content'] ?? '';
        $decoded = json_decode($content, true);
        
        return [
            'score' => $decoded['score'] ?? 50.0,
            'probability' => $decoded['probability'] ?? 50,
        ];
    }

    protected function extractText(array $response): string
    {
        return $response['choices'][0]['message']['content'] ?? '';
    }

    protected function extractRisk(array $response): array
    {
        $content = $response['choices'][0]['message']['content'] ?? '';
        $decoded = json_decode($content, true);
        
        return [
            'risk_level' => $decoded['risk_level'] ?? 'low',
            'factors' => $decoded['factors'] ?? [],
        ];
    }
}

