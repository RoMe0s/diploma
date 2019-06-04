<?php

namespace App\Http\Resources\Customer\Order;

use App\Models\Project;
use App\Models\Order\Order;
use App\Http\Resources\Plan\PlanResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowResource extends JsonResource
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
            'name' => $order->name,
            'price' => (float)$order->price,
            'description' => $order->description,
            'estimate' => (int)$order->estimate,
            'project_id' => $this->getProjectId($order),
            'can_be_published' => $order->canBePublished(),
            'can_be_rolled_back' => $order->canBeRolledBack(),
            'plan' => PlanResource::make($this->whenLoaded('plan'))
        ];
    }

    /**
     * @param Order $order
     * @return int|null
     */
    private function getProjectId(Order $order): ?int
    {
        if ($order->relation_type === Project::class) {
            return $order->relation_id;
        }
        return null;
    }
}