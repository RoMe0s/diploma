<?php

namespace App\Http\Resources\Text;

use App\Models\Text;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Text $text */
        $text = $this->resource;

        return [
            'name' => $text->name,
            'length' => $text->length,
            'content' => $text->content
        ];
    }
}