<?php

namespace App\Http\Controllers\Web\Customer;

use App\Models\Project;
use App\Http\Controllers\Web\Controller;

/**
 * Class ProjectSettingController
 * @package App\Http\Controllers\Web\Customer
 */
class ProjectSettingController extends Controller
{
    /**
     * @param Project $project
     * @return \Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Project $project)
    {
        $this->authorize('view', $project);
        return $this->render('customer.projects.settings.index', compact('project'));
    }
}
