<!DOCTYPE html>
<html lang="<?php echo e($locale ?? app()->getLocale()); ?>" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($translations['project'] ?? __('filament.project')); ?> - <?php echo e($project->name); ?></title>
    <style>
        <?php
            // Locale'ni to'g'ri o'rnatish
            $locale = $locale ?? app()->getLocale();
            app()->setLocale($locale);
            app('translator')->setLocale($locale);
            
            // Translation'lar avtomatik yuklanadi, cache'ni tozalash shart emas
            
            // Matn ichida Yaponcha belgilar bor-yo'qligini tekshirish
            $hasJapanese = $hasJapanese ?? \App\Helpers\PdfHelper::modelHasJapaneseCharacters($project);
            
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
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Noto Sans JP', 'DejaVu Sans', 'DejaVu Sans Unicode', 'Hiragino Kaku Gothic ProN', 'Hiragino Sans', 'Meiryo', 'MS PGothic', sans-serif !important;
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
        .project-info {
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
        .section {
            margin-top: 30px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .section h2 {
            margin-top: 0;
            color: #f59e0b;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-top: 20px;
        }
        .stat-box {
            padding: 15px;
            background-color: white;
            border-radius: 5px;
            border-left: 4px solid #f59e0b;
        }
        .stat-label {
            font-size: 10px;
            color: #666;
            text-transform: uppercase;
        }
        .stat-value {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin-top: 5px;
        }
        .tasks-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .tasks-table th,
        .tasks-table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .tasks-table th {
            background-color: #f59e0b;
            color: white;
            font-weight: bold;
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
        <h1><?php echo e($translations['project']); ?></h1>
    </div>

    <div class="project-info">
        <div class="info-row">
            <div class="info-label"><?php echo e($translations['name']); ?>:</div>
            <div class="info-value"><?php echo e($project->name); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label"><?php echo e($translations['account']); ?>:</div>
            <div class="info-value"><?php echo e($project->account->name); ?></div>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($project->deal): ?>
        <div class="info-row">
            <div class="info-label"><?php echo e($translations['deal']); ?>:</div>
            <div class="info-value"><?php echo e($project->deal->name); ?></div>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <div class="info-row">
            <div class="info-label"><?php echo e($translations['status']); ?>:</div>
            <div class="info-value"><?php echo e(__('filament.' . $project->status)); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label"><?php echo e($translations['start_date']); ?>:</div>
            <div class="info-value"><?php echo e(\App\Helpers\DateHelper::formatDate($project->start_date)); ?></div>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($project->end_date): ?>
        <div class="info-row">
            <div class="info-label"><?php echo e($translations['end_date']); ?>:</div>
            <div class="info-value"><?php echo e(\App\Helpers\DateHelper::formatDate($project->end_date)); ?></div>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <div class="section">
        <h2><?php echo e($translations['description']); ?></h2>
        <p><?php echo e($project->description ?? $translations['no_description']); ?></p>
    </div>

    <div class="section">
        <h2><?php echo e($translations['project_statistics']); ?></h2>
        <div class="stats-grid">
            <div class="stat-box">
                <div class="stat-label"><?php echo e($translations['budget']); ?></div>
                <div class="stat-value"><?php echo e(number_format($project->budget ?? 0, 2)); ?> <?php echo e($project->currency ?? 'USD'); ?></div>
            </div>
            <div class="stat-box">
                <div class="stat-label"><?php echo e($translations['actual_cost']); ?></div>
                <div class="stat-value"><?php echo e(number_format($project->actual_cost ?? 0, 2)); ?> <?php echo e($project->currency ?? 'USD'); ?></div>
            </div>
            <div class="stat-box">
                <div class="stat-label"><?php echo e($translations['profit']); ?></div>
                <div class="stat-value"><?php echo e(number_format($project->profit ?? 0, 2)); ?> <?php echo e($project->currency ?? 'USD'); ?></div>
            </div>
            <div class="stat-box">
                <div class="stat-label"><?php echo e($translations['progress']); ?></div>
                <div class="stat-value"><?php echo e($project->progress ?? 0); ?>%</div>
            </div>
        </div>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($project->tasks->count() > 0): ?>
    <div class="section">
        <h2><?php echo e($translations['tasks']); ?> (<?php echo e($project->tasks->count()); ?>)</h2>
        <table class="tasks-table">
            <thead>
                <tr>
                    <th><?php echo e($translations['title']); ?></th>
                    <th><?php echo e($translations['status']); ?></th>
                    <th><?php echo e($translations['priority']); ?></th>
                    <th><?php echo e($translations['due_date']); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $project->tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($task->title); ?></td>
                    <td><?php echo e(__('filament.' . $task->status)); ?></td>
                    <td><?php echo e(__('filament.' . $task->priority)); ?></td>
                    <td><?php echo e($task->due_date ? \App\Helpers\DateHelper::formatDate($task->due_date) : '-'); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="footer">
        <p><?php echo e($translations['generated_at']); ?>: <?php echo e(\App\Helpers\DateHelper::formatDateTime(now())); ?></p>
        <p><?php echo e(config('app.name')); ?> - <?php echo e($translations['project_report']); ?></p>
    </div>
</body>
</html>
<?php /**PATH /var/www/html/resources/views/pdf/project.blade.php ENDPATH**/ ?>