<?php

namespace App\Services\Handlers\Author\Task;

use App\Models\Task;
use App\Services\Handlers\Author\Task\Strategies\StrategyInterface;

final class Director
{
    /**
     * @var
     */
    private $strategy;

    /**
     * @param StrategyInterface $strategy
     */
    public function setStrategy(StrategyInterface $strategy): void
    {
        $this->strategy = $strategy;
    }

    /**
     * @param Task $task
     * @param array|null $params
     */
    public function apply(Task $task, array $params = null): void
    {
        if (!$this->strategy) {
            $this->chooseStrategy($task, $params);
        }
        $this->strategy->apply($task, $params);
    }

    /**
     * @param Task $task
     * @param array|null $params
     */
    private function chooseStrategy(Task $task, array $params = null): void
    {
        foreach ($this->strategies() as $strategyClass) {
            if ($strategyClass::support($task, $params)) {
                $this->strategy = resolve($strategyClass);
                break;
            }
        }
    }

    /**
     * @return array
     */
    private function strategies(): array
    {
        return [];
    }
}