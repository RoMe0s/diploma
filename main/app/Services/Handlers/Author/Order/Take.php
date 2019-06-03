<?php

namespace App\Services\Handlers\Author\Order;

use App\Models\User;
use App\Models\Order\Order;
use App\Constants\Status\Task;
use Illuminate\Support\Facades\DB;
use App\Constants\Status\Order as OrderStatus;
use App\Constants\Status\Commit;

class Take
{
    /**
     * @param Order $order
     * @param User $user
     */
    public function take(Order $order, User $user): void
    {
        DB::transaction(function () use ($order, $user) {
            $order->update(['status' => OrderStatus::IN_WORK]);
            $this->createTask($order, $user);
            $this->createCommit($order, $user);
        });
    }

    /**
     * @param Order $order
     * @param User $user
     */
    private function createTask(Order $order, User $user): void
    {
        $order->task()->create([
            'expired_at' => now()->addHours($order->estimate)->startOfMinute(),
            'status' => Task::WRITING,
            'user_id' => $user->id,
            'text_id' => null
        ]);
    }

    /**
     * @param Order $order
     * @param User $user
     */
    private function createCommit(Order $order, User $user): void
    {
        $order->commits()->create([
            'status' => Commit::WRITING,
            'user_id' => $user->id
        ]);
    }
}