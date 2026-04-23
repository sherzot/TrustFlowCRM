<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Lead;
use App\Models\User;

final class LeadPolicy extends BasePolicy
{
    protected string $resource = 'leads';

    /**
     * Convert a lead into Account + Contact.
     */
    public function convert(User $user, Lead $lead): bool
    {
        return $this->sameTenant($user, $lead)
            && $user->can('leads.convert')
            && $lead->status !== 'converted';
    }
}
