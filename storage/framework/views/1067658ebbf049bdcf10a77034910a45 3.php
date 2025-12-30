<div>
    <?php if (isset($component)) { $__componentOriginal166a02a7c5ef5a9331faf66fa665c256 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.page.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::page'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
        <div class="space-y-6">
            <div>
                <h2 class="text-2xl font-bold"><?php echo e(__('言語設定', [], 'ja')); ?></h2>
                <p class="text-gray-600 dark:text-gray-400 mt-2"><?php echo e(__('現在の言語を選択してください', [], 'ja')); ?></p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="p-6 border rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 cursor-pointer <?php echo e(app()->getLocale() === 'ja' ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/20' : ''); ?>"
                    wire:click="switchLocale('ja')">
                    <div class="text-2xl mb-2">🇯🇵</div>
                    <h3 class="font-semibold text-lg">日本語</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Japanese</p>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(app()->getLocale() === 'ja'): ?>
                        <span class="inline-block mt-2 px-2 py-1 text-xs bg-primary-500 text-white rounded">現在の言語</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div class="p-6 border rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 cursor-pointer <?php echo e(app()->getLocale() === 'en' ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/20' : ''); ?>"
                    wire:click="switchLocale('en')">
                    <div class="text-2xl mb-2">🇬🇧</div>
                    <h3 class="font-semibold text-lg">English</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">英語</p>
                    <?php if(app()->getLocale() === 'en'): ?>
                        <span class="inline-block mt-2 px-2 py-1 text-xs bg-primary-500 text-white rounded">Current
                            Language</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div class="p-6 border rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 cursor-pointer <?php echo e(app()->getLocale() === 'ru' ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/20' : ''); ?>"
                    wire:click="switchLocale('ru')">
                    <div class="text-2xl mb-2">🇷🇺</div>
                    <h3 class="font-semibold text-lg">Русский</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">ロシア語</p>
                    <?php if(app()->getLocale() === 'ru'): ?>
                        <span class="inline-block mt-2 px-2 py-1 text-xs bg-primary-500 text-white rounded">Текущий
                            язык</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                <p class="text-sm">
                    <strong><?php echo e(__('現在の言語', [], 'ja')); ?>:</strong>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(app()->getLocale() === 'ja'): ?>
                        日本語
                    <?php elseif(app()->getLocale() === 'en'): ?>
                        English
                    <?php elseif(app()->getLocale() === 'ru'): ?>
                        Русский
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </p>
            </div>
        </div>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $attributes = $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $component = $__componentOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?>
</div>
<?php /**PATH /var/www/html/resources/views/filament/pages/locale-switcher.blade.php ENDPATH**/ ?>