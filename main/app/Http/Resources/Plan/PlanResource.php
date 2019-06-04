<?php

namespace App\Http\Resources\Plan;

use App\Constants\Plan\Heading;
use App\Models\Plan\Plan as PlanModel;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var PlanModel $plan */
        $plan = $this->resource;

        return [
            'blocks' => $this->whenLoaded('blocks', function () {
                $blocks = $this->blocks->whereIn('heading', Heading::ALL);
                return BlockResource::collection($blocks);
            }),
            'openingBlock' => $this->whenLoaded('blocks', function () {
                $block = $this->blocks->where('heading', Heading::OPENING)->first();
                if ($block) {
                    return BlockResource::make($block);
                }
            }),
            'closingBlock' => $this->whenLoaded('blocks', function () {
                $block = $this->blocks->where('heading', Heading::CLOSING)->first();
                if ($block) {
                    return BlockResource::make($block);
                }
            }),
            'sizes' => [
                'from' => (int)$plan->size_from,
                'to' => (int)$plan->size_to
            ]
        ];
    }
}