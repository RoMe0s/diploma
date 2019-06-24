<?php

namespace App\Http\Controllers\Web\Customer;

use App\Models\Task\Task;
use App\Http\Controllers\Web\Controller;

class TaskController extends Controller
{
    /**
     * @return string
     */
    protected function viewPath(): string
    {
        return 'customer.tasks';
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return $this->render('index');
    }

    /**
     * @param Task $task
     * @return \Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Task $task)
    {
        $this->authorize('view', $task);
        return $this->render('show', ['id' => $task->id]);
    }
}
