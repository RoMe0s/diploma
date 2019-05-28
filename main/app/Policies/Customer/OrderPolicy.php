<?php

namespace App\Policies\Customer;

use App\Models\User;
use App\Models\Order\Order;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
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
     * @param Order $order
     * @return bool
     */
    public function view(User $user, Order $order): bool
    {
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
    public function update(User $user, Order $order): bool
    {
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
        if (!$order->canBeRolledBack()) {
            return false;
        }
        if ($order->relation_type === User::class) {
            return $order->relation_id == $user->id;
        }
        return $order->relation->user_id === $user->id;
    }
}
