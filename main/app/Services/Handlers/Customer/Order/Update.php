<?php

namespace App\Services\Handlers\Customer\Order;

use App\Models\User;
use App\Models\Project;
use App\Models\Plan\Plan;
use App\Models\Plan\Block;
use App\Models\Order\Order;
use App\Constants\Plan\Heading;
use Illuminate\Support\Facades\DB;

class Update
{
    /**
     * @param Order $order
     * @param User $user
     * @param array $data
     */
    public function update(Order $order, User $user, array $data): void
    {
        DB::transaction(function () use ($order, $user, $data) {
            $this->updateOrder($order, $user, $data);
            $this->updatePlan($order, $data['plan']);
        });
    }

    /**
     * @param Order $order
     * @param User $user
     * @param array $data
     */
    private function updateOrder(Order $order, User $user, array $data): void
    {
        $order->fill([
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
    }

    /**
     * @param Order $order
     * @param array $data
     */
    private function updatePlan(Order $order, array $data): void
    {
        $order->plan->update([
            'size_from' => $data['sizes']['from'],
            'size_to' => $data['sizes']['to']
        ]);
        $this->updateBlocks($order->plan, $data);
    }

    /**
     * @param Plan $plan
     * @param array $data
     */
    private function updateBlocks(Plan $plan, array $data): void
    {
        $blockIds = [];
        $blocks = $data['blocks'] ?? [];
        if ($openingBlock = $data['openingBlock'] ?? null) {
            $openingBlock['heading'] = Heading::OPENING;
            $blockIds[] = $this->updateBlock($plan, $openingBlock);
        }
        foreach ($blocks as $index => $block) {
            $block['position'] = $index + 1;
            $blockIds[] = $this->updateBlock($plan, $block);
        }
        if ($closingBlock = $data['closingBlock'] ?? null) {
            $closingBlock['position'] = count($blocks) + 1;
            $closingBlock['heading'] = Heading::CLOSING;
            $blockIds[] = $this->updateBlock($plan, $closingBlock);
        }
        $plan->blocks()->whereNotIn('id', $blockIds)->delete();
    }

    /**
     * @param Plan $plan
     * @param array $data
     * @return int
     */
    private function updateBlock(Plan $plan, array $data): int
    {
        $block = $plan->blocks()->updateOrCreate([
            'position' => $data['position'] ?? 0
        ], [
            'heading' => $data['heading'],
            'name' => $data['name'] ?? null,
            'size_to' => $data['sizes']['to'],
            'size_from' => $data['sizes']['from'],
            'description' => $data['description']
        ]);

        $settingIds = [];
        foreach ($data['settings'] ?? [] as $setting) {
            $settingIds[] = $this->updateSettingBlock($block, $setting);
        }
        $block->settingBlocks()->whereNotIn('id', $settingIds)->delete();

        $keyIds = [];
        foreach ($data['keys'] ?? [] as $key) {
            $keyIds[] = $this->updateKey($block, $key);
        }
        $block->keys()->whereNotIn('id', $keyIds)->delete();

        return $block->id;
    }

    /**
     * @param Block $block
     * @param array $data
     * @return int
     */
    private function updateSettingBlock(Block $block, array $data): int
    {
        $settingBlock = $block->settingBlocks()->updateOrCreate([
            'type' => $data['type'],
            'min' => $data['min'],
            'max' => $data['max']
        ]);
        return $settingBlock->id;
    }

    /**
     * @param Block $block
     * @param array $data
     * @return int
     */
    private function updateKey(Block $block, array $data): int
    {
        $key = $block->keys()->updateOrCreate([
            'type' => $data['type'],
            'value' => $data['value'],
            'count' => $data['count']
        ]);
        return $key->id;
    }
}