<?php

namespace App\Http\Controllers\Web\Author;

use App\Models\Task;
use App\Http\Controllers\Web\Controller;

class TaskController extends Controller
{
    /**
     * @return string
     */
    protected function viewPath(): string
    {
        return 'author.tasks';
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
    public function edit(Task $task)
    {
        $this->authorize('view', $task);
        return $this->render('edit', ['id' => $task->id]);
    }
}