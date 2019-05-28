<?php

namespace App\Services\Handlers\Customer\Profile;

use App\Models\User;

class Password
{
    /**
     * @param User $user
     * @param string $password
     */
    public function change(User $user, string $password): void
    {
        $user->update(['password' => bcrypt($password)]);
    }
}
