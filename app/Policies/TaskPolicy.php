<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

final class TaskPolicy extends BasePolicy
{
    protected string $resource = 'tasks';

    public function complete(User $user, Task $task): bool
    {
        return $this->sameTenant($user, $task) && $user->can('tasks.update');
    }
}
