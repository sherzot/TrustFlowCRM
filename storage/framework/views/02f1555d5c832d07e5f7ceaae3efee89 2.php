<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(__('filament.contract')); ?> - <?php echo e($contract->contract_number); ?></title>
    <style>
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
        * {
            font-family: 'DejaVu Sans', 'DejaVu Sans Unicode', sans-serif !important;
        }
        body {
            font-family: 'DejaVu Sans', 'DejaVu Sans Unicode', sans-serif;
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
        <h1><?php echo e(__('filament.contract')); ?></h1>
    </div>

    <div class="contract-info">
        <div class="info-row">
            <div class="info-label"><?php echo e(__('filament.contract_number')); ?>:</div>
            <div class="info-value"><?php echo e($contract->contract_number); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label"><?php echo e(__('filament.title')); ?>:</div>
            <div class="info-value"><?php echo e($contract->title); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label"><?php echo e(__('filament.account')); ?>:</div>
            <div class="info-value"><?php echo e($contract->account->name); ?></div>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($contract->deal): ?>
        <div class="info-row">
            <div class="info-label"><?php echo e(__('filament.deal')); ?>:</div>
            <div class="info-value"><?php echo e($contract->deal->name); ?></div>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($contract->project): ?>
        <div class="info-row">
            <div class="info-label"><?php echo e(__('filament.project')); ?>:</div>
            <div class="info-value"><?php echo e($contract->project->name); ?></div>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <div class="info-row">
            <div class="info-label"><?php echo e(__('filament.status')); ?>:</div>
            <div class="info-value"><?php echo e(__('filament.' . $contract->status)); ?></div>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($contract->signed_at): ?>
        <div class="info-row">
            <div class="info-label"><?php echo e(__('filament.signed_at')); ?>:</div>
            <div class="info-value"><?php echo e($contract->signed_at ? \App\Helpers\DateHelper::formatDateTime($contract->signed_at) : '-'); ?></div>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($contract->signed_by): ?>
        <div class="info-row">
            <div class="info-label"><?php echo e(__('filament.signed_by')); ?>:</div>
            <div class="info-value"><?php echo e($contract->signed_by); ?></div>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <div class="content">
        <h2><?php echo e(__('filament.content')); ?></h2>
        <?php echo $contract->content; ?>

    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($contract->status === 'signed' && isset($contract->signature_data) && $contract->signature_data): ?>
    <div class="signature-section">
        <h3><?php echo e(__('filament.signature')); ?></h3>
        <div class="signature-box">
            <img src="data:image/png;base64,<?php echo e($contract->signature_data); ?>" alt="Signature" style="max-width: 300px;" />
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="footer">
        <p><?php echo e(__('filament.generated_at')); ?>: <?php echo e(\App\Helpers\DateHelper::formatDateTime(now())); ?></p>
        <p><?php echo e(config('app.name')); ?> - <?php echo e(__('filament.contract_document')); ?></p>
    </div>
</body>
</html>
<?php /**PATH /var/www/html/resources/views/pdf/contract.blade.php ENDPATH**/ ?>