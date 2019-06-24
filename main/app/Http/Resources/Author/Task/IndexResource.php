<?php

namespace App\Http\Resources\Author\Task;

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
            'name' => $task->name,
            'date' => $task->date,
            'status' => $task->status,
            'expired_at' => $task->getExpiredAtDiff(),
            'has_expired_at' => (bool)$task->has_expired_at
        ];
    }
}
