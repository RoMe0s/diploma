<?php

namespace App\Services\Handlers\Customer\Order;

use App\Models\User;
use App\Models\Project;
use App\Models\Plan\Plan;
use App\Models\Plan\Block;
use App\Models\Order\Order;
use App\Constants\Plan\Heading;
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
            $this->newPlanInstance($order, $data['plan']);
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
            'estimate' => $data['estimate'],
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
        $order->save();
        return $order;
    }

    /**
     * @param Order $order
     * @param array $data
     */
    private function newPlanInstance(Order $order, array $data): void
    {
        $plan = $order->plan()->create([
            'size_from' => $data['sizes']['from'],
            'size_to' => $data['sizes']['to']
        ]);
        $this->appendBlocks($plan, $data);
    }

    /**
     * @param Plan $plan
     * @param array $data
     */
    private function appendBlocks(Plan $plan, array $data): void
    {
        $blocks = $data['blocks'] ?? [];
        if ($openingBlock = $data['openingBlock'] ?? null) {
            $openingBlock['heading'] = Heading::OPENING;
            $this->appendBlock($plan, $openingBlock);
        }
        foreach ($blocks as $index => $block) {
            $block['position'] = $index + 1;
            $this->appendBlock($plan, $block);
        }
    }

    /**
     * @param Plan $plan
     * @param array $data
     */
    private function appendBlock(Plan $plan, array $data): void
    {
        $block = $plan->blocks()->create([
            'heading' => $data['heading'],
            'name' => $data['name'] ?? null,
            'size_to' => $data['sizes']['to'],
            'position' => $data['position'] ?? 0,
            'size_from' => $data['sizes']['from'],
            'description' => $data['description']
        ]);
        foreach ($data['settings'] ?? [] as $setting) {
            $this->appendSettingBlock($block, $setting);
        }
        foreach ($data['keys'] ?? [] as $key) {
            $this->appendKey($block, $key);
        }
    }

    /**
     * @param Block $block
     * @param array $data
     */
    private function appendSettingBlock(Block $block, array $data): void
    {
        $block->settingBlocks()->create([
            'type' => $data['type'],
            'min' => $data['min'],
            'max' => $data['max']
        ]);
    }

    /**
     * @param Block $block
     * @param array $data
     */
    private function appendKey(Block $block, array $data): void
    {
        $block->keys()->create([
            'type' => $data['type'],
            'value' => $data['value'],
            'count' => $data['count']
        ]);
    }
}