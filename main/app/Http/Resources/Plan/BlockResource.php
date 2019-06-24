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
            'settings' => SettingBlockResource::collection($this->whenLoaded('settingBlocks'))->resolve(),
            'keys' => KeyResource::collection($this->whenLoaded('keys'))->resolve(),
            'sizes' => [
                'from' => (int)$block->size_from,
                'to' => (int)$block->size_to
            ]
        ];
    }
}
