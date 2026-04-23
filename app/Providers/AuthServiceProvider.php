<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Account;
use App\Models\Contact;
use App\Models\Contract;
use App\Models\Deal;
use App\Models\Invoice;
use App\Models\Lead;
use App\Models\Project;
use App\Models\Task;
use App\Policies\AccountPolicy;
use App\Policies\ContactPolicy;
use App\Policies\ContractPolicy;
use App\Policies\DealPolicy;
use App\Policies\InvoicePolicy;
use App\Policies\LeadPolicy;
use App\Policies\ProjectPolicy;
use App\Policies\TaskPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /** @var array<class-string, class-string> */
    protected $policies = [
        Account::class  => AccountPolicy::class,
        Contact::class  => ContactPolicy::class,
        Lead::class     => LeadPolicy::class,
        Deal::class     => DealPolicy::class,
        Project::class  => ProjectPolicy::class,
        Task::class     => TaskPolicy::class,
        Invoice::class  => InvoicePolicy::class,
        Contract::class => ContractPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
