<?php

use App\Models\User;
use App\Constants\Role;
use App\Models\Project;
use App\Models\Plan\Plan;
use App\Models\Plan\Block;
use App\Models\Order\Order;
use App\Models\Plan\Key;
use App\Models\Plan\SettingBlock;
use Illuminate\Database\Seeder;

class CustomersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 1)->create(['role' => Role::CUSTOMER, 'email' => 'customer@gmail.com'])
            ->each(function (User $customer) {
                factory(Project::class, 1)->create(['user_id' => $customer->id])
                    ->each(function (Project $project) {
                        factory(Order::class, 3)
                            ->create(['relation_type' => get_class($project), 'relation_id' => $project->id])
                            ->each(function (Order $order) {
                                factory(Plan::class, 1)->create(['order_id' => $order->id])
                                    ->each(function (Plan $plan) {
                                        foreach (range(1, 2) as $position) {
                                            factory(Block::class, 1)->create(['plan_id' => $plan->id, 'position' => $position])
                                                ->each(function (Block $block) {
                                                    factory(Key::class, 2)->create(['block_id' => $block->id]);
                                                    factory(SettingBlock::class, 2)->create(['block_id' => $block->id]);
                                                });
                                        }
                                    });
                            });
                    });
            });
    }
}
