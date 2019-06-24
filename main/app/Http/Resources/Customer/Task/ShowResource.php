<?php

namespace App\Http\Resources\Customer\Task;

use App\Models\Task\Task;
use App\Services\Price\Customer;
use App\Http\Resources\Text\ShowResource as Text;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Customer\Order\ShowResource as Order;
use App\Http\Resources\Customer\Task\SettingResource;

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
            'settings' => SettingResource::collection($this->whenLoaded('settings')),
            $this->mergeWhen($this->whenLoaded('order'), function () use ($task) {
                return array_merge(
                    ['order' => Order::make($task->order)],
                    $this->whenLoaded('text', function () use ($task) {
                        $withoutTaxes = ($task->text->length / 1000) * $task->order->price;

                        return [
                            'price' => Customer::convert($withoutTaxes),
                            'text' => Text::make($this->whenLoaded('text'))
                        ];
                    }, [])
                );
            })
        ];
    }
}
