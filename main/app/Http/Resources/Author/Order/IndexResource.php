<?php

namespace App\Http\Resources\Author\Order;

use App\Models\Order\Order;
use App\Services\Price\Author;
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
            'name' => $order->getShowName(),
            'estimate' => $order->estimate,
            'prices' => [
                'min' => Author::convert($order->dirty_min_price / 1000),
                'max' => Author::convert($order->dirty_max_price / 1000)
            ],
            'sizes' => [
                'from' => $order->size_from,
                'to' => $order->size_to
            ]
        ];
    }
}
