<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('filament.contract') }} - {{ $contract->contract_number }}</title>
    <style>
        @php
            // Locale'ni to'g'ri o'rnatish
            $locale = $locale ?? app()->getLocale();
            app()->setLocale($locale);
            app('translator')->setLocale($locale);
            
            // Translation cache'ni tozalash
            if (method_exists(app('translator'), 'getLoader')) {
                app('translator')->getLoader()->flushCache();
            }
            
            // Matn ichida Yaponcha belgilar bor-yo'qligini tekshirish
            $hasJapanese = $hasJapanese ?? \App\Helpers\PdfHelper::modelHasJapaneseCharacters($contract);
            
            // Translation key'larni oldindan yuklash
            $translations = [
                'contract' => __('filament.contract'),
                'contract_number' => __('filament.contract_number'),
                'title' => __('filament.title'),
                'account' => __('filament.account'),
                'deal' => __('filament.deal'),
                'project' => __('filament.project'),
                'status' => __('filament.status'),
                'signed_at' => __('filament.signed_at'),
                'signed_by' => __('filament.signed_by'),
                'content' => __('filament.content'),
                'signature' => __('filament.signature'),
                'generated_at' => __('filament.generated_at'),
                'contract_document' => __('filament.contract_document'),
            ];
        @endphp
        
        {{-- Har doim ikkala fontni ham yuklash --}}
        @font-face {
            font-family: 'DejaVu Sans';
            font-style: normal;
            font-weight: normal;
            src: url('{{ storage_path('fonts/DejaVuSans.ttf') }}') format('truetype');
        }
        @font-face {
            font-family: 'DejaVu Sans';
            font-style: normal;
            font-weight: bold;
            src: url('{{ storage_path('fonts/DejaVuSans-Bold.ttf') }}') format('truetype');
        }
        
        @if($locale === 'ja' || $hasJapanese)
        {{-- Yapon tili uchun Noto Sans JP font --}}
        @font-face {
            font-family: 'Noto Sans JP';
            font-style: normal;
            font-weight: normal;
            src: url('https://fonts.gstatic.com/s/notosansjp/v52/-F6jfjtqLzI2JPCgQBnw7HFyzSD-AsregP8VFBEj75s.ttf') format('truetype');
        }
        @font-face {
            font-family: 'Noto Sans JP';
            font-style: normal;
            font-weight: bold;
            src: url('https://fonts.gstatic.com/s/notosansjp/v52/-F6kfjtqLzI2JPCgQBnw7HFyzSD-AsregP8VFBEj75s.ttf') format('truetype');
        }
        {{-- Yaponcha va boshqa tillar uchun fallback fontlar --}}
        * {
            font-family: 'Noto Sans JP', 'DejaVu Sans', 'DejaVu Sans Unicode', 'Hiragino Kaku Gothic ProN', 'Hiragino Sans', 'Meiryo', 'MS PGothic', sans-serif !important;
        }
        body {
            font-family: 'Noto Sans JP', 'DejaVu Sans', 'DejaVu Sans Unicode', 'Hiragino Kaku Gothic ProN', 'Hiragino Sans', 'Meiryo', 'MS PGothic', sans-serif;
        }
        @else
        {{-- Boshqa tillar uchun DejaVu Sans --}}
        * {
            font-family: 'DejaVu Sans', 'DejaVu Sans Unicode', sans-serif !important;
        }
        body {
            font-family: 'DejaVu Sans', 'DejaVu Sans Unicode', sans-serif;
        }
        @endif
        
        {{-- Har doim barcha heading elementlar uchun font-family --}}
        h1, h2, h3, h4, h5, h6 {
            @if($locale === 'ja' || $hasJapanese)
            font-family: 'Noto Sans JP', 'DejaVu Sans', 'DejaVu Sans Unicode', 'Hiragino Kaku Gothic ProN', 'Hiragino Sans', 'Meiryo', 'MS PGothic', sans-serif !important;
            @else
            font-family: 'DejaVu Sans', 'DejaVu Sans Unicode', sans-serif !important;
            @endif
        }
        
        body {
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            border-bottom: 3px solid #f59e0b;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #f59e0b;
            margin: 0;
            font-size: 24px;
            @if($locale === 'ja' || $hasJapanese)
            font-family: 'Noto Sans JP', 'DejaVu Sans', 'DejaVu Sans Unicode', 'Hiragino Kaku Gothic ProN', 'Hiragino Sans', 'Meiryo', 'MS PGothic', sans-serif !important;
            @else
            font-family: 'DejaVu Sans', 'DejaVu Sans Unicode', sans-serif !important;
            @endif
        }
        .contract-info {
            margin-bottom: 30px;
        }
        .info-row {
            display: flex;
            margin-bottom: 10px;
        }
        .info-label {
            font-weight: bold;
            width: 150px;
        }
        .info-value {
            flex: 1;
        }
        .content {
            margin-top: 30px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .signature-section {
            margin-top: 50px;
            padding-top: 30px;
            border-top: 2px solid #ddd;
        }
        .signature-box {
            margin-top: 20px;
            min-height: 80px;
        }
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{!! htmlspecialchars($translations['contract'], ENT_QUOTES, 'UTF-8') !!}</h1>
    </div>

    <div class="contract-info">
        <div class="info-row">
            <div class="info-label">{!! htmlspecialchars($translations['contract_number'], ENT_QUOTES, 'UTF-8') !!}:</div>
            <div class="info-value">{{ $contract->contract_number }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">{!! htmlspecialchars($translations['title'], ENT_QUOTES, 'UTF-8') !!}:</div>
            <div class="info-value">{{ $contract->title }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">{!! htmlspecialchars($translations['account'], ENT_QUOTES, 'UTF-8') !!}:</div>
            <div class="info-value">{{ $contract->account->name }}</div>
        </div>
        @if($contract->deal)
        <div class="info-row">
            <div class="info-label">{!! htmlspecialchars($translations['deal'], ENT_QUOTES, 'UTF-8') !!}:</div>
            <div class="info-value">{{ $contract->deal->name }}</div>
        </div>
        @endif
        @if($contract->project)
        <div class="info-row">
            <div class="info-label">{!! htmlspecialchars($translations['project'], ENT_QUOTES, 'UTF-8') !!}:</div>
            <div class="info-value">{{ $contract->project->name }}</div>
        </div>
        @endif
        <div class="info-row">
            <div class="info-label">{!! htmlspecialchars($translations['status'], ENT_QUOTES, 'UTF-8') !!}:</div>
            <div class="info-value">{{ __('filament.' . $contract->status) }}</div>
        </div>
        @if($contract->signed_at)
        <div class="info-row">
            <div class="info-label">{!! htmlspecialchars($translations['signed_at'], ENT_QUOTES, 'UTF-8') !!}:</div>
            <div class="info-value">{{ $contract->signed_at ? \App\Helpers\DateHelper::formatDateTime($contract->signed_at) : '-' }}</div>
        </div>
        @if($contract->signed_by)
        <div class="info-row">
            <div class="info-label">{!! htmlspecialchars($translations['signed_by'], ENT_QUOTES, 'UTF-8') !!}:</div>
            <div class="info-value">{{ $contract->signed_by }}</div>
        </div>
        @endif
        @endif
    </div>

    <div class="content">
        <h2>{!! htmlspecialchars($translations['content'], ENT_QUOTES, 'UTF-8') !!}</h2>
        {!! $contract->content !!}
    </div>

    @if($contract->status === 'signed' && isset($contract->signature_data) && $contract->signature_data)
    <div class="signature-section">
        <h3>{!! htmlspecialchars($translations['signature'], ENT_QUOTES, 'UTF-8') !!}</h3>
        <div class="signature-box">
            <img src="data:image/png;base64,{{ $contract->signature_data }}" alt="Signature" style="max-width: 300px;" />
        </div>
    </div>
    @endif

    <div class="footer">
        <p>{!! htmlspecialchars($translations['generated_at'], ENT_QUOTES, 'UTF-8') !!}: {{ \App\Helpers\DateHelper::formatDateTime(now()) }}</p>
        <p>{{ config('app.name') }} - {!! htmlspecialchars($translations['contract_document'], ENT_QUOTES, 'UTF-8') !!}</p>
    </div>
</body>
</html>
