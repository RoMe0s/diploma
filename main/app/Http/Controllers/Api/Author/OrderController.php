<?php

namespace App\Http\Controllers\Api\Author;

use App\Models\Order\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;
use App\Services\Handlers\Author\Order\Take;
use App\Services\Loaders\Author\Order as Loader;
use App\Http\Resources\Author\Order\IndexResource;

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
     * @param Order $order
     * @param Request $request
     * @param Take $take
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function append(Order $order, Request $request, Take $take)
    {
        $this->authorize('append', $order);
        $take->take($order, $request->user());
        return response()->json();
    }
}