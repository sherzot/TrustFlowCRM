<x-filament-panels::page>
    <div class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ($this->getObjectives() as $key => $objective)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="font-semibold text-lg mb-4 text-gray-900 dark:text-gray-100">
                        {{ $objective['label'] }}
                    </h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('filament.current_value') }}:</span>
                            <span class="font-semibold text-gray-900 dark:text-gray-100">
                                @if (str_contains($key, 'value') || str_contains($key, 'revenue'))
                                    ${{ number_format($objective['current'], 2) }}
                                @else
                                    {{ number_format($objective['current']) }}
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('filament.target') }}:</span>
                            <span class="font-semibold text-gray-900 dark:text-gray-100">
                                @if (str_contains($key, 'value') || str_contains($key, 'revenue'))
                                    ${{ number_format($objective['target'], 2) }}
                                @else
                                    {{ number_format($objective['target']) }}
                                @endif
                            </span>
                        </div>
                        <div class="mt-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('filament.progress') }}:</span>
                                <span class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                    {{ number_format($objective['percentage'], 1) }}%
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4">
                                <div class="h-4 rounded-full transition-all duration-300
                                    @if ($objective['percentage'] >= 100) bg-green-500
                                    @elseif($objective['percentage'] >= 75) bg-blue-500
                                    @elseif($objective['percentage'] >= 50) bg-yellow-500
                                    @else bg-red-500 @endif"
                                    style="width: {{ min(100, $objective['percentage']) }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-filament-panels::page>
