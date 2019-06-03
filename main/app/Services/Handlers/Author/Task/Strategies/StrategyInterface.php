<?php

namespace App\Services\Handlers\Author\Task\Strategies;

use App\Models\Task;

interface StrategyInterface
{
    /**
     * @param Task $task
     * @param array|null $params
     * @return bool
     */
    public static function support(Task $task, array $params = null): bool;

    /**
     * @param Task $task
     * @param array|null $params
     */
    public function apply(Task $task, array $params = null): void;
}