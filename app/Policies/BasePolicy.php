<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

/**
 * BasePolicy
 * ----------------------------------------------------------------------
 * Shared logic for all tenant-scoped policies. Enforces:
 *   - same tenant_id between user and record
 *   - Super Admin bypass via before()
 *   - spatie/permission permission strings
 */
abstract class BasePolicy
{
    use HandlesAuthorization;

    /**
     * The permission prefix for this policy (e.g. "deals", "leads").
     * Child policies override this string.
     */
    protected string $resource = '';

    /**
     * Super Admins can do everything across every tenant.
     *
     * Role name matches RoleSeeder.php ("super_admin", snake_case).
     */
    public function before(User $user, string $ability): ?bool
    {
        return $user->hasRole('super_admin') ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return $user->can($this->resource.'.view');
    }

    public function view(User $user, Model $model): bool
    {
        return $this->sameTenant($user, $model) && $user->can($this->resource.'.view');
    }

    public function create(User $user): bool
    {
        return $user->can($this->resource.'.create');
    }

    public function update(User $user, Model $model): bool
    {
        return $this->sameTenant($user, $model) && $user->can($this->resource.'.update');
    }

    public function delete(User $user, Model $model): bool
    {
        return $this->sameTenant($user, $model) && $user->can($this->resource.'.delete');
    }

    public function restore(User $user, Model $model): bool
    {
        return $this->update($user, $model);
    }

    public function forceDelete(User $user, Model $model): bool
    {
        return false; // Force-delete only allowed via Super Admin bypass
    }

    protected function sameTenant(User $user, Model $model): bool
    {
        return (int) $user->tenant_id === (int) $model->getAttribute('tenant_id');
    }
}
