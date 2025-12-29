<?php

namespace App\Filament\Traits;

use Illuminate\Support\Facades\Auth;

trait HasRoleBasedAccess
{
    /**
     * Check if user can view any records
     */
    public static function canViewAny(): bool
    {
        $permission = static::getViewPermission();
        return Auth::user()->can($permission);
    }

    /**
     * Check if user can create records
     */
    public static function canCreate(): bool
    {
        $permission = static::getCreatePermission();
        return Auth::user()->can($permission);
    }

    /**
     * Check if resource should be visible in navigation
     */
    public static function shouldRegisterNavigation(): bool
    {
        $permission = static::getViewPermission();
        return Auth::user()->can($permission);
    }

    /**
     * Get view permission name (override in resource)
     */
    protected static function getViewPermission(): string
    {
        $modelName = strtolower(class_basename(static::getModel()));
        return "view {$modelName}s";
    }

    /**
     * Get create permission name (override in resource)
     */
    protected static function getCreatePermission(): string
    {
        $modelName = strtolower(class_basename(static::getModel()));
        return "create {$modelName}s";
    }
}

