<?php

namespace App\Services\Handlers\Customer\Project;

use App\Models\Project;

class Update
{
    public function update(Project $project, array $data): void
    {
        $project->update(['name' => $data['name']]);
    }
}