<?php

namespace App\Http\Resources\Author\Task;

use App\Models\Task\Check;
use App\Services\Checks\Translator;
use Illuminate\Http\Resources\Json\JsonResource;

class CheckResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     * @throws \Exception
     */
    public function toArray($request)
    {
        /** @var Check $check */
        $check = $this->resource;
        $translator = new Translator($check->task);
        $translated = $translator->translate($check->key, $check->value);

        return [
            'key' => $check->key,
            'value' => $check->value,
            'translated' => $translated
        ];
    }
}
