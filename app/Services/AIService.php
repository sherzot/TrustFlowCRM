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

    /**
     * Churn detection - Mijoz ketish xavfini aniqlash
     */
    public function detectChurn($account): array
    {
        try {
            $prompt = $this->buildChurnDetectionPrompt($account);
            $response = $this->callOpenAI($prompt);
            
            return $this->extractChurn($response);
        } catch (\Exception $e) {
            Log::error('AI Churn Detection Error: ' . $e->getMessage());
            return ['risk_level' => 'low', 'probability' => 0];
        }
    }

    /**
     * Deal delay prediction - Deal kechikish ehtimolini bashorat qilish
     */
    public function predictDealDelay(Deal $deal): array
    {
        try {
            $prompt = $this->buildDealDelayPrompt($deal);
            $response = $this->callOpenAI($prompt);
            
            return $this->extractDelay($response);
        } catch (\Exception $e) {
            Log::error('AI Deal Delay Prediction Error: ' . $e->getMessage());
            return ['delay_probability' => 0, 'estimated_delay_days' => 0];
        }
    }

    /**
     * Email/Proposal template suggestions - Shablon takliflari
     */
    public function suggestEmailTemplate(string $context, string $type = 'email'): array
    {
        try {
            $prompt = $this->buildTemplateSuggestionPrompt($context, $type);
            $response = $this->callOpenAI($prompt);
            
            return $this->extractTemplates($response);
        } catch (\Exception $e) {
            Log::error('AI Template Suggestion Error: ' . $e->getMessage());
            return ['templates' => []];
        }
    }

    /**
     * Task prioritization - Vazifalarni prioritetlash
     */
    public function prioritizeTasks(array $tasks, array $context = []): array
    {
        try {
            $prompt = $this->buildTaskPrioritizationPrompt($tasks, $context);
            $response = $this->callOpenAI($prompt);
            
            return $this->extractPriorities($response);
        } catch (\Exception $e) {
            Log::error('AI Task Prioritization Error: ' . $e->getMessage());
            return ['priorities' => []];
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

    protected function buildChurnDetectionPrompt($account): string
    {
        return "以下のアカウント情報を分析し、顧客離脱リスクを評価してください:\n\n" .
               "アカウント名: {$account->name}\n" .
               "業界: {$account->industry}\n" .
               "ステータス: {$account->status}\n" .
               "最終活動日: {$account->updated_at}\n\n" .
               "リスクレベル(low/medium/high)と確率(0-100%)をJSON形式で返してください。";
    }

    protected function buildDealDelayPrompt(Deal $deal): string
    {
        $daysUntilClose = $deal->expected_close_date 
            ? now()->diffInDays($deal->expected_close_date, false) 
            : 0;
        
        return "以下の取引情報を分析し、遅延の可能性を予測してください:\n\n" .
               "取引名: {$deal->name}\n" .
               "ステージ: {$deal->stage}\n" .
               "期待クローズ日: {$deal->expected_close_date}\n" .
               "現在日からの日数: {$daysUntilClose}\n" .
               "確率: {$deal->probability}%\n\n" .
               "遅延確率(0-100%)と推定遅延日数をJSON形式で返してください。";
    }

    protected function buildTemplateSuggestionPrompt(string $context, string $type): string
    {
        $typeText = $type === 'proposal' ? '提案書' : 'メール';
        return "以下のコンテキストに基づいて、{$typeText}のテンプレートを3つ提案してください:\n\n" .
               "コンテキスト: {$context}\n\n" .
               "各テンプレートにタイトル、トーン、主要ポイントを含めてJSON形式で返してください。";
    }

    protected function buildTaskPrioritizationPrompt(array $tasks, array $context): string
    {
        $tasksText = json_encode($tasks, JSON_UNESCAPED_UNICODE);
        $contextText = implode("\n", $context);
        
        return "以下のタスクリストを分析し、優先順位を付けてください:\n\n" .
               "タスク: {$tasksText}\n" .
               "コンテキスト: {$contextText}\n\n" .
               "各タスクに優先度(urgent/high/medium/low)と理由を含めてJSON形式で返してください。";
    }

    protected function extractChurn(array $response): array
    {
        $content = $response['choices'][0]['message']['content'] ?? '';
        $decoded = json_decode($content, true);
        
        return [
            'risk_level' => $decoded['risk_level'] ?? 'low',
            'probability' => $decoded['probability'] ?? 0,
        ];
    }

    protected function extractDelay(array $response): array
    {
        $content = $response['choices'][0]['message']['content'] ?? '';
        $decoded = json_decode($content, true);
        
        return [
            'delay_probability' => $decoded['delay_probability'] ?? 0,
            'estimated_delay_days' => $decoded['estimated_delay_days'] ?? 0,
        ];
    }

    protected function extractTemplates(array $response): array
    {
        $content = $response['choices'][0]['message']['content'] ?? '';
        $decoded = json_decode($content, true);
        
        return [
            'templates' => $decoded['templates'] ?? [],
        ];
    }

    protected function extractPriorities(array $response): array
    {
        $content = $response['choices'][0]['message']['content'] ?? '';
        $decoded = json_decode($content, true);
        
        return [
            'priorities' => $decoded['priorities'] ?? [],
        ];
    }
}

