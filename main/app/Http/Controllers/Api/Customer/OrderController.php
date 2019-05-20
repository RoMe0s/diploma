<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Customer\Order\StoreRequest;
use App\Services\Loaders\Customer\Order as Loader;

class OrderController extends Controller
{
    /**
     * @param Request $request
     * @param Loader $loader
     * @return array
     */
    public function index(Request $request, Loader $loader)
    {
        $loader->setRelation($request->user());
        return $loader->paginate($request->all());
    }

    /**
     * @param StoreRequest $request
     */
    public function store(StoreRequest $request)
    {

    }
}