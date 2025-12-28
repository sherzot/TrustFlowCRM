<?php

namespace App\Jobs;

use App\Domains\Integration\IntegrationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public string $message,
        public ?string $channel = 'telegram'
    ) {}

    public function handle(IntegrationService $integrationService): void
    {
        match ($this->channel) {
            'telegram' => $integrationService->sendTelegramNotification($this->message),
            'whatsapp' => $integrationService->sendWhatsAppMessage('', $this->message),
            default => null,
        };
    }
}

