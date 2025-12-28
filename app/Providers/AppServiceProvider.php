<?php

namespace App\Providers;

use App\Models\Deal;
use App\Models\Lead;
use App\Observers\DealObserver;
use App\Observers\LeadObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Deal::observe(DealObserver::class);
        Lead::observe(LeadObserver::class);
    }
}

