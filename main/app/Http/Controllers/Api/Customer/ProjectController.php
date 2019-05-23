<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Requests\Customer\Project\ActionRequest;
use App\Models\Project;
use App\Services\Handlers\Customer\Project\Delete;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;
use App\Services\Loaders\Customer\Project as Loader;
use App\Http\Requests\Customer\Project\UpdateRequest;
use App\Http\Requests\Customer\Project\StoreRequest;
use App\Services\Handlers\Customer\Project\Update;
use App\Services\Handlers\Customer\Project\Store;

class ProjectController extends Controller
{

    /**
     * @param Request $request
     * @param Loader $loader
     * @return array
     */
    public function index(Request $request, Loader $loader)
    {
        $loader->setUser($request->user());
        return $loader->paginate($request->all());
    }

    /**
     * @param Request $request
     * @param Loader $loader
     * @return \Illuminate\Support\Collection
     */
    public function compact(Request $request, Loader $loader)
    {
        $loader->setUser($request->user());
        $query = $loader->query($request->all());
        return $query->pluck('name', 'id');
    }

    /**
     * @param StoreRequest $request
     * @param Store $store
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request, Store $store)
    {
        $project = $store->store($request->validated(), $request->user());
        return response()->json($project);
    }

    /**
     * @param Project $project
     * @param UpdateRequest $request
     * @param Update $update
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Project $project, UpdateRequest $request, Update $update)
    {
        $this->authorize('update', $project);
        $update->update($project, $request->validated());
        return response()->json();
    }

    /**
     * @param Project $project
     * @param Delete $delete
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Project $project, Delete $delete)
    {
        $this->authorize('delete', $project);
        $delete->delete($project->id);
        return response()->json();
    }

    /**
     * @param ActionRequest $request
     * @param Delete $delete
     * @return \Illuminate\Http\JsonResponse
     */
    public function action(ActionRequest $request, Delete $delete)
    {
        $delete->delete($request->get('projects', []));
        return response()->json();
    }
}
