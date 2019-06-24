<?php

namespace App\Services\Handlers\Author\Task\Strategies;

use App\Models\Task\Task;
use App\Models\Order\Commit;
use App\Constants\Status\Task as TaskStatus;
use App\Constants\Status\Commit as CommitStatus;
use Illuminate\Support\Facades\DB;

class ToCustomerCheck implements StrategyInterface
{
    /**
     * @param Task $task
     * @param array|null $params
     * @return bool
     */
    public static function support(Task $task, array $params = null): bool
    {
        if ($task->status === TaskStatus::WRITING) {
            return $task->order->commits->last()->status === CommitStatus::CHECKING
                && $task->checks->isEmpty();
        }
        return false;
    }

    /**
     * @param Task $task
     * @param array|null $params
     */
    public function apply(Task $task, array $params = null): void
    {
        DB::transaction(function () use ($task) {
            Commit::query()->create([
                'status' => CommitStatus::PAYING,
                'order_id' => $task->order_id,
                'user_id' => $task->user_id
            ]);
            $task->update([
                'status' => TaskStatus::PAYING,
                'expired_at' => NULL
            ]);
        });
    }
}
