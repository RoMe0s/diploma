<?php

namespace App\Http\Resources\Author\Task\Chat;

use App\Models\Task\TaskMessage;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var TaskMessage $message */
        $message = $this->resource;

        return [
            'created_at' => $message->created_at->toDateTimeString(),
            'message' => $message->message,
            'user' => $this->whenLoaded('user', function () use ($message) {
                return [
                    'name' => $message->user->name,
                    'id' => $message->user_id
                ];
            })
        ];
    }
}
