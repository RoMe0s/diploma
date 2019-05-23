<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\Customer\Setting\UpdateOrCreateRequest;
use App\Models\Project;
use App\Services\Handlers\Customer\Setting\Delete;
use App\Services\Handlers\Customer\Setting\UpdateOrCreate;
use App\Services\Loaders\Customer\Setting as Loader;
use Illuminate\Http\Request;

class ProjectSettingController extends Controller
{
    /**
     * @param Project $project
     * @param Request $request
     * @param Loader $loader
     * @return array
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Project $project, Request $request, Loader $loader)
    {
        $this->authorize('view', $project);
        $loader->setRelated($project);
        return $loader->get($request->all());
    }

    /**
     * @param Project $project
     * @param string $check
     * @param UpdateOrCreateRequest $request
     * @param UpdateOrCreate $updateOrCreate
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function updateOrCreate(
        Project $project,
        string $check,
        UpdateOrCreateRequest $request,
        UpdateOrCreate $updateOrCreate
    )
    {
        $this->authorize('update', $project);
        $updateOrCreate->updateOrCreate($check, $project, $request->get('value'));
        return response()->json();
    }

    /**
     * @param Project $project
     * @param string $check
     * @param Request $request
     * @param Delete $delete
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Project $project, string $check, Request $request, Delete $delete)
    {
        $this->authorize('delete', $project);
        $delete->delete($check, $project);
        return response()->json();
    }
}
