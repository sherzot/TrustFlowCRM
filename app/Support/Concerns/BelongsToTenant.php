<?php

declare(strict_types=1);

namespace App\Support\Concerns;

use App\Models\Tenant;
use App\Support\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * BelongsToTenant
 * ----------------------------------------------------------------------
 * Drop-in trait for any Eloquent model that carries a `tenant_id`
 * column. Automatically:
 *   - registers the TenantScope global scope
 *   - fills tenant_id on create from the container-bound Tenant
 *   - exposes tenant() relation
 *
 * Apply to: Account, Contact, Lead, Deal, Project, Task, Invoice,
 *           InvoiceItem, Contract, Activity, TimeEntry, User.
 */
trait BelongsToTenant
{
    protected static function bootBelongsToTenant(): void
    {
        static::addGlobalScope(new TenantScope);

        static::creating(function ($model): void {
            if ($model->tenant_id === null && app()->bound(Tenant::class)) {
                /** @var Tenant $tenant */
                $tenant = app(Tenant::class);
                $model->tenant_id = $tenant->getKey();
            }
        });
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
