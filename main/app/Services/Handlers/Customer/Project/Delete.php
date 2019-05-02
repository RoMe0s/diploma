<?php

namespace App\Services\Handlers\Customer\Project;

use App\Models\Project;

class Delete
{
    /**
     * @param $projects
     */
    public function delete($projects): void
    {
        $projects = is_array($projects) ? $projects : [$projects];
        Project::query()->whereIn('id', $projects)->delete();
    }
}