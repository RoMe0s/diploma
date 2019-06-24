<?php

namespace App\Http\Resources\Customer\Order;

use App\Models\Order\Order;
use App\Services\Price\Customer;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Order $order */
        $order = $this->resource;

        return [
            'id' => $order->id,
            'name' => $order->name,
            'date' => $order->date,
            'status' => $order->status,
            'price' => Customer::convert($order->dirty_price / 1000),
            'can_be_published' => $order->canBePublished(),
            'can_be_rolled_back' => $order->canBeRolledBack()
        ];
    }
}
