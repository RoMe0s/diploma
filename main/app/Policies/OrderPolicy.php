<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Order\Order;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param Order $order
     * @return bool
     */
    public function view(User $user, Order $order): bool
    {
        if ($user->isCustomer()) {
            if ($order->relation_type === User::class) {
                return $order->relation_id == $user->id;
            }
            return $order->relation->user_id === $user->id;
        }
    }

    /**
     * @param User $user
     * @param Order $order
     * @return bool
     */
    public function update(User $user, Order $order): bool
    {
        if (!$user->isCustomer()) {
            return false;
        }
        if (!$order->canBePublished()) {
            return false;
        }
        if ($order->relation_type === User::class) {
            return $order->relation_id == $user->id;
        }
        return $order->relation->user_id === $user->id;
    }

    /**
     * @param User $user
     * @param Order $order
     * @return bool
     */
    public function delete(User $user, Order $order): bool
    {
        if (!$user->isCustomer()) {
            return false;
        }
        if (!$order->canBePublished()) {
            return false;
        }
        if ($order->relation_type === User::class) {
            return $order->relation_id == $user->id;
        }
        return $order->relation->user_id === $user->id;
    }

    /**
     * @param User $user
     * @param Order $order
     * @return bool
     */
    public function rollback(User $user, Order $order): bool
    {
        if (!$user->isCustomer()) {
            return false;
        }
        if (!$order->canBeRolledBack()) {
            return false;
        }
        if ($order->relation_type === User::class) {
            return $order->relation_id == $user->id;
        }
        return $order->relation->user_id === $user->id;
    }

    /**
     * @param User $user
     * @param Order $order
     * @return bool
     */
    public function append(User $user, Order $order): bool
    {
        if (!$user->isAuthor()) {
            return false;
        }
        return $order->canBeRolledBack() && $order->commits()->where('user_id', $user->id)->doesntExist();
    }
}