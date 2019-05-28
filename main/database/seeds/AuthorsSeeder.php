<?php

use App\Models\User;
use App\Constants\Role;
use Illuminate\Database\Seeder;

class AuthorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 5)->create(['role' => Role::AUTHOR]);
    }
}
