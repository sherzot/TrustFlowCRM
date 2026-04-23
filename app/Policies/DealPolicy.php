<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Deal;
use App\Models\User;

final class DealPolicy extends BasePolicy
{
    protected string $resource = 'deals';

    public function win(User $user, Deal $deal): bool
    {
        return $this->sameTenant($user, $deal)
            && $user->can('deals.win')
            && $deal->status === 'open';
    }

    public function lose(User $user, Deal $deal): bool
    {
        return $this->sameTenant($user, $deal)
            && $user->can('deals.lose')
            && $deal->status === 'open';
    }

    public function approve(User $user, Deal $deal): bool
    {
        return $this->sameTenant($user, $deal)
            && ($user->can('deals.approve')
                || $user->hasAnyRole(['admin', 'manager', 'super_admin']));
    }
}
