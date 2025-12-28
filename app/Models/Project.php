<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'deal_id',
        'account_id',
        'name',
        'description',
        'status',
        'start_date',
        'end_date',
        'budget',
        'currency',
        'actual_cost',
        'profit',
        'progress',
    ];

    protected function casts(): array
    {
        return [
            'budget' => 'decimal:2',
            'actual_cost' => 'decimal:2',
            'profit' => 'decimal:2',
            'progress' => 'integer',
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function deal(): BelongsTo
    {
        return $this->belongsTo(Deal::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function timeEntries(): HasMany
    {
        return $this->hasMany(TimeEntry::class);
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}

