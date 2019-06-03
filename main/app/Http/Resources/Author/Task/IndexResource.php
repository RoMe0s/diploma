<?php

namespace App\Http\Resources\Author\Task;

use App\Models\Task;
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
            'status' => $task->status,
            'name' => $this->getShowName($task),
            'expired_at' => $this->getExpiredAtDiff($task),
            'has_expired_at' => (bool)$task->has_expired_at
        ];
    }

    /**
     * @param Task $task
     * @return string|null
     */
    private function getExpiredAtDiff(Task $task): ?string
    {
        if ($task->expired_at && $task->expired_at->gt(now())) {
            return $task->expired_at->diffForHumans();
        }
        return null;
    }

    /**
     * @param Task $task
     * @return string|null
     */
    private function getShowName(Task $task): ?string
    {
        if ($task->name) {
            return $task->name;
        }
        $description = $task->description;
        if ($description && mb_strlen($description) > 75) {
            $description = mb_substr($description, 0, 75) . '...';
        }
        return $description;
    }
}