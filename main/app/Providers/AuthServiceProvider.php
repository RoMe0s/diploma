<?php

namespace App\Providers;

use App\Models\Project;
use App\Models\Order\Order;
use App\Models\Balance\Balance;
use App\Policies\Customer\OrderPolicy;
use App\Policies\Customer\ProjectPolicy;
use App\Policies\Customer\BalancePolicy;
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
        Order::class => OrderPolicy::class
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
