<?php

namespace App\Services\Handlers\Author\Task;

use App\Models\Task;
use App\Constants\Status\Task as Status;

class ToCheck
{
    /**
     * @param Task $task
     */
    public function toCheck(Task $task): void
    {
        $task->update(['status' => Status::CHECKING]);
        //TODO: add sending request to Elixir
    }
}