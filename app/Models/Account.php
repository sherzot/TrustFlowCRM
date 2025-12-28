<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Account extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'tenant_id',
        'name',
        'industry',
        'website',
        'phone',
        'email',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'annual_revenue',
        'employee_count',
        'status',
        'ai_score',
    ];

    protected function casts(): array
    {
        return [
            'ai_score' => 'decimal:2',
            'annual_revenue' => 'decimal:2',
        ];
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    public function deals(): HasMany
    {
        return $this->hasMany(Deal::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}

