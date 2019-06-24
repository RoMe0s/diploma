<?php

namespace App\Services\Handlers\Customer\Task;

use App\Models\User;
use App\Models\Task\Task;
use App\Models\Order\Commit;
use Illuminate\Support\Facades\DB;
use App\Constants\Status\Task as TaskStatus;
use App\Constants\Status\Commit as CommitStatus;

class Rollback
{
    /**
     * @param Task $task
     * @param User $user
     * @param string $reason
     */
    public function rollback(Task $task, User $user, string $reason): void
    {
        DB::transaction(function () use ($task, $user, $reason) {
            Commit::query()->create([
                'notice' => __('messages.task rolled back to author'),
                'status' => CommitStatus::WRITING,
                'order_id' => $task->order_id,
                'user_id' => $task->user_id
            ]);
            $task->update([
                'status' => TaskStatus::WRITING,
                'expired_at' => now()->addHours(12) //TODO: answer customer
            ]);
            $task->messages()->create([
                'user_id' => $user->id,
                'message' => $reason
            ]);
        });
    }
}
