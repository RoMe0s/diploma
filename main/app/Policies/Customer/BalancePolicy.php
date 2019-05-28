<?php

namespace App\Policies\Customer;

use App\Models\User;
use App\Models\Balance\Balance;
use Illuminate\Auth\Access\HandlesAuthorization;

class BalancePolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @return bool
     */
    public function before(User $user)
    {
        if (!$user->isCustomer()) {
            return false;
        }
    }

    /**
     * @param User $user
     * @param Balance $balance
     * @return bool
     */
    public function update(User $user, Balance $balance): bool
    {
        return $user->id === $balance->user_id;
    }
}
