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
     * @param Task $task
     * @param Request $request
     * @return array
     */
    public function show(Task $task, Request $request)
    {
        $this->author('view', $task);
        $task->load(['order']);
        return ShowResource::make($task)->resolve($request);
    }
}