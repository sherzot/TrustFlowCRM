<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'source',
        'first_name',
        'last_name',
        'email',
        'phone',
        'company',
        'title',
        'website',
        'industry',
        'description',
        'status',
        'ai_score',
        'converted_at',
        'converted_to_account_id',
        'converted_to_contact_id',
    ];

    protected function casts(): array
    {
        return [
            'ai_score' => 'decimal:2',
            'converted_at' => 'datetime',
        ];
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function convertedToAccount()
    {
        return $this->belongsTo(Account::class, 'converted_to_account_id');
    }

    public function convertedToContact()
    {
        return $this->belongsTo(Contact::class, 'converted_to_contact_id');
    }
}

