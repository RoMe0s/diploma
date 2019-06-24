<?php

namespace App\Services\Handlers\Author\Task;

use App\Models\Task\Task;
use App\Models\Order\Commit;
use App\Constants\Status\Order;
use Illuminate\Support\Facades\DB;
use App\Constants\Status\Commit as CommitStatus;

class Cancel
{
    /**
     * @param Task $task
     */
    public function cancel(Task $task): void
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
            'notify' => __('messages.canceled by the author'),
            'status' => CommitStatus::FAILED,
            'order_id' => $task->order_id,
            'user_id' => $task->user_id
        ]);
    }
}
