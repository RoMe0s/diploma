<?php

namespace App\Http\Resources\Author\Task;

use App\Models\Task\Task;
use App\Http\Resources\Text\ShowResource as Text;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Author\Order\ShowResource as Order;
use App\Http\Resources\Author\Task\SettingResource;
use App\Http\Resources\Author\Task\CheckResource;

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
            'status' => $task->status,
            'is_editable' => $task->isEditable(),
            'expired_at' => $task->getExpiredAtDiff(),
            'text' => Text::make($this->whenLoaded('text')),
            'order' => Order::make($this->whenLoaded('order')),
            'settings' => SettingResource::collection($this->whenLoaded('settings')),
            'checks' => CheckResource::collection($this->whenLoaded('checks'))
        ];
    }
}
