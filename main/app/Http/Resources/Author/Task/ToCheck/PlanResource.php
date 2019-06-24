<?php

namespace App\Http\Resources\Author\Task\ToCheck;

use App\Constants\Plan\Heading;
use App\Models\Plan\Plan as PlanModel;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Plan\BlockResource;

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
                return BlockResource::collection($blocks)->resolve();
            }),
            'opening_block' => $this->whenLoaded('blocks', function () {
                $block = $this->blocks->where('heading', Heading::OPENING)->first();
                if ($block) {
                    return BlockResource::make($block)->resolve();
                }
            }),
            'sizes' => [
                'from' => (int)$plan->size_from,
                'to' => (int)$plan->size_to
            ]
        ];
    }
}
