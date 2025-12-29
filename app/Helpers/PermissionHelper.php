<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class PermissionHelper
{
    /**
     * Check if current user is Super Admin
     */
    public static function isSuperAdmin(): bool
    {
        $user = Auth::user();
        return $user && $user->hasRole('super_admin');
    }

    /**
     * Check permission, but always return true for Super Admin
     */
    public static function can(string $permission): bool
    {
        if (self::isSuperAdmin()) {
            return true;
        }

        return Auth::user()->can($permission);
    }

    /**
     * Check if user has any of the given roles, Super Admin always returns true
     */
    public static function hasAnyRole(array $roles): bool
    {
        if (self::isSuperAdmin()) {
            return true;
        }

        return Auth::user()->hasAnyRole($roles);
    }
}

