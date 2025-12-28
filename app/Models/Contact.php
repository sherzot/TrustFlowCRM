<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'account_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'mobile',
        'title',
        'department',
        'is_primary',
        'status',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function deals(): HasMany
    {
        return $this->hasMany(Deal::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}

