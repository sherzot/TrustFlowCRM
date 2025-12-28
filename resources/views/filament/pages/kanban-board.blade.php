<x-filament-panels::page>
    <div class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
            @foreach ($this->getDealsByStage() as $stage => $data)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                    <h3 class="font-semibold text-lg mb-4 text-gray-900 dark:text-gray-100">
                        {{ $data['label'] }}
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            ({{ count($data['deals']) }})
                        </span>
                    </h3>
                    <div class="space-y-3 max-h-[600px] overflow-y-auto">
                        @forelse($data['deals'] as $deal)
                            <div
                                class="bg-gray-50 dark:bg-gray-700 rounded p-3 cursor-move hover:shadow-md transition-shadow">
                                <div class="font-medium text-sm text-gray-900 dark:text-gray-100">
                                    {{ $deal['name'] }}
                                </div>
                                <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                                    {{ $deal['account']['name'] ?? 'N/A' }}
                                </div>
                                <div class="text-xs font-semibold text-blue-600 dark:text-blue-400 mt-2">
                                    ${{ number_format($deal['value'], 2) }}
                                </div>
                                @if ($deal['ai_score'])
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        AI Score: {{ number_format($deal['ai_score'], 1) }}
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="text-sm text-gray-400 dark:text-gray-500 text-center py-4">
                                取引なし
                            </div>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-filament-panels::page>
