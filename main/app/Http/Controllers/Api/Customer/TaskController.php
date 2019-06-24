<?php

namespace App\Http\Controllers\Api\Customer;

use App\Models\Task\Task;
use Illuminate\Http\Request;
use App\Services\Loaders\Customer\Task as Loader;
use App\Http\Resources\Customer\Task\IndexResource;
use App\Http\Resources\Customer\Task\ShowResource;
use App\Services\Handlers\Customer\Task\Accept;
use App\Services\Handlers\Customer\Task\Rollback;
use App\Http\Controllers\Api\Controller;

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
        $count = $loader->query([])->count();
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
        $task->load('order');
        $this->authorize('view', $task);
        $task->loadMissing([
            'text',
            'settings',
            'checks.task.order.plan.blocks',
            'order.plan.blocks' => function ($q) {
                $q->with(['settingBlocks', 'keys']);
            }
        ]);
        return ShowResource::make($task)->resolve($request);
    }

    /**
     * @param Task $task
     * @param Request $request
     * @param Accept $accept
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function accept(Task $task, Request $request, Accept $accept)
    {
        $task->load('order');
        $this->authorize('accept', $task);
        $accept->accept($task, $request->user());
        return response()->json();
    }

    /**
     * @param Task $task
     * @param Request $request
     * @param Rollback $rollback
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function rollback(Task $task, Request $request, Rollback $rollback)
    {
        $task->load('order');
        $this->authorize('accept', $task);
        $rollback->rollback($task, $request->user(), $request->get('reason'));
        return response()->json();
    }
}
