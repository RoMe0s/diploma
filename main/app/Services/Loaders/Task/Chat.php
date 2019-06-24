<?php

namespace App\Services\Loaders\Task;

use App\Models\Task\Task;
use App\Models\Task\TaskMessage;
use Illuminate\Database\Eloquent\Builder;
use App\Services\Loaders\Loader;

class Chat extends Loader
{
    /**
     * @var
     */
    private $task;

    /**
     * @param Task $task
     */
    public function setTask(Task $task): void
    {
        $this->task = $task;
    }

    /**
     * @param array $config
     * @return Builder
     */
    protected function prepareQuery(array $config): Builder
    {
        return TaskMessage::query()->with('user')
            ->where('task_id', $this->task->id);
    }
}
