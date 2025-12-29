<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Permissions yaratish
        $permissions = [
            'view accounts',
            'create accounts',
            'edit accounts',
            'delete accounts',
            'view contacts',
            'create contacts',
            'edit contacts',
            'delete contacts',
            'view leads',
            'create leads',
            'edit leads',
            'delete leads',
            'view deals',
            'create deals',
            'edit deals',
            'delete deals',
            'view projects',
            'create projects',
            'edit projects',
            'delete projects',
            'view tasks',
            'create tasks',
            'edit tasks',
            'delete tasks',
            'view invoices',
            'create invoices',
            'edit invoices',
            'delete invoices',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Roles yaratish
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin']);
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $manager = Role::firstOrCreate(['name' => 'manager']);
        $sales = Role::firstOrCreate(['name' => 'sales']);
        $delivery = Role::firstOrCreate(['name' => 'delivery']);
        $finance = Role::firstOrCreate(['name' => 'finance']);

        // Super Admin ga barcha permissionlar
        $superAdmin->givePermissionTo(Permission::all());

        // Admin ga ko'pchilik permissionlar
        $admin->givePermissionTo([
            'view accounts', 'create accounts', 'edit accounts',
            'view contacts', 'create contacts', 'edit contacts',
            'view leads', 'create leads', 'edit leads',
            'view deals', 'create deals', 'edit deals',
            'view projects', 'create projects', 'edit projects',
            'view invoices', 'create invoices', 'edit invoices',
        ]);

        // Manager ga ko'rish va tahrirlash
        $manager->givePermissionTo([
            'view accounts', 'edit accounts',
            'view contacts', 'edit contacts',
            'view leads', 'edit leads',
            'view deals', 'edit deals',
            'view projects', 'edit projects',
            'view invoices', 'edit invoices',
        ]);

        // Sales ga sales permissionlar
        $sales->givePermissionTo([
            'view accounts', 'create accounts', 'edit accounts',
            'view contacts', 'create contacts', 'edit contacts',
            'view leads', 'create leads', 'edit leads',
            'view deals', 'create deals', 'edit deals',
        ]);

        // Delivery ga project va task permissionlar
        $delivery->givePermissionTo([
            'view projects', 'create projects', 'edit projects',
            'view tasks', 'create tasks', 'edit tasks',
        ]);

        // Finance ga invoice permissionlar
        $finance->givePermissionTo([
            'view invoices', 'create invoices', 'edit invoices',
        ]);
    }
}

