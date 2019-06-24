<?php

namespace App\Http\Resources\Author\Task;

use App\Models\Task\Task;
use Illuminate\Http\Resources\Json\JsonResource;

class DoneResource extends JsonResource
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
            'name' => $task->name,
            'date' => $task->date
        ];
    }
}
