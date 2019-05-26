<?php

namespace App\Services\Handlers\Customer\Order;

use App\Models\Order\Order;

class Delete
{
    /**
     * @param $orders
     */
    public function delete($orders): void
    {
        $orders = is_array($orders) ? $orders : [$orders];
        Order::query()->whereIn('id', $orders)->delete();
    }
}
