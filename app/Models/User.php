<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'tenant_id',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Only users with a known CRM role and an assigned tenant
     * (or a Super Admin with no tenant) may enter the Filament panel.
     *
     * Role names match RoleSeeder.php — snake_case, not title case.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        if ($this->hasRole('super_admin')) {
            return true;
        }

        if ($this->tenant_id === null) {
            return false;
        }

        return $this->hasAnyRole([
            'admin',
            'manager',
            'sales',
            'delivery',
            'finance',
        ]);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}

