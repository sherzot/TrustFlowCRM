<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin (tenant_id = null) - admin@trustflow.com
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

        // Admin (tenant_id = 1)
        $admin = User::firstOrCreate(
            ['email' => 'admin@test.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('admin123'),
                'tenant_id' => 1,
                'role' => 'admin',
            ]
        );
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        // Manager (tenant_id = 1)
        $manager = User::firstOrCreate(
            ['email' => 'manager@test.com'],
            [
                'name' => 'Manager User',
                'password' => Hash::make('manager123'),
                'tenant_id' => 1,
                'role' => 'manager',
            ]
        );
        if (!$manager->hasRole('manager')) {
            $manager->assignRole('manager');
        }

        // Sales (tenant_id = 1)
        $sales = User::firstOrCreate(
            ['email' => 'sales@test.com'],
            [
                'name' => 'Sales User',
                'password' => Hash::make('sales123'),
                'tenant_id' => 1,
                'role' => 'sales',
            ]
        );
        if (!$sales->hasRole('sales')) {
            $sales->assignRole('sales');
        }

        // Delivery (tenant_id = 1)
        $delivery = User::firstOrCreate(
            ['email' => 'delivery@test.com'],
            [
                'name' => 'Delivery User',
                'password' => Hash::make('delivery123'),
                'tenant_id' => 1,
                'role' => 'delivery',
            ]
        );
        if (!$delivery->hasRole('delivery')) {
            $delivery->assignRole('delivery');
        }

        // Finance (tenant_id = 1)
        $finance = User::firstOrCreate(
            ['email' => 'finance@test.com'],
            [
                'name' => 'Finance User',
                'password' => Hash::make('finance123'),
                'tenant_id' => 1,
                'role' => 'finance',
            ]
        );
        if (!$finance->hasRole('finance')) {
            $finance->assignRole('finance');
        }
    }
}

