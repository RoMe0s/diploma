<?php

namespace App\Http\Resources\Customer\Plan;

use App\Models\Plan\Key;
use Illuminate\Http\Resources\Json\JsonResource;

class KeyResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Key $key */
        $key = $this->resource;

        return [
            'value' => $key->value,
            'count' => $key->count,
            'type' => $key->type
        ];
    }
}