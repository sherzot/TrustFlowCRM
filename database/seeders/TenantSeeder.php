<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tenant;

class TenantSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure tenant with id = 1 exists
        Tenant::firstOrCreate(
            ['id' => 1],
            [
                'name' => 'Demo Agency',
                'plan' => 'enterprise',
                'status' => 'active',
            ]
        );
    }
}

