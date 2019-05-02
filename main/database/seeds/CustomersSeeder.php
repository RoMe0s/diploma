<?php

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
        factory(\App\Models\Customer::class, 5)->create()
            ->each(function (\App\Models\Customer $customer) {
                factory(\App\Models\Project::class, 1000)->create([
                    'customer_id' => $customer->id
                ]);
            });
    }
}
