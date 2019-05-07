<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\Customer\Setting\UpdateOrCreateRequest;
use App\Services\Handlers\Customer\Setting\Delete;
use App\Services\Handlers\Customer\Setting\UpdateOrCreate;
use App\Services\Loaders\Customer\Setting as Loader;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * @param Request $request
     * @param Loader $loader
     * @return array
     */
    public function index(Request $request, Loader $loader)
    {
        $loader->setRelated($request->user());
        return $loader->get($request->all());
    }

    /**
     * @param string $check
     * @param UpdateOrCreateRequest $request
     * @param UpdateOrCreate $updateOrCreate
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateOrCreate(string $check, UpdateOrCreateRequest $request, UpdateOrCreate $updateOrCreate)
    {
        $updateOrCreate->updateOrCreate($check, $request->user(), $request->get('value'));
        return response()->json();
    }

    /**
     * @param string $check
     * @param Request $request
     * @param Delete $delete
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $check, Request $request, Delete $delete)
    {
        $delete->delete($check, $request->user());
        return response()->json();
    }
}
