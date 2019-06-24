<?php

namespace App\Http\Resources\Customer\Task;

use App\Models\Task\Task;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Task $task */
        $task = $this->resource;

        return [
            'id' => $task->id,
            'date' => $task->date,
            'name' => $task->name
        ];
    }
}
