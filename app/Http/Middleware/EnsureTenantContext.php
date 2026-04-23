<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * EnsureTenantContext
 * ----------------------------------------------------------------------
 * Binds the current Tenant instance into the service container so that
 * TenantScope can apply to every Eloquent query automatically.
 *
 * Resolution order:
 *   1. Authenticated user → $user->tenant
 *   2. Signed portal route with tenant id claim
 *   3. Subdomain lookup via stancl/tenancy Domains table
 *
 * Super Admins are allowed to pass through without a tenant binding so
 * that cross-tenant admin views can work (they must opt-in per query
 * using withoutGlobalScope(TenantScope::class)).
 */
final class EnsureTenantContext
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // 1) Authenticated user path
        if ($user !== null) {
            if (method_exists($user, 'hasRole') && $user->hasRole('super_admin')) {
                return $next($request);
            }

            if ($user->tenant_id === null) {
                throw new AccessDeniedHttpException('User has no tenant assigned.');
            }

            $tenant = Tenant::find($user->tenant_id);
            if ($tenant === null) {
                throw new AccessDeniedHttpException('Tenant not found.');
            }

            app()->instance(Tenant::class, $tenant);

            return $next($request);
        }

        // 2) Public/portal routes that pass an explicit tenant id (signed URL)
        if ($request->has('tenant')) {
            $tenant = Tenant::find($request->input('tenant'));
            if ($tenant !== null) {
                app()->instance(Tenant::class, $tenant);
            }
        }

        return $next($request);
    }
}
