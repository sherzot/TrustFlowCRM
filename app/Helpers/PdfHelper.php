<?php

namespace App\Helpers;

class PdfHelper
{
    /**
     * Matn ichida Yaponcha belgilar bor-yo'qligini tekshirish
     * 
     * @param string|array $text Tekshiriladigan matn yoki matnlar massivi
     * @return bool
     */
    public static function hasJapaneseCharacters($text): bool
    {
        if (is_array($text)) {
            $text = implode(' ', $text);
        }

        if (empty($text)) {
            return false;
        }

        // Yaponcha belgilar uchun Unicode range'lar:
        // Hiragana: \x{3040}-\x{309F}
        // Katakana: \x{30A0}-\x{30FF}
        // Kanji: \x{4E00}-\x{9FAF}
        // CJK Symbols: \x{3000}-\x{303F}
        $pattern = '/[\x{3040}-\x{309F}\x{30A0}-\x{30FF}\x{4E00}-\x{9FAF}\x{3000}-\x{303F}]/u';
        
        return (bool) preg_match($pattern, $text);
    }

    /**
     * Project yoki Contract ma'lumotlarida Yaponcha belgilar bor-yo'qligini tekshirish
     * 
     * @param mixed $model Project yoki Contract model
     * @return bool
     */
    public static function modelHasJapaneseCharacters($model): bool
    {
        $textFields = [];
        
        // Project uchun
        if (method_exists($model, 'getAttributes')) {
            $attributes = $model->getAttributes();
            $textFields[] = $attributes['name'] ?? '';
            $textFields[] = $attributes['description'] ?? '';
            
            // Account nomi
            if ($model->account) {
                $textFields[] = $model->account->name ?? '';
            }
            
            // Deal nomi
            if ($model->deal) {
                $textFields[] = $model->deal->name ?? '';
            }
            
            // Tasks
            if (method_exists($model, 'tasks') && $model->tasks) {
                foreach ($model->tasks as $task) {
                    $textFields[] = $task->title ?? '';
                    $textFields[] = $task->description ?? '';
                }
            }
        }
        
        // Contract uchun
        if (isset($model->title)) {
            $textFields[] = $model->title ?? '';
            $textFields[] = $model->content ?? '';
            
            if ($model->account) {
                $textFields[] = $model->account->name ?? '';
            }
        }
        
        return self::hasJapaneseCharacters($textFields);
    }

    /**
     * Locale va matn ichidagi Yaponcha belgilarga qarab font tanlash
     * 
     * @param string $locale Hozirgi locale
     * @param mixed $model Project yoki Contract model
     * @return string Font nomi
     */
    public static function getFontForLocale($locale, $model = null): string
    {
        // Agar locale Yapon tili bo'lsa yoki model'da Yaponcha belgilar bo'lsa
        if ($locale === 'ja' || ($model && self::modelHasJapaneseCharacters($model))) {
            return 'noto sans jp';
        }
        
        return 'dejavu sans';
    }
}

