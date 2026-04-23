<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Contract;
use App\Models\User;

final class ContractPolicy extends BasePolicy
{
    protected string $resource = 'contracts';

    public function sign(User $user, Contract $contract): bool
    {
        return $this->sameTenant($user, $contract)
            && $user->can('contracts.sign');
    }
}
