<?php

namespace App\Observers;

use App\Models\Deal;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;

class DealObserver
{
    public function created(Deal $deal): void
    {
        Activity::create([
            'tenant_id' => $deal->tenant_id,
            'user_id' => Auth::id(),
            'subject_type' => Deal::class,
            'subject_id' => $deal->id,
            'type' => 'created',
            'description' => "Deal '{$deal->name}' created",
        ]);
    }

    public function updated(Deal $deal): void
    {
        Activity::create([
            'tenant_id' => $deal->tenant_id,
            'user_id' => Auth::id(),
            'subject_type' => Deal::class,
            'subject_id' => $deal->id,
            'type' => 'updated',
            'description' => "Deal '{$deal->name}' updated",
        ]);
    }

    public function deleted(Deal $deal): void
    {
        Activity::create([
            'tenant_id' => $deal->tenant_id,
            'user_id' => Auth::id(),
            'subject_type' => Deal::class,
            'subject_id' => $deal->id,
            'type' => 'deleted',
            'description' => "Deal '{$deal->name}' deleted",
        ]);
    }
}

