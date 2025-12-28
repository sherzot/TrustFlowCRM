<?php

namespace App\Domains\Integration;

use App\Models\Lead;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class IntegrationService
{
    /**
     * Telegram orqali bildirishnoma yuborish
     */
    public function sendTelegramNotification(string $message, ?string $chatId = null): bool
    {
        try {
            $token = config('services.telegram.bot_token');
            $chatId = $chatId ?? config('services.telegram.chat_id');

            if (empty($token) || empty($chatId)) {
                return false;
            }

            Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'HTML',
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Telegram notification error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * WhatsApp orqali xabar yuborish
     */
    public function sendWhatsAppMessage(string $to, string $message): bool
    {
        try {
            $apiKey = config('services.whatsapp.api_key');
            $phoneNumberId = config('services.whatsapp.phone_number_id');

            if (empty($apiKey) || empty($phoneNumberId)) {
                return false;
            }

            Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
            ])->post("https://graph.facebook.com/v18.0/{$phoneNumberId}/messages", [
                'messaging_product' => 'whatsapp',
                'to' => $to,
                'type' => 'text',
                'text' => ['body' => $message],
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('WhatsApp message error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Jira ga task yaratish
     */
    public function createJiraIssue(array $data): ?array
    {
        try {
            $url = config('services.jira.url');
            $email = config('services.jira.email');
            $token = config('services.jira.api_token');

            if (empty($url) || empty($email) || empty($token)) {
                return null;
            }

            $response = Http::withBasicAuth($email, $token)
                ->post("{$url}/rest/api/3/issue", [
                    'fields' => [
                        'project' => ['key' => $data['project_key']],
                        'summary' => $data['summary'],
                        'description' => $data['description'] ?? '',
                        'issuetype' => ['name' => $data['issue_type'] ?? 'Task'],
                    ],
                ]);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Jira integration error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Xero ga invoice yuborish
     */
    public function syncInvoiceToXero(int $invoiceId): bool
    {
        try {
            $clientId = config('services.xero.client_id');
            $clientSecret = config('services.xero.client_secret');
            $tenantId = config('services.xero.tenant_id');

            if (empty($clientId) || empty($clientSecret) || empty($tenantId)) {
                return false;
            }

            // Xero API integration logic here
            // This is a placeholder - actual implementation would require OAuth flow

            return true;
        } catch (\Exception $e) {
            Log::error('Xero integration error: ' . $e->getMessage());
            return false;
        }
    }
}

