<?php

namespace App\Models\Traits;

use App\Models\Order;

trait BelongsToOrder
{
    /**
     * @return mixed
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}