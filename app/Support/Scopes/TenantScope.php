<?php

declare(strict_types=1);

namespace App\Support\Scopes;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * TenantScope
 * ----------------------------------------------------------------------
 * Global Eloquent scope which automatically filters every query by the
 * currently active Tenant. The active tenant is resolved from the
 * service container (bound by EnsureTenantContext middleware).
 *
 * When no Tenant is bound (CLI, public routes, unit tests without tenant),
 * the scope is a no-op so that background jobs / commands can choose their
 * own context explicitly.
 *
 * Usage:
 *   use App\Support\Concerns\BelongsToTenant;
 *   class Lead extends Model { use BelongsToTenant; }
 *
 * To temporarily bypass (e.g. Super Admin queries):
 *   Lead::withoutGlobalScope(TenantScope::class)->get();
 */
final class TenantScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        if (! app()->bound(Tenant::class)) {
            return;
        }

        /** @var Tenant $tenant */
        $tenant = app(Tenant::class);

        $builder->where(
            $model->qualifyColumn('tenant_id'),
            $tenant->getKey()
        );
    }
}
