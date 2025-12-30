<!DOCTYPE html>
<html lang="{{ $locale ?? app()->getLocale() }}" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $translations['invoice'] ?? __('filament.invoice') }} - {{ $invoice->invoice_number }}</title>
    <style>
        @php
            // Locale'ni to'g'ri o'rnatish
            $locale = $locale ?? app()->getLocale();
            app()->setLocale($locale);
            app('translator')->setLocale($locale);
            
            // Translation'lar avtomatik yuklanadi, cache'ni tozalash shart emas
            
            // Matn ichida Yaponcha belgilar bor-yo'qligini tekshirish
            $hasJapanese = $hasJapanese ?? \App\Helpers\PdfHelper::modelHasJapaneseCharacters($invoice);
            
            // Translation key'lar controllerdan keladi, bu yerda faqat tekshirish
            // $translations variable controllerdan keladi
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
        .invoice-info {
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
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .items-table th,
        .items-table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .items-table th {
            background-color: #f59e0b;
            color: white;
            font-weight: bold;
        }
        .items-table td {
            background-color: #fff;
        }
        .items-table .text-right {
            text-align: right;
        }
        .totals {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid #ddd;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 5px 0;
        }
        .total-label {
            font-weight: bold;
        }
        .total-value {
            font-weight: bold;
            font-size: 14px;
        }
        .total-final {
            font-size: 16px;
            color: #f59e0b;
        }
        .notes {
            margin-top: 30px;
            padding: 15px;
            background-color: #f9f9f9;
            border-left: 4px solid #f59e0b;
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
        <h1>{{ $translations['invoice'] ?? __('filament.invoice') }}</h1>
    </div>

    <div class="invoice-info">
        <div class="info-row">
            <div class="info-label">{{ $translations['invoice_number'] ?? __('filament.invoice_number') }}:</div>
            <div class="info-value">{{ $invoice->invoice_number }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">{{ $translations['account'] ?? __('filament.account') }}:</div>
            <div class="info-value">{{ $invoice->account->name }}</div>
        </div>
        @if($invoice->project)
        <div class="info-row">
            <div class="info-label">{{ $translations['project'] ?? __('filament.project') }}:</div>
            <div class="info-value">{{ $invoice->project->name }}</div>
        </div>
        @endif
        <div class="info-row">
            <div class="info-label">{{ $translations['issue_date'] ?? __('filament.issue_date') }}:</div>
            <div class="info-value">{{ \App\Helpers\DateHelper::formatDate($invoice->issue_date) }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">{{ $translations['due_date'] ?? __('filament.due_date') }}:</div>
            <div class="info-value">{{ \App\Helpers\DateHelper::formatDate($invoice->due_date) }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">{{ $translations['status'] ?? __('filament.status') }}:</div>
            <div class="info-value">{{ __('filament.' . $invoice->status) }}</div>
        </div>
    </div>

    @if($invoice->items->count() > 0)
    <div class="section">
        <h2>{{ $translations['items'] ?? __('filament.items') }}</h2>
        <table class="items-table">
            <thead>
                <tr>
                    <th>{{ $translations['description'] ?? __('filament.description') }}</th>
                    <th class="text-right">{{ $translations['quantity'] ?? __('filament.quantity') }}</th>
                    <th class="text-right">{{ $translations['unit_price'] ?? __('filament.unit_price') }}</th>
                    <th class="text-right">{{ $translations['amount'] ?? __('filament.amount') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->items as $item)
                <tr>
                    <td>{{ $item->description }}</td>
                    <td class="text-right">{{ number_format($item->quantity, 2) }}</td>
                    <td class="text-right">{{ number_format($item->unit_price, 2) }} {{ $invoice->currency }}</td>
                    <td class="text-right">{{ number_format($item->total, 2) }} {{ $invoice->currency }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <div class="totals">
        <div class="total-row">
            <div class="total-label">{{ $translations['subtotal'] ?? __('filament.subtotal') }}:</div>
            <div class="total-value">{{ number_format($invoice->subtotal, 2) }} {{ $invoice->currency }}</div>
        </div>
        @if($invoice->tax_rate > 0)
        <div class="total-row">
            <div class="total-label">{{ $translations['tax_rate'] ?? __('filament.tax_rate') }} ({{ number_format($invoice->tax_rate, 2) }}%):</div>
            <div class="total-value">{{ number_format($invoice->tax_amount, 2) }} {{ $invoice->currency }}</div>
        </div>
        @endif
        <div class="total-row total-final">
            <div class="total-label">{{ $translations['total'] ?? __('filament.total') }}:</div>
            <div class="total-value">{{ number_format($invoice->total, 2) }} {{ $invoice->currency }}</div>
        </div>
    </div>

    @if($invoice->notes)
    <div class="notes">
        <h3>{{ $translations['notes'] ?? __('filament.notes') }}</h3>
        <p>{{ $invoice->notes }}</p>
    </div>
    @endif

    <div class="footer">
        <p>{{ $translations['generated_at'] ?? __('filament.generated_at') }}: {{ \App\Helpers\DateHelper::formatDateTime(now()) }}</p>
        <p>{{ config('app.name') }} - {{ $translations['invoice_document'] ?? __('filament.invoice_document') }}</p>
    </div>
</body>
</html>

