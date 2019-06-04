<?php

namespace App\Http\Resources\Author\Order;

use App\Models\Plan\Plan;
use App\Models\Order\Order;
use App\Http\Resources\Plan\PlanResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Order $order */
        $order = $this->resource;

        return [
            'name' => $order->name,
            'price' => (float)$order->price,
            'description' => $order->description,
            'prices' => $this->whenLoaded('plan', function () use ($order) {
                /** @var Plan $plan */
                $plan = $order->plan;

                return [
                    'min' => round($plan->size_from / 1000 * $order->price, 2),
                    'max' => round($plan->size_to / 1000 * $order->price, 2),
                ];
            }),
            'plan' => PlanResource::make($this->whenLoaded('plan'))
        ];
    }
}