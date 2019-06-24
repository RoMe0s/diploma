<?php

use App\Models\Plan\Block;
use App\Models\Plan\Key;
use App\Models\Plan\Plan;
use App\Models\Plan\SettingBlock;
use App\Models\User;
use App\Models\Project;
use App\Constants\Role;
use App\Models\Order\Order;
use Illuminate\Database\Seeder;
use App\Models\Task\Task;

class AuthorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 5)->create(['role' => Role::AUTHOR])
            ->each(function (User $author) {
                factory(User::class)->create(['role' => Role::CUSTOMER])
                    ->each(function (User $customer) use ($author) {
                        factory(Project::class, 2)->create(['user_id' => $customer->id])
                            ->each(function (Project $project) use ($author) {
                                factory(Order::class, 2)
                                    ->create(['relation_type' => get_class($project), 'relation_id' => $project->id])
                                    ->each(function (Order $order) use ($author) {
                                        $plan = factory(Plan::class)->create(['order_id' => $order->id]);
                                        foreach (range(1, 2) as $position) {
                                            factory(Block::class)->create(['plan_id' => $plan->id, 'position' => $position])
                                                ->each(function (Block $block) {
                                                    factory(Key::class, 2)->create(['block_id' => $block->id]);
                                                    factory(SettingBlock::class, 2)->create(['block_id' => $block->id]);
                                                });
                                        }

                                        factory(Task::class)->create([
                                            'user_id' => $author->id,
                                            'order_id' => $order->id,
                                            'status' => \App\Constants\Status\Task::WRITING,
                                            'expired_at' => now()->addHours($order->estimate)
                                        ]);
                                    });
                            });
                    });
            });
    }
}
