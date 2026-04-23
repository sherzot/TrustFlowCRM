<?php

declare(strict_types=1);

namespace App\Policies;

final class AccountPolicy extends BasePolicy
{
    protected string $resource = 'accounts';
}
