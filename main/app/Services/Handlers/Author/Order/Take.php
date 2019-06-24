<?php

namespace App\Services\Handlers\Author\Order;

use App\Models\User;
use App\Models\Text;
use App\Models\Task\Task;
use App\Models\Order\Order;
use Illuminate\Support\Facades\DB;
use App\Constants\Status\Task as TaskStatus;
use App\Constants\Status\Order as OrderStatus;
use App\Services\Setting\Helper;
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
            $text = $this->createText($order);
            $task = $this->createTask($order, $user, $text);
            $this->assignSettings($task, $order);
            $this->createCommit($order, $user);
        });
    }

    /**
     * @param Order $order
     * @return Text
     */
    private function createText(Order $order): Text
    {
        return $order->text()->create([
            'name' => $order->name
        ]);
    }

    /**
     * @param Order $order
     * @param User $user
     * @param Text $text
     * @return Task
     */
    private function createTask(Order $order, User $user, Text $text): Task
    {
        return $order->task()->create([
            'expired_at' => now()->addHours($order->estimate)->startOfMinute(),
            'status' => TaskStatus::WRITING,
            'user_id' => $user->id,
            'text_id' => $text->id
        ]);
    }

    /**
     * @param Task $task
     * @param Order $order
     */
    private function assignSettings(Task $task, Order $order): void
    {
        foreach ((new Helper)->getForOrder($order) as $setting) {
            $task->settings()->create([
                'key' => $setting->key,
                'value' => $setting->value
            ]);
        }
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
