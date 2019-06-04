<?php

namespace App\Http\Resources\Author\Task;

use App\Models\Task;
use App\Http\Resources\Text\ShowResource as Text;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Author\Order\ShowResource as Order;

class ShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Task $task */
        $task = $this->resource;

        return [
            'expired_at' => $task->getExpiredAtDiff(),
            'text' => Text::make($this->whenLoaded('text')),
            'order' => Order::make($this->whenLoaded('order'))
        ];
    }
}