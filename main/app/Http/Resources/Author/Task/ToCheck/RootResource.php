<?php

namespace App\Http\Resources\Author\Task\ToCheck;

use App\Models\Task\Task;
use App\Models\Order\Order;
use App\Http\Resources\Author\Task\SettingResource;
use Illuminate\Http\Resources\Json\JsonResource;

class RootResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Task $task */
        $task = $this->resource;
        /** @var Order $order */
        $order = $task->order;

        return [
            'callback_url' => 'http://webserver/check/' . $task->id,
            'html' => $this->whenLoaded('text', $task->text->content),
            'plan' => PlanResource::make($order->plan)->resolve(),
            'settings' => SettingResource::collection($this->whenLoaded('settings'))->resolve()
        ];
    }
}
