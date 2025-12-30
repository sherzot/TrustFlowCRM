<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Account;
use App\Models\Contact;
use App\Models\Lead;
use App\Models\Deal;
use App\Models\Project;
use App\Models\Invoice;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $tenantId = 1;

        // Agar allaqachon demo ma'lumotlar bo'lsa, qayta yaratmaslik
        if (Account::where('tenant_id', $tenantId)->exists()) {
            $this->command->info('Demo data already exists. Skipping...');
            return;
        }

        // Accounts yaratish
        $accounts = Account::factory(10)->create([
            'tenant_id' => $tenantId,
        ]);

        // Contacts yaratish
        foreach ($accounts as $account) {
            Contact::factory(2)->create([
                'tenant_id' => $tenantId,
                'account_id' => $account->id,
            ]);
        }

        // Leads yaratish
        Lead::factory(20)->create([
            'tenant_id' => $tenantId,
            'ai_score' => fake()->numberBetween(30, 95),
        ]);

        // Deals yaratish
        $stages = ['new', 'qualified', 'discovery', 'proposal', 'negotiation', 'won', 'lost'];
        foreach ($accounts as $account) {
            Deal::factory(2)->create([
                'tenant_id' => $tenantId,
                'account_id' => $account->id,
                'contact_id' => $account->contacts()->first()?->id,
                'stage' => fake()->randomElement($stages),
                'status' => fake()->randomElement(['open', 'won', 'lost']),
                'ai_score' => fake()->numberBetween(40, 90),
            ]);
        }

        // Projects yaratish
        $wonDeals = Deal::where('tenant_id', $tenantId)
            ->where('status', 'won')
            ->get();

        foreach ($wonDeals as $deal) {
            Project::factory()->create([
                'tenant_id' => $tenantId,
                'deal_id' => $deal->id,
                'account_id' => $deal->account_id,
                'status' => fake()->randomElement(['planning', 'active', 'completed']),
                'progress' => fake()->numberBetween(0, 100),
            ]);
        }

        // Invoices yaratish
        $projects = Project::where('tenant_id', $tenantId)->get();
        foreach ($projects as $project) {
            Invoice::factory()->create([
                'tenant_id' => $tenantId,
                'project_id' => $project->id,
                'account_id' => $project->account_id,
                'status' => fake()->randomElement(['draft', 'sent', 'paid']),
            ]);
        }
    }
}

