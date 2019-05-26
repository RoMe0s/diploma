<?php

namespace App\Http\Resources\Plan;

use App\Models\Plan\Block;
use Illuminate\Http\Resources\Json\JsonResource;

class BlockResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Block $block */
        $block = $this->resource;

        return [
            'name' => $block->name,
            'heading' => $block->heading,
            'description' => $block->description,
            'settings' => SettingBlockResource::collection($this->whenLoaded('settingBlocks')),
            'keys' => KeyResource::collection($this->whenLoaded('keys')),
            'sizes' => [
                'from' => $block->size_from,
                'to' => $block->size_to
            ]
        ];
    }
}
