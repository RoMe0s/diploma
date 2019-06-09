<?php

namespace App\Services\Setting;

use App\Models\Project;
use App\Models\Order\Order;
use Illuminate\Support\Collection;

class Helper
{
    /**
     * @param Order $order
     * @return Collection
     */
    public function getForOrder(Order $order): Collection
    {
        if ($order->settings->isNotEmpty()) {
            return $order->settings;
        }
        $relation = $order->relation;
        if (is_a($relation, Project::class) && $relation->settings->isNotEmpty()) {
            return $relation->settings;
        }
        return $relation->customer->settings;
    }
}
