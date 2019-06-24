<?php

namespace App\Services\Handlers\Task\Chat;

use App\Models\User;
use App\Models\Task\Task;
use App\Models\Task\TaskMessage;

class Send
{
    /**
     * @param Task $task
     * @param User $user
     * @param string $message
     * @return TaskMessage
     */
    public function send(Task $task, User $user, string $message): TaskMessage
    {
        return $task->messages()->create([
            'user_id' => $user->id,
            'message' => $message
        ]);
    }
}
