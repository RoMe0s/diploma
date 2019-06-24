<?php

namespace App\Policies\Author;

use App\Models\User;
use App\Models\Task\Task;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param Task $task
     * @return bool
     */
    public function view(User $user, Task $task): bool
    {
        if ($user->isCustomer()) {
            return $task->onPaying() && $task->belongsToCustomer($user);
        }
        return $user->id === $task->user_id;
    }

    /**
     * @param User $user
     * @param Task $task
     * @return bool
     */
    public function update(User $user, Task $task): bool
    {
        return $task->isEditable() && $user->id === $task->user_id;
    }

    /**
     * @param User $user
     * @param Task $task
     * @return bool
     */
    public function accept(User $user, Task $task): bool
    {
        return $user->isCustomer()
            && $task->onPaying()
            && $task->belongsToCustomer($user);
    }
}
