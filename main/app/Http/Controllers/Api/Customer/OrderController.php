<?php

namespace App\Http\Controllers\Api\Customer;

use App\Models\Order\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;
use App\Services\Handlers\Customer\Order\Store;
use App\Http\Requests\Customer\Order\SaveRequest;
use App\Services\Loaders\Customer\Order as Loader;
use App\Http\Requests\Customer\Order\ActionRequest;
use App\Http\Requests\Customer\Order\PublishRequest;
use App\Services\Handlers\Customer\Order\Delete;
use App\Services\Handlers\Customer\Order\Update;
use App\Http\Resources\Customer\Order\ShowResource;
use App\Http\Resources\Customer\Order\IndexResource;
use App\Services\Handlers\Customer\Order\Publish;
use App\Services\Handlers\Customer\Order\Rollback;

class OrderController extends Controller
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
     * @param Order $order
     * @return array
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Request $request, Order $order)
    {
        $this->authorize('view', $order);
        $order->load(['relation', 'plan.blocks.settingBlocks', 'plan.blocks.keys']);
        return ShowResource::make($order)->resolve($request);
    }

    /**
     * @param SaveRequest $request
     * @param Store $store
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SaveRequest $request, Store $store)
    {
        $order = $store->store($request->validated(), $request->user());
        return response()->json($order);
    }

    /**
     * @param Order $order
     * @param SaveRequest $request
     * @param Update $update
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Order $order, SaveRequest $request, Update $update)
    {
        $this->authorize('update', $order);
        $update->update($order, $request->user(), $request->validated());
        return response()->json();
    }

    /**
     * @param Order $order
     * @param Delete $delete
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Order $order, Delete $delete)
    {
        $this->authorize('delete', $order);
        $delete->delete($order->id);
        return response()->json();
    }

    /**
     * @param ActionRequest $request
     * @param Delete $delete
     * @return \Illuminate\Http\JsonResponse
     */
    public function action(ActionRequest $request, Delete $delete)
    {
        $delete->delete($request->get('orders', []));
        return response()->json();
    }

    /**
     * @param Order $order
     * @param PublishRequest $request
     * @param Publish $publish
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function publish(Order $order, PublishRequest $request, Publish $publish)
    {
        $this->authorize('update', $order);
        $publish->publish($order, $request->user());
        return response()->json();
    }

    /**
     * @param Order $order
     * @param Rollback $rollback
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function rollback(Order $order, Rollback $rollback)
    {
        $this->authorize('rollback', $order);
        $rollback->rollback($order);
        return response()->json();
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
}
