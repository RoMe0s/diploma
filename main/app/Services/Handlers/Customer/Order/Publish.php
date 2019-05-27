<?php

namespace App\Services\Handlers\Customer\Order;

use App\Models\Balance\Balance;
use App\Models\Order\Order;
use App\Constants\Status\Order as OrderStatus;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class Publish
{
    /**
     * @param Order $order
     * @param User $user
     */
    public function publish(Order $order, User $user): void
    {
        /** @var Balance $balance */
        $balance = $user->balance;
        DB::transaction(function () use ($order, $balance) {
            $order->update(['status' => OrderStatus::PUBLISHED]);
            $order->lockedChunk()->create([
                'balance_id' => $balance->getKey(),
                'amount' => $order->getTotalPrice()
            ]);
        });
    }
}