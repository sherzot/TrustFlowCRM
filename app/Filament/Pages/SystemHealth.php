<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Queue;

class SystemHealth extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-heart';

    protected static string $view = 'filament.pages.system-health';

    protected static ?string $navigationLabel = 'System Health';

    protected static ?string $navigationGroup = 'System';

    public static function getNavigationLabel(): string
    {
        return __('filament.system_health');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('filament.system');
    }

    public function getHealthMetrics(): array
    {
        return [
            'database' => $this->checkDatabase(),
            'cache' => $this->checkCache(),
            'queue' => $this->checkQueue(),
            'storage' => $this->checkStorage(),
        ];
    }

    protected function checkDatabase(): array
    {
        try {
            DB::connection()->getPdo();
            return ['status' => 'healthy', 'message' => __('filament.database_connection_successful')];
        } catch (\Exception $e) {
            return ['status' => 'unhealthy', 'message' => $e->getMessage()];
        }
    }

    protected function checkCache(): array
    {
        try {
            Cache::put('health_check', 'ok', 10);
            $value = Cache::get('health_check');
            return ['status' => $value === 'ok' ? 'healthy' : 'unhealthy', 'message' => __('filament.cache_is_working')];
        } catch (\Exception $e) {
            return ['status' => 'unhealthy', 'message' => $e->getMessage()];
        }
    }

    protected function checkQueue(): array
    {
        try {
            $size = Queue::size();
            return ['status' => 'healthy', 'message' => __('filament.queue_size') . ': ' . $size];
        } catch (\Exception $e) {
            return ['status' => 'unhealthy', 'message' => $e->getMessage()];
        }
    }

    protected function checkStorage(): array
    {
        try {
            $freeSpace = disk_free_space(storage_path());
            $totalSpace = disk_total_space(storage_path());
            $usedSpace = $totalSpace - $freeSpace;
            $percentage = ($usedSpace / $totalSpace) * 100;

            return [
                'status' => $percentage > 90 ? 'warning' : 'healthy',
                'message' => __('filament.storage_used') . ': ' . sprintf('%.1f%%', $percentage),
            ];
        } catch (\Exception $e) {
            return ['status' => 'unhealthy', 'message' => $e->getMessage()];
        }
    }
}

