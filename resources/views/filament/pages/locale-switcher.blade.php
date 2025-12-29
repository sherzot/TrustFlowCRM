<div>
    <x-filament-panels::page>
        <div class="space-y-6">
            <div>
                <h2 class="text-2xl font-bold">{{ __('言語設定', [], 'ja') }}</h2>
                <p class="text-gray-600 dark:text-gray-400 mt-2">{{ __('現在の言語を選択してください', [], 'ja') }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="p-6 border rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 cursor-pointer {{ app()->getLocale() === 'ja' ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/20' : '' }}"
                    wire:click="switchLocale('ja')">
                    <div class="text-2xl mb-2">🇯🇵</div>
                    <h3 class="font-semibold text-lg">日本語</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Japanese</p>
                    @if (app()->getLocale() === 'ja')
                        <span class="inline-block mt-2 px-2 py-1 text-xs bg-primary-500 text-white rounded">現在の言語</span>
                    @endif
                </div>

                <div class="p-6 border rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 cursor-pointer {{ app()->getLocale() === 'en' ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/20' : '' }}"
                    wire:click="switchLocale('en')">
                    <div class="text-2xl mb-2">🇬🇧</div>
                    <h3 class="font-semibold text-lg">English</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">英語</p>
                    @if (app()->getLocale() === 'en')
                        <span class="inline-block mt-2 px-2 py-1 text-xs bg-primary-500 text-white rounded">Current
                            Language</span>
                    @endif
                </div>

                <div class="p-6 border rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 cursor-pointer {{ app()->getLocale() === 'ru' ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/20' : '' }}"
                    wire:click="switchLocale('ru')">
                    <div class="text-2xl mb-2">🇷🇺</div>
                    <h3 class="font-semibold text-lg">Русский</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">ロシア語</p>
                    @if (app()->getLocale() === 'ru')
                        <span class="inline-block mt-2 px-2 py-1 text-xs bg-primary-500 text-white rounded">Текущий
                            язык</span>
                    @endif
                </div>
            </div>

            <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                <p class="text-sm">
                    <strong>{{ __('現在の言語', [], 'ja') }}:</strong>
                    @if (app()->getLocale() === 'ja')
                        日本語
                    @elseif(app()->getLocale() === 'en')
                        English
                    @elseif(app()->getLocale() === 'ru')
                        Русский
                    @endif
                </p>
            </div>
        </div>
    </x-filament-panels::page>
</div>
