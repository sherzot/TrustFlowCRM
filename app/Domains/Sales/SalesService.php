<?php

namespace App\Domains\Sales;

use App\Models\Lead;
use App\Models\Deal;
use App\Models\Account;
use App\Models\Contact;
use App\Services\AIService;
use Illuminate\Support\Facades\DB;

class SalesService
{
    protected AIService $aiService;

    public function __construct(AIService $aiService)
    {
        $this->aiService = $aiService;
    }

    /**
     * Lead ni Account va Contact ga konvert qilish
     */
    public function convertLead(Lead $lead): array
    {
        return DB::transaction(function () use ($lead) {
            // Account yaratish
            $account = Account::create([
                'tenant_id' => $lead->tenant_id,
                'name' => $lead->company ?? $lead->first_name . ' ' . $lead->last_name,
                'industry' => $lead->industry,
                'website' => $lead->website,
                'email' => $lead->email,
                'phone' => $lead->phone,
                'status' => 'active',
            ]);

            // Contact yaratish
            $contact = Contact::create([
                'tenant_id' => $lead->tenant_id,
                'account_id' => $account->id,
                'first_name' => $lead->first_name,
                'last_name' => $lead->last_name,
                'email' => $lead->email,
                'phone' => $lead->phone,
                'title' => $lead->title,
                'is_primary' => true,
                'status' => 'active',
            ]);

            // Lead ni yangilash
            $lead->update([
                'status' => 'converted',
                'converted_at' => now(),
                'converted_to_account_id' => $account->id,
                'converted_to_contact_id' => $contact->id,
            ]);

            return [
                'account' => $account,
                'contact' => $contact,
            ];
        });
    }

    /**
     * Deal yaratish
     */
    public function createDeal(array $data): Deal
    {
        $deal = Deal::create($data);

        // AI scoring
        $this->aiService->predictDeal($deal);

        return $deal;
    }

    /**
     * Deal ni yutish
     */
    public function winDeal(Deal $deal): Deal
    {
        $deal->update([
            'status' => 'won',
            'won_at' => now(),
            'actual_close_date' => now(),
        ]);

        // Avtomatik Project yaratish
        if (!$deal->project) {
            $deliveryService = app(\App\Domains\Delivery\DeliveryService::class);
            $deliveryService->createProjectFromDeal($deal->id, [
                'name' => $deal->name,
                'description' => $deal->description,
                'start_date' => now(),
            ]);
        }

        return $deal;
    }

    /**
     * Deal ni yo'qotish
     */
    public function loseDeal(Deal $deal, string $reason): Deal
    {
        $deal->update([
            'status' => 'lost',
            'lost_at' => now(),
            'lost_reason' => $reason,
        ]);

        return $deal;
    }

    /**
     * Sales funnel statistikasi
     */
    public function getSalesFunnelStats(int $tenantId): array
    {
        $stages = ['new', 'qualified', 'discovery', 'proposal', 'negotiation', 'won', 'lost'];
        
        $stats = [];
        foreach ($stages as $stage) {
            $stats[$stage] = Deal::where('tenant_id', $tenantId)
                ->where('stage', $stage)
                ->count();
        }

        return $stats;
    }
}

