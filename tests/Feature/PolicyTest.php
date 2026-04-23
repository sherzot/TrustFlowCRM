<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Deal;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

final class PolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_access_deal_from_other_tenant(): void
    {
        $tenantA = Tenant::factory()->create();
        $tenantB = Tenant::factory()->create();

        Role::findOrCreate('Sales', 'web');

        $userA = User::factory()->create(['tenant_id' => $tenantA->id]);
        $userA->assignRole('Sales');

        $dealInB = Deal::factory()->create(['tenant_id' => $tenantB->id]);

        $this->assertFalse(
            $userA->can('view', $dealInB),
            'User from tenant A must not view deals from tenant B.'
        );
    }

    public function test_super_admin_bypasses_tenant_scope(): void
    {
        Role::findOrCreate('Super Admin', 'web');

        $admin = User::factory()->create(['tenant_id' => null]);
        $admin->assignRole('Super Admin');

        $tenant = Tenant::factory()->create();
        $deal = Deal::factory()->create(['tenant_id' => $tenant->id]);

        $this->assertTrue($admin->can('view', $deal));
        $this->assertTrue($admin->can('update', $deal));
        $this->assertTrue($admin->can('delete', $deal));
    }

    public function test_sales_role_can_view_and_update_own_tenant_deal(): void
    {
        Role::findOrCreate('Sales', 'web');

        $tenant = Tenant::factory()->create();
        $user = User::factory()->create(['tenant_id' => $tenant->id]);
        $user->assignRole('Sales');

        $deal = Deal::factory()->create(['tenant_id' => $tenant->id]);

        $this->assertTrue($user->can('view', $deal));
        $this->assertTrue($user->can('update', $deal));
    }
}
