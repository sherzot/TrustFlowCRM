<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('filament.contract') }} - {{ $contract->contract_number }}</title>
    <style>
        @php
            $locale = app()->getLocale();
        @endphp
        
        @if($locale === 'ja')
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
        * {
            font-family: 'Noto Sans JP', 'Hiragino Kaku Gothic ProN', 'Hiragino Sans', 'Meiryo', 'MS PGothic', sans-serif !important;
        }
        body {
            font-family: 'Noto Sans JP', 'Hiragino Kaku Gothic ProN', 'Hiragino Sans', 'Meiryo', 'MS PGothic', sans-serif;
        }
        @else
        {{-- Boshqa tillar uchun DejaVu Sans --}}
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
        * {
            font-family: 'DejaVu Sans', 'DejaVu Sans Unicode', sans-serif !important;
        }
        body {
            font-family: 'DejaVu Sans', 'DejaVu Sans Unicode', sans-serif;
        }
        @endif
        
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
        <h1>{{ __('filament.contract') }}</h1>
    </div>

    <div class="contract-info">
        <div class="info-row">
            <div class="info-label">{{ __('filament.contract_number') }}:</div>
            <div class="info-value">{{ $contract->contract_number }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">{{ __('filament.title') }}:</div>
            <div class="info-value">{{ $contract->title }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">{{ __('filament.account') }}:</div>
            <div class="info-value">{{ $contract->account->name }}</div>
        </div>
        @if($contract->deal)
        <div class="info-row">
            <div class="info-label">{{ __('filament.deal') }}:</div>
            <div class="info-value">{{ $contract->deal->name }}</div>
        </div>
        @endif
        @if($contract->project)
        <div class="info-row">
            <div class="info-label">{{ __('filament.project') }}:</div>
            <div class="info-value">{{ $contract->project->name }}</div>
        </div>
        @endif
        <div class="info-row">
            <div class="info-label">{{ __('filament.status') }}:</div>
            <div class="info-value">{{ __('filament.' . $contract->status) }}</div>
        </div>
        @if($contract->signed_at)
        <div class="info-row">
            <div class="info-label">{{ __('filament.signed_at') }}:</div>
            <div class="info-value">{{ $contract->signed_at ? \App\Helpers\DateHelper::formatDateTime($contract->signed_at) : '-' }}</div>
        </div>
        @if($contract->signed_by)
        <div class="info-row">
            <div class="info-label">{{ __('filament.signed_by') }}:</div>
            <div class="info-value">{{ $contract->signed_by }}</div>
        </div>
        @endif
        @endif
    </div>

    <div class="content">
        <h2>{{ __('filament.content') }}</h2>
        {!! $contract->content !!}
    </div>

    @if($contract->status === 'signed' && isset($contract->signature_data) && $contract->signature_data)
    <div class="signature-section">
        <h3>{{ __('filament.signature') }}</h3>
        <div class="signature-box">
            <img src="data:image/png;base64,{{ $contract->signature_data }}" alt="Signature" style="max-width: 300px;" />
        </div>
    </div>
    @endif

    <div class="footer">
        <p>{{ __('filament.generated_at') }}: {{ \App\Helpers\DateHelper::formatDateTime(now()) }}</p>
        <p>{{ config('app.name') }} - {{ __('filament.contract_document') }}</p>
    </div>
</body>
</html>
