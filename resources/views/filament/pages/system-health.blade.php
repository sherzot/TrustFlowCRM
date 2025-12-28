<x-filament-panels::page>
    <div class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ($this->getHealthMetrics() as $component => $metric)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-lg text-gray-900 dark:text-gray-100 capitalize">
                            {{ $component }}
                        </h3>
                        <span
                            class="px-3 py-1 rounded-full text-xs font-semibold
                            @if ($metric['status'] === 'healthy') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                            @elseif($metric['status'] === 'warning') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                            @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 @endif">
                            {{ ucfirst($metric['status']) }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ $metric['message'] }}
                    </p>
                    @if ($component === 'database')
                        <div class="mt-4 flex items-center">
                            <svg class="w-5 h-5 mr-2
                                @if ($metric['status'] === 'healthy') text-green-500
                                @else text-red-500 @endif"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="text-sm text-gray-700 dark:text-gray-300">
                                データベース接続が正常です
                            </span>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</x-filament-panels::page>
