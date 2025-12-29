<?php

namespace App\Helpers;

use App\Models\Tenant;
use Illuminate\Support\Facades\Auth;

class TenantHelper
{
    /**
     * Get tenant_id for current user or create default tenant
     */
    public static function getTenantId(): int
    {
        $tenantId = Auth::user()->tenant_id;
        
        // If user has tenant_id, use it
        if ($tenantId !== null) {
            // Verify tenant exists
            if (Tenant::where('id', $tenantId)->exists()) {
                return $tenantId;
            }
        }
        
        // For Super Admin or if tenant doesn't exist, get or create default tenant
        $tenant = Tenant::firstOrCreate(
            ['id' => 1],
            [
                'name' => 'Demo Agency',
                'plan' => 'enterprise',
                'status' => 'active',
            ]
        );
        
        return $tenant->id;
    }
}

