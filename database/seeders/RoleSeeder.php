<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

/**
 * RoleSeeder
 * ----------------------------------------------------------------------
 * TrustFlow CRM — canonical RBAC definition.
 *
 * Roles (snake_case, guard=web):
 *   super_admin   Platform owner, cross-tenant, bypasses all gates via BasePolicy::before().
 *   admin         Tenant administrator: manages tenant settings, users, and every CRM record.
 *   manager       Sales/Operations manager: approves deals & invoices, full visibility over team data.
 *   sales         Sales representative: owns leads, deals, contracts, and their related accounts/contacts.
 *   delivery      Delivery / Project manager: owns projects and tasks.
 *   finance       Finance officer: owns invoices and payments; runs financial reports.
 *   viewer        Read-only auditor / external stakeholder: dashboards and lists only.
 *
 * Permission format is dot-notation (`{resource}.{action}`) so it aligns with
 * BasePolicy which does `$user->can($this->resource.'.view')`.
 */
class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Flush any cached permissions so freshly created ones are visible.
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $resources = [
            'accounts', 'contacts', 'leads', 'deals', 'contracts',
            'projects', 'tasks', 'invoices', 'payments',
            'reports', 'users', 'tenants', 'roles', 'settings',
        ];

        $standardActions = ['view', 'create', 'update', 'delete'];

        // Build standard resource.action permissions.
        $permissions = [];
        foreach ($resources as $resource) {
            foreach ($standardActions as $action) {
                $permissions[] = "$resource.$action";
            }
        }

        // Workflow / business-rule permissions on top of CRUD.
        $workflowPermissions = [
            'leads.convert',
            'deals.win', 'deals.lose', 'deals.approve',
            'contracts.sign',
            'invoices.send', 'invoices.markPaid', 'invoices.approve',
            'reports.export',
            'users.assignRole',
        ];
        $permissions = array_merge($permissions, $workflowPermissions);

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        // ------------------------------------------------------------------
        // Roles
        // ------------------------------------------------------------------
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $admin      = Role::firstOrCreate(['name' => 'admin',       'guard_name' => 'web']);
        $manager    = Role::firstOrCreate(['name' => 'manager',     'guard_name' => 'web']);
        $sales      = Role::firstOrCreate(['name' => 'sales',       'guard_name' => 'web']);
        $delivery   = Role::firstOrCreate(['name' => 'delivery',    'guard_name' => 'web']);
        $finance    = Role::firstOrCreate(['name' => 'finance',     'guard_name' => 'web']);
        $viewer     = Role::firstOrCreate(['name' => 'viewer',      'guard_name' => 'web']);

        // ------------------------------------------------------------------
        // Permission assignments
        // ------------------------------------------------------------------

        // super_admin → everything (still bypassed by BasePolicy::before()).
        $superAdmin->syncPermissions(Permission::all());

        // admin → tenant-wide CRUD plus approvals & user management.
        $admin->syncPermissions(array_merge(
            self::crud(['accounts', 'contacts', 'leads', 'deals', 'contracts',
                        'projects', 'tasks', 'invoices', 'payments']),
            ['leads.convert',
             'deals.win', 'deals.lose', 'deals.approve',
             'contracts.sign',
             'invoices.send', 'invoices.markPaid', 'invoices.approve',
             'reports.view', 'reports.export',
             'users.view', 'users.create', 'users.update', 'users.assignRole',
             'settings.view', 'settings.update'],
        ));

        // manager → view/update across the board, approve deals & invoices.
        $manager->syncPermissions([
            'accounts.view', 'accounts.update',
            'contacts.view', 'contacts.update',
            'leads.view', 'leads.update', 'leads.convert',
            'deals.view', 'deals.update', 'deals.approve',
            'contracts.view', 'contracts.update', 'contracts.sign',
            'projects.view', 'projects.update',
            'tasks.view', 'tasks.update',
            'invoices.view', 'invoices.update', 'invoices.approve',
            'payments.view',
            'reports.view', 'reports.export',
            'users.view',
        ]);

        // sales → owns funnel from lead through contract signing.
        $sales->syncPermissions([
            'accounts.view', 'accounts.create', 'accounts.update',
            'contacts.view', 'contacts.create', 'contacts.update',
            'leads.view', 'leads.create', 'leads.update', 'leads.convert',
            'deals.view', 'deals.create', 'deals.update',
            'deals.win', 'deals.lose',
            'contracts.view', 'contracts.create', 'contracts.update', 'contracts.sign',
        ]);

        // delivery → projects/tasks; read context on accounts/contacts/contracts.
        $delivery->syncPermissions([
            'projects.view', 'projects.create', 'projects.update',
            'tasks.view', 'tasks.create', 'tasks.update', 'tasks.delete',
            'accounts.view', 'contacts.view', 'contracts.view',
        ]);

        // finance → invoice lifecycle, payments, financial reporting.
        $finance->syncPermissions([
            'invoices.view', 'invoices.create', 'invoices.update',
            'invoices.send', 'invoices.markPaid',
            'payments.view', 'payments.create', 'payments.update',
            'accounts.view', 'contacts.view', 'contracts.view',
            'reports.view', 'reports.export',
        ]);

        // viewer → read-only across lists and dashboards.
        $viewer->syncPermissions([
            'accounts.view', 'contacts.view', 'leads.view', 'deals.view',
            'contracts.view', 'projects.view', 'tasks.view',
            'invoices.view', 'payments.view', 'reports.view',
        ]);

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    /**
     * Expand a list of resources into the 4 standard CRUD permission strings.
     *
     * @param  array<int, string>  $resources
     * @return array<int, string>
     */
    private static function crud(array $resources): array
    {
        $out = [];
        foreach ($resources as $r) {
            foreach (['view', 'create', 'update', 'delete'] as $a) {
                $out[] = "$r.$a";
            }
        }

        return $out;
    }
}
