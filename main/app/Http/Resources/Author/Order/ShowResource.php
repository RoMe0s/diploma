<?php

namespace App\Http\Resources\Author\Order;

use App\Models\Plan\Plan;
use App\Models\Order\Order;
use App\Services\Price\Author;
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
            'price' => Author::convert($order->price),
            'description' => $order->description,
            'prices' => $this->whenLoaded('plan', function () use ($order) {
                /** @var Plan $plan */
                $plan = $order->plan;

                return [
                    'min' => Author::convert($plan->size_from / 1000 * $order->price),
                    'max' => Author::convert($plan->size_to / 1000 * $order->price),
                ];
            }),
            'plan' => PlanResource::make($this->whenLoaded('plan'))
        ];
    }
}
