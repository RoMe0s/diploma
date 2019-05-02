<?php

namespace App\Http\Controllers\Web\Customer;

use App\Models\Project;
use App\Http\Controllers\Web\Controller;

class ProjectController extends Controller
{
    /**
     * @return string
     */
    protected function viewPath(): string
    {
        return 'customer.projects';
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return $this->render('index');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return $this->render('create');
    }

    /**
     * @param Project $project
     * @return \Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Project $project)
    {
        $this->authorize('view', $project);
        return $this->render('edit', compact('project'));
    }
}
