<?php

namespace App\Http\Controllers\Api\Author;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;
use App\Services\Loaders\Author\Task as Loader;
use App\Http\Resources\Author\Task\IndexResource;
use App\Http\Resources\Author\Task\ShowResource;

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
}