<?php

namespace App\Http\Controllers\Api\Author;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;
use App\Services\Handlers\Author\Task\Update;
use App\Services\Handlers\Author\Task\ToCheck;
use App\Services\Loaders\Author\Task as Loader;
use App\Http\Resources\Author\Task\IndexResource;
use App\Http\Resources\Author\Task\ShowResource;
use App\Http\Requests\Author\Task\UpdateRequest;

class TaskController extends Controller
{
    /**
     * @param Request $request
     * @param Loader $loader
     * @return array
     */
    public function index(Request $request, Loader $loader)
    {
        $loader->setUser($request->user());
        $paginated = $loader->paginate($request->all());
        $resource = IndexResource::collection($paginated['rows']);
        $paginated['rows'] = $resource->resolve($request);
        return $paginated;
    }

    /**
     * @param Request $request
     * @param Loader $loader
     * @return \Illuminate\Http\JsonResponse
     */
    public function count(Request $request, Loader $loader)
    {
        $loader->setUser($request->user());
        $count = $loader->query(['active' => true])->count();
        return response()->json(compact('count'));
    }

    /**
     * @param Task $task
     * @param Request $request
     * @return array
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Task $task, Request $request)
    {
        $this->authorize('view', $task);
        $task->load(['text', 'order.plan.blocks' => function ($q) {
            $q->with(['settingBlocks', 'keys']);
        }]);
        return ShowResource::make($task)->resolve($request);
    }

    /**
     * @param Task $task
     * @param UpdateRequest $request
     * @param Update $update
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Task $task, UpdateRequest $request, Update $update)
    {
        $this->authorize('update', $task);
        $update->update($task, $request->validated());
        return response()->json();
    }

    /**
     * @param Task $task
     * @param ToCheck $toCheck
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function toCheck(Task $task, ToCheck $toCheck)
    {
        $this->authorize('update', $task);
        $toCheck->toCheck($task);
        return response()->json();
    }
}