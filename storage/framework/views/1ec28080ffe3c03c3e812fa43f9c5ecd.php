<!DOCTYPE html>
<html lang="<?php echo e($locale ?? app()->getLocale()); ?>" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($translations['invoice'] ?? __('filament.invoice')); ?> - <?php echo e($invoice->invoice_number); ?></title>
    <style>
        <?php
            // Locale'ni to'g'ri o'rnatish
            $locale = $locale ?? app()->getLocale();
            app()->setLocale($locale);
            app('translator')->setLocale($locale);
            
            // Translation'lar avtomatik yuklanadi, cache'ni tozalash shart emas
            
            // Matn ichida Yaponcha belgilar bor-yo'qligini tekshirish
            $hasJapanese = $hasJapanese ?? \App\Helpers\PdfHelper::modelHasJapaneseCharacters($invoice);
            
            // Translation key'lar controllerdan keladi, bu yerda faqat tekshirish
            // $translations variable controllerdan keladi
        ?>
        
        
        @font-face {
            font-family: 'DejaVu Sans';
            font-style: normal;
            font-weight: normal;
            src: url('<?php echo e(storage_path('fonts/DejaVuSans.ttf')); ?>') format('truetype');
        }
        @font-face {
            font-family: 'DejaVu Sans';
            font-style: normal;
            font-weight: bold;
            src: url('<?php echo e(storage_path('fonts/DejaVuSans-Bold.ttf')); ?>') format('truetype');
        }
        
        <?php if($locale === 'ja' || $hasJapanese): ?>
        
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
            font-family: 'Noto Sans JP', 'DejaVu Sans', 'DejaVu Sans Unicode', 'Hiragino Kaku Gothic ProN', 'Hiragino Sans', 'Meiryo', 'MS PGothic', sans-serif !important;
        }
        body {
            font-family: 'Noto Sans JP', 'DejaVu Sans', 'DejaVu Sans Unicode', 'Hiragino Kaku Gothic ProN', 'Hiragino Sans', 'Meiryo', 'MS PGothic', sans-serif;
        }
        <?php else: ?>
        
        * {
            font-family: 'DejaVu Sans', 'DejaVu Sans Unicode', sans-serif !important;
        }
        body {
            font-family: 'DejaVu Sans', 'DejaVu Sans Unicode', sans-serif;
        }
        <?php endif; ?>
        
        
        h1, h2, h3, h4, h5, h6 {
            <?php if($locale === 'ja' || $hasJapanese): ?>
            font-family: 'Noto Sans JP', 'DejaVu Sans', 'DejaVu Sans Unicode', 'Hiragino Kaku Gothic ProN', 'Hiragino Sans', 'Meiryo', 'MS PGothic', sans-serif !important;
            <?php else: ?>
            font-family: 'DejaVu Sans', 'DejaVu Sans Unicode', sans-serif !important;
            <?php endif; ?>
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
            <?php if($locale === 'ja' || $hasJapanese): ?>
            font-family: 'Noto Sans JP', 'DejaVu Sans', 'DejaVu Sans Unicode', 'Hiragino Kaku Gothic ProN', 'Hiragino Sans', 'Meiryo', 'MS PGothic', sans-serif !important;
            <?php else: ?>
            font-family: 'DejaVu Sans', 'DejaVu Sans Unicode', sans-serif !important;
            <?php endif; ?>
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
        <h1><?php echo e($translations['invoice'] ?? __('filament.invoice')); ?></h1>
    </div>

    <div class="invoice-info">
        <div class="info-row">
            <div class="info-label"><?php echo e($translations['invoice_number'] ?? __('filament.invoice_number')); ?>:</div>
            <div class="info-value"><?php echo e($invoice->invoice_number); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label"><?php echo e($translations['account'] ?? __('filament.account')); ?>:</div>
            <div class="info-value"><?php echo e($invoice->account->name); ?></div>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($invoice->project): ?>
        <div class="info-row">
            <div class="info-label"><?php echo e($translations['project'] ?? __('filament.project')); ?>:</div>
            <div class="info-value"><?php echo e($invoice->project->name); ?></div>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <div class="info-row">
            <div class="info-label"><?php echo e($translations['issue_date'] ?? __('filament.issue_date')); ?>:</div>
            <div class="info-value"><?php echo e(\App\Helpers\DateHelper::formatDate($invoice->issue_date)); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label"><?php echo e($translations['due_date'] ?? __('filament.due_date')); ?>:</div>
            <div class="info-value"><?php echo e(\App\Helpers\DateHelper::formatDate($invoice->due_date)); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label"><?php echo e($translations['status'] ?? __('filament.status')); ?>:</div>
            <div class="info-value"><?php echo e(__('filament.' . $invoice->status)); ?></div>
        </div>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($invoice->items->count() > 0): ?>
    <div class="section">
        <h2><?php echo e($translations['items'] ?? __('filament.items')); ?></h2>
        <table class="items-table">
            <thead>
                <tr>
                    <th><?php echo e($translations['description'] ?? __('filament.description')); ?></th>
                    <th class="text-right"><?php echo e($translations['quantity'] ?? __('filament.quantity')); ?></th>
                    <th class="text-right"><?php echo e($translations['unit_price'] ?? __('filament.unit_price')); ?></th>
                    <th class="text-right"><?php echo e($translations['amount'] ?? __('filament.amount')); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $invoice->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($item->description); ?></td>
                    <td class="text-right"><?php echo e(number_format($item->quantity, 2)); ?></td>
                    <td class="text-right"><?php echo e(number_format($item->unit_price, 2)); ?> <?php echo e($invoice->currency); ?></td>
                    <td class="text-right"><?php echo e(number_format($item->total, 2)); ?> <?php echo e($invoice->currency); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="totals">
        <div class="total-row">
            <div class="total-label"><?php echo e($translations['subtotal'] ?? __('filament.subtotal')); ?>:</div>
            <div class="total-value"><?php echo e(number_format($invoice->subtotal, 2)); ?> <?php echo e($invoice->currency); ?></div>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($invoice->tax_rate > 0): ?>
        <div class="total-row">
            <div class="total-label"><?php echo e($translations['tax_rate'] ?? __('filament.tax_rate')); ?> (<?php echo e(number_format($invoice->tax_rate, 2)); ?>%):</div>
            <div class="total-value"><?php echo e(number_format($invoice->tax_amount, 2)); ?> <?php echo e($invoice->currency); ?></div>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <div class="total-row total-final">
            <div class="total-label"><?php echo e($translations['total'] ?? __('filament.total')); ?>:</div>
            <div class="total-value"><?php echo e(number_format($invoice->total, 2)); ?> <?php echo e($invoice->currency); ?></div>
        </div>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($invoice->notes): ?>
    <div class="notes">
        <h3><?php echo e($translations['notes'] ?? __('filament.notes')); ?></h3>
        <p><?php echo e($invoice->notes); ?></p>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="footer">
        <p><?php echo e($translations['generated_at'] ?? __('filament.generated_at')); ?>: <?php echo e(\App\Helpers\DateHelper::formatDateTime(now())); ?></p>
        <p><?php echo e(config('app.name')); ?> - <?php echo e($translations['invoice_document'] ?? __('filament.invoice_document')); ?></p>
    </div>
</body>
</html>

<?php /**PATH /var/www/html/resources/views/pdf/invoice.blade.php ENDPATH**/ ?>