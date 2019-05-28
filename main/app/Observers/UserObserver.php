<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * @param User $user
     */
    public function created(User $user)
    {
        $user->balance()->create();
    }
}
