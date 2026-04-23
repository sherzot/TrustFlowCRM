<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Deal;
use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Verifies the global TenantScope only returns rows that belong to the bound
 * tenant. This is the core security guarantee for the multi-tenant model.
 */
final class TenantIsolationTest extends TestCase
{
    use RefreshDatabase;

    public function test_queries_are_scoped_to_the_bound_tenant(): void
    {
        $alpha = Tenant::factory()->create();
        $beta  = Tenant::factory()->create();

        $alphaDeal = Deal::factory()->create(['tenant_id' => $alpha->id, 'name' => 'Alpha deal']);
        $betaDeal  = Deal::factory()->create(['tenant_id' => $beta->id,  'name' => 'Beta deal']);

        // Bind tenant Alpha.
        app()->instance(Tenant::class, $alpha);
        $this->assertSame(1, Deal::query()->count(), 'Only Alpha deals should be visible.');
        $this->assertTrue(Deal::query()->whereKey($alphaDeal->id)->exists());
        $this->assertFalse(Deal::query()->whereKey($betaDeal->id)->exists());

        // Rebind to Beta.
        app()->instance(Tenant::class, $beta);
        $this->assertSame(1, Deal::query()->count(), 'Only Beta deals should be visible.');
        $this->assertTrue(Deal::query()->whereKey($betaDeal->id)->exists());
        $this->assertFalse(Deal::query()->whereKey($alphaDeal->id)->exists());
    }

    public function test_new_models_auto_fill_tenant_id(): void
    {
        $tenant = Tenant::factory()->create();
        app()->instance(Tenant::class, $tenant);

        $deal = Deal::factory()->create(['tenant_id' => null]);

        $this->assertSame($tenant->id, $deal->fresh()->tenant_id);
    }

    public function test_without_tenant_scope_returns_all_rows(): void
    {
        $alpha = Tenant::factory()->create();
        $beta  = Tenant::factory()->create();

        Deal::factory()->create(['tenant_id' => $alpha->id]);
        Deal::factory()->create(['tenant_id' => $beta->id]);

        app()->instance(Tenant::class, $alpha);
        $this->assertSame(
            2,
            Deal::query()->withoutGlobalScope(\App\Support\Scopes\TenantScope::class)->count(),
            'Scope bypass should expose cross-tenant rows (admin/reporting use only).'
        );
    }
}
