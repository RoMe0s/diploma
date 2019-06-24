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
use App\Models\Order\Commit;
use App\Models\Text;

class AuthorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 1)->create(['role' => Role::AUTHOR, 'email' => 'author@gmail.com'])
            ->each(function (User $author) {
                factory(Text::class, 1)->create()
                    ->each(function (Text $text) use ($author) {
                        factory(User::class, 1)->create(['role' => Role::CUSTOMER])
                            ->each(function (User $customer) use ($text, $author) {
                                factory(Project::class, 1)->create(['user_id' => $customer->id])
                                    ->each(function (Project $project) use ($text, $author) {
                                        factory(Order::class, 1)->create(['relation_type' => get_class($project), 'relation_id' => $project->id])
                                            ->each(function (Order $order) use ($text, $author) {
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

                                                factory(Task::class, 1)->create([
                                                    'text_id' => $text->id,
                                                    'user_id' => $author->id,
                                                    'order_id' => $order->id,
                                                    'status' => \App\Constants\Status\Task::WRITING,
                                                    'expired_at' => now()->addHours($order->estimate)
                                                ])->each(function (Task $task) use ($order) {
                                                    factory(Commit::class, 1)->create([
                                                        'status' => \App\Constants\Status\Commit::WRITING,
                                                        'user_id' => $task->user_id,
                                                        'order_id' => $order->id
                                                    ]);
                                                });
                                            });
                                    });
                            });
                    });
            });
    }
}
