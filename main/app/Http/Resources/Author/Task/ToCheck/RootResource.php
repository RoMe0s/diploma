<?php

namespace App\Http\Resources\Author\Task\ToCheck;

use App\Models\Task;
use App\Models\Order\Order;
use App\Services\Setting\Helper;
use App\Http\Resources\Plan\PlanResource;
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

        $array =  [
            'html' => $this->whenLoaded('text', $task->text->content),
            'plan' => PlanResource::make($order->plan)
        ];

        if ($settings = (new Helper)->getForOrder($order)) {
            $array['setting'] = SettingResource::collection($settings);
        }

        return $array;
    }
}
