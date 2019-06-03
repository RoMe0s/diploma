<?php

namespace App\Providers;

use App\Models\Task;
use App\Models\Project;
use App\Models\Order\Order;
use App\Policies\OrderPolicy;
use App\Models\Balance\Balance;
use App\Policies\BalancePolicy;
use App\Policies\Author\TaskPolicy;
use App\Policies\Customer\ProjectPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Project::class => ProjectPolicy::class,
        Balance::class => BalancePolicy::class,
        Order::class => OrderPolicy::class,
        Task::class => TaskPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
