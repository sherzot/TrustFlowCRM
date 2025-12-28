<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Deal extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'account_id',
        'contact_id',
        'name',
        'description',
        'value',
        'currency',
        'stage',
        'probability',
        'expected_close_date',
        'actual_close_date',
        'status',
        'ai_score',
        'won_at',
        'lost_at',
        'lost_reason',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'decimal:2',
            'probability' => 'integer',
            'ai_score' => 'decimal:2',
            'expected_close_date' => 'date',
            'actual_close_date' => 'date',
            'won_at' => 'datetime',
            'lost_at' => 'datetime',
        ];
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function project(): HasOne
    {
        return $this->hasOne(Project::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}

