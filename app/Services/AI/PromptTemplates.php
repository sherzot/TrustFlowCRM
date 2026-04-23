<?php

declare(strict_types=1);

namespace App\Services\AI;

/**
 * Multi-locale prompt templates for the TrustFlow CRM AI layer.
 *
 * Each helper returns a ready-to-send prompt string in the requested locale
 * (uz / en / ja). Locale defaults to the current application locale so that
 * AI-generated artefacts follow the active user's language preference.
 */
final class PromptTemplates
{
    /** Allowed locales. The first value is the fallback. */
    public const LOCALES = ['en', 'uz', 'ja'];

    public static function locale(?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();

        return in_array($locale, self::LOCALES, true) ? $locale : self::LOCALES[0];
    }

    public static function leadScoring(array $lead, ?string $locale = null): string
    {
        return match (self::locale($locale)) {
            'uz' => <<<PROMPT
Quyidagi lead haqidagi ma'lumotlarni tahlil qilib, 0 dan 100 gacha bo'lgan ballni bering.
Javobda FAQAT quyidagi JSON formati bo'lsin:
{"score": <0-100 integer>, "reason": "qisqa izoh"}

Kompaniya: {$lead['company']}
Sohasi: {$lead['industry']}
Manba: {$lead['source']}
Tavsif: {$lead['description']}
PROMPT,
            'ja' => <<<PROMPT
以下のリード情報を分析し、0〜100のスコアと短い理由を JSON で返してください。
必ず次の形式のみを返してください:
{"score": <0-100 integer>, "reason": "簡潔な理由"}

会社名: {$lead['company']}
業界: {$lead['industry']}
ソース: {$lead['source']}
説明: {$lead['description']}
PROMPT,
            default => <<<PROMPT
Analyze the following lead and assign a score from 0 to 100 with a short reason.
Reply ONLY with this JSON shape:
{"score": <0-100 integer>, "reason": "short reason"}

Company: {$lead['company']}
Industry: {$lead['industry']}
Source: {$lead['source']}
Description: {$lead['description']}
PROMPT,
        };
    }

    public static function dealPrediction(array $deal, ?string $locale = null): string
    {
        return match (self::locale($locale)) {
            'uz' => <<<PROMPT
Quyidagi deal ma'lumotlari asosida yutish ehtimolini bashorat qiling.
Javob faqat shu JSON bo'lsin:
{"score": <0-100>, "probability": <0-100>, "reason": "qisqa izoh"}

Deal: {$deal['name']}
Qiymat: {$deal['value']} {$deal['currency']}
Bosqich: {$deal['stage']}
Tavsif: {$deal['description']}
PROMPT,
            'ja' => <<<PROMPT
以下の取引情報から成功確率を予測してください。
必ず JSON のみで返答:
{"score": <0-100>, "probability": <0-100>, "reason": "簡潔な理由"}

取引名: {$deal['name']}
金額: {$deal['value']} {$deal['currency']}
ステージ: {$deal['stage']}
説明: {$deal['description']}
PROMPT,
            default => <<<PROMPT
Predict the win probability for this deal.
Reply with this JSON ONLY:
{"score": <0-100>, "probability": <0-100>, "reason": "short reason"}

Deal: {$deal['name']}
Value: {$deal['value']} {$deal['currency']}
Stage: {$deal['stage']}
Description: {$deal['description']}
PROMPT,
        };
    }

    public static function risk(array $deal, ?string $locale = null): string
    {
        return match (self::locale($locale)) {
            'uz' => <<<PROMPT
Quyidagi deal bo'yicha xavf omillarini tahlil qiling.
JSON qaytaring:
{"risk_level": "low|medium|high", "factors": ["omil 1", "omil 2"]}

Deal: {$deal['name']}
Qiymat: {$deal['value']}
Bosqich: {$deal['stage']}
Kutilayotgan close: {$deal['expected_close_date']}
PROMPT,
            'ja' => <<<PROMPT
以下の取引のリスク要因を分析し、JSON で返してください:
{"risk_level": "low|medium|high", "factors": ["要因1", "要因2"]}

取引名: {$deal['name']}
金額: {$deal['value']}
ステージ: {$deal['stage']}
クローズ予定: {$deal['expected_close_date']}
PROMPT,
            default => <<<PROMPT
Analyse risk factors for this deal and reply with JSON:
{"risk_level": "low|medium|high", "factors": ["factor 1", "factor 2"]}

Deal: {$deal['name']}
Value: {$deal['value']}
Stage: {$deal['stage']}
Expected close: {$deal['expected_close_date']}
PROMPT,
        };
    }

    public static function churn(array $account, ?string $locale = null): string
    {
        return match (self::locale($locale)) {
            'uz' => <<<PROMPT
Quyidagi mijoz uchun churn (ketish) xavfini baholang.
JSON qaytaring:
{"risk_level": "low|medium|high", "probability": <0-100>, "reason": "qisqa izoh"}

Mijoz: {$account['name']}
Soha: {$account['industry']}
Status: {$account['status']}
Oxirgi faoliyat: {$account['updated_at']}
PROMPT,
            'ja' => <<<PROMPT
以下のアカウントの顧客離脱リスクを評価してください。JSON で返答:
{"risk_level": "low|medium|high", "probability": <0-100>, "reason": "簡潔な理由"}

アカウント: {$account['name']}
業界: {$account['industry']}
ステータス: {$account['status']}
最終活動日: {$account['updated_at']}
PROMPT,
            default => <<<PROMPT
Evaluate churn risk for this account and reply with JSON:
{"risk_level": "low|medium|high", "probability": <0-100>, "reason": "short reason"}

Account: {$account['name']}
Industry: {$account['industry']}
Status: {$account['status']}
Last activity: {$account['updated_at']}
PROMPT,
        };
    }

    public static function email(string $context, string $tone, ?string $locale = null): string
    {
        return match (self::locale($locale)) {
            'uz' => "Quyidagi kontekst asosida '{$tone}' tonda professional email yozing. Javob sof email matni bo'lsin.\n\nKontekst:\n{$context}",
            'ja' => "以下のコンテキストに基づき、{$tone} なトーンでプロフェッショナルなメールを作成してください。出力はメール本文のみ。\n\nコンテキスト:\n{$context}",
            default => "Write a professional email in a '{$tone}' tone based on the context below. Return ONLY the email body.\n\nContext:\n{$context}",
        };
    }

    public static function nlp(string $question, array $context, ?string $locale = null): string
    {
        $ctx = implode("\n", $context);

        return match (self::locale($locale)) {
            'uz' => "Quyidagi ma'lumotlarga tayangan holda savolga javob bering. Javob qisqa va aniq bo'lsin.\n\nKontekst:\n{$ctx}\n\nSavol: {$question}",
            'ja' => "以下の情報に基づいて、質問に簡潔かつ正確に答えてください。\n\n情報:\n{$ctx}\n\n質問: {$question}",
            default => "Answer the question using the context below. Be concise and accurate.\n\nContext:\n{$ctx}\n\nQuestion: {$question}",
        };
    }
}
