<?php

declare(strict_types=1);

namespace App\Policies;

final class ContactPolicy extends BasePolicy
{
    protected string $resource = 'contacts';
}
