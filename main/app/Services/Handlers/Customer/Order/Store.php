<?php

namespace App\Services\Handlers\Customer\Order;

use App\Models\User;
use App\Models\Order\Order;
use App\Models\Project;
use Illuminate\Support\Facades\DB;

class Store
{
    /**
     * @param array $data
     * @param User $user
     * @return Order
     */
    public function store(array $data, User $user): Order
    {
        $order = $this->newOrderInstance($data, $user);
        return DB::transaction(function () use ($order, $data) {
            $order->save();

            //TODO: save relations

            return $order;
        });
    }

    /**
     * @param array $data
     * @param User $user
     * @return Order
     */
    private function newOrderInstance(array $data, User $user): Order
    {
        $order = new Order([
            'description' => $data['description'],
            'price' => $data['price'],
            'name' => $data['name']
        ]);
        if (key_exists('project_id', $data) && $data['project_id']) {
            $order->fill([
                'relation_type' => Project::class,
                'relation_id' => $data['project_id']
            ]);
        } else {
            $order->fill([
                'relation_type' => User::class,
                'relation_id' => $user->id
            ]);
        }
        return $order;
    }
}
