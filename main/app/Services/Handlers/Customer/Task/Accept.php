<?php

namespace App\Services\Handlers\Customer\Task;

use App\Models\Text;
use App\Models\User;
use App\Models\Balance\Balance;
use App\Models\Task\Task;
use App\Models\Order\Commit;
use App\Models\Order\Order;
use App\Services\Price\Author as AuthorPrice;
use App\Services\Price\Customer as CustomerPrice;
use App\Constants\Status\Order as OrderStatus;
use App\Constants\Status\Commit as CommitStatus;
use App\Constants\Status\Task as TaskStatus;
use Illuminate\Support\Facades\DB;

class Accept
{
    /**
     * @param Task $task
     * @param User $user
     */
    public function accept(Task $task, User $user): void
    {
        DB::transaction(function () use ($task, $user) {
            $task->update(['status' => TaskStatus::DONE]);
            $task->order->update(['status' => OrderStatus::DONE]);
            $this->moveFunds($task, $user);
            Commit::query()->create([
                'status' => CommitStatus::DONE,
                'order_id' => $task->order_id,
                'user_id' => $task->user_id
            ]);
        });
    }

    /**
     * @param Task $task
     * @param User $customer
     */
    private function moveFunds(Task $task, User $customer): void
    {
        /** @var User $author */
        $author = $task->author;
        /** @var Order $order */
        $order = $task->order;
        /** @var Text $text */
        $text = $task->text;

        $priceWithoutTaxes = ($text->length / 1000) * $order->price;
        $customerPrice = CustomerPrice::convert($priceWithoutTaxes);
        $authorPrice = AuthorPrice::convert($priceWithoutTaxes);

        /** @var Balance $balance */
        $customerBalance = $customer->balance;
        /** @var Balance $balance */
        $authorBalance = $author->balance;

        $authorBalance->update(['amount' => $authorBalance->amount + $authorPrice]);
        if (($customerBalanceAmount = $customerBalance->amount - $customerPrice) < 0) {
            $customerBalanceAmount = 0;
        }
        $customerBalance->update(['amount' => $customerBalanceAmount]);
        $order->lockedChunk()->delete();
    }
}
