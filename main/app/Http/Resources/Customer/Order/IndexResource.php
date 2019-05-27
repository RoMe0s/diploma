<?php

namespace App\Http\Resources\Customer\Order;

use App\Models\Order\Order;
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
            'date' => $order->date,
            'name' => $order->name,
            'status' => $order->status,
            'can_be_published' => $order->canBePublished(),
            'can_be_rolled_back' => $order->canBeRolledBack()
        ];
    }
}