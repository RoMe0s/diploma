<?php

namespace App\Services\Handlers\Author\Task\Strategies;

use Carbon\Carbon;
use App\Models\Task\Task;
use App\Models\Order\Commit;
use App\Constants\Status\Order;
use Illuminate\Support\Facades\DB;
use App\Constants\Status\Commit as CommitStatus;

class Failed implements StrategyInterface
{
    /**
     * @param Task $task
     * @param array|null $params
     * @return bool
     */
    public static function support(Task $task, array $params = null): bool
    {
        return is_a($task->expired_at, Carbon::class) && now()->gte($task->expired_at);
    }

    /**
     * @param Task $task
     * @param array|null $params
     */
    public function apply(Task $task, array $params = null): void
    {
        DB::transaction(function () use ($task) {
            $task->order()->update(['status' => Order::PUBLISHED]);
            $this->createCommit($task);
            $task->delete();
        });
    }

    /**
     * @param Task $task
     */
    private function createCommit(Task $task): void
    {
        Commit::query()->create([
            'status' => CommitStatus::FAILED,
            'order_id' => $task->order_id,
            'user_id' => $task->user_id
        ]);
    }
}