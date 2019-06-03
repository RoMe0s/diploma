<?php

namespace App\Services\Handlers\Author\Profile;

use App\Models\User;

class Update
{
    /**
     * @param User $user
     * @param array $data
     */
    public function update(User $user, array $data): void
    {
        $user->update(['email' => $data['email'], 'name' => $data['name']]);
    }
}