<?php

namespace App\Http\Controllers\Check;

use App\Models\Task\Task;
use App\Http\Controllers\Api\Controller;
use App\Http\Requests\Check\SaveRequest;
use App\Services\Handlers\Author\Task\Director;

class CheckController extends Controller
{
    /**
     * @param Task $task
     * @param SaveRequest $request
     * @param Director $director
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Task $task, SaveRequest $request, Director $director)
    {
        $director->apply($task, $request->all());
        return response()->json();
    }
}
