<?php

namespace App\Http\Controllers\Api\Customer\Task;

use App\Models\Task\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;
use App\Services\Handlers\Task\Chat\Send;
use App\Services\Loaders\Task\Chat as Loader;
use App\Http\Resources\Task\Chat\IndexResource;
use App\Http\Requests\Task\Chat\StoreRequest;

class ChatController extends Controller
{
    /**
     * @param Task $task
     * @param Request $request
     * @param Loader $loader
     * @return array
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Task $task, Request $request, Loader $loader)
    {
        $this->authorize('view', $task);
        $loader->setTask($task);
        $messages = $loader->query($request->all())->get();
        $messages = IndexResource::collection($messages)->resolve($request);
        return ['sender' => $request->user(), 'messages' => $messages];
    }

    /**
     * @param Task $task
     * @param StoreRequest $request
     * @param Send $send
     * @return array
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Task $task, StoreRequest $request, Send $send)
    {
        $this->authorize('view', $task);
        $message = $send->send($task, $request->user(), $request->get('message'));
        return IndexResource::make($message->load('user'))->resolve($request);
    }
}
