<?php

namespace App\Http\Resources\Plan;

use App\Models\Plan\SettingBlock;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingBlockResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var SettingBlock $settingBlock */
        $settingBlock = $this->resource;

        return [
            'type' => $settingBlock->type,
            'min' => $settingBlock->min,
            'max' => $settingBlock->max
        ];
    }
}
