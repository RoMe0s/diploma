<?php

namespace App\Services\Handlers\Customer\Order;

use App\Constants\Status\Order as OrderStatus;
use App\Models\Order\Order;
use Illuminate\Support\Facades\DB;

class Rollback
{
    /**
     * @param Order $order
     */
    public function rollback(Order $order): void
    {
        DB::transaction(function () use ($order) {
            $order->update(['status' => OrderStatus::DRAFT]);
            $order->lockedChunk()->delete();
        });
    }
}