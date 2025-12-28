<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tenant;

class TenantSeeder extends Seeder
{
    public function run(): void
    {
        Tenant::firstOrCreate(
            ['id' => 'demo'],
            [
                'name' => 'Demo Agency',
                'plan' => 'enterprise',
                'status' => 'active',
            ]
        );
    }
}

