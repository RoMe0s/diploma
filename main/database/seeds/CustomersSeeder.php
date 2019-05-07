<?php

use App\Models\User;
use App\Constants\Role;
use App\Models\Project;
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
        factory(User::class, 5)->create(['role' => Role::CUSTOMER])
            ->each(function (User $customer) {
                factory(Project::class, 1000)->create([
                    'user_id' => $customer->id
                ]);
            });
    }
}
