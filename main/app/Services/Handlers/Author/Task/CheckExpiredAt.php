<?php

namespace App\Services\Handlers\Author\Task;

use App\Models\Task;
use App\Events\Author\Task\TimeIsOver;

class CheckExpiredAt
{
    public function check(): void
    {
        Task::query()->where('expired_at', '<=', now()->toDateTimeString())
            ->whereNotNull('expired_at')->get()->each(function (Task $task) {
                TimeIsOver::dispatch($task);
            });
    }
}