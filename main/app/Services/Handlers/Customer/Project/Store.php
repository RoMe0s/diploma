<?php

namespace App\Services\Handlers\Customer\Project;

use App\Models\Project;
use App\Models\User;

class Store
{
    /**
     * @param array $data
     * @param User $user
     * @return Project
     */
    public function store(array $data, User $user): Project
    {
        return Project::query()->create([
            'user_id' => $user->id,
            'name' => $data['name']
        ]);
    }
}