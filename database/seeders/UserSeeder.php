<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin
        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@trustflow.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'tenant_id' => null,
                'role' => 'super_admin',
            ]
        );
        if (!$superAdmin->hasRole('super_admin')) {
            $superAdmin->assignRole('super_admin');
        }

        // Demo Tenant Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@demo.com'],
            [
                'name' => 'Demo Admin',
                'password' => Hash::make('password'),
                'tenant_id' => 1,
                'role' => 'admin',
            ]
        );
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }
    }
}

